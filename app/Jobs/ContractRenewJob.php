<?php

namespace App\Jobs;

use App\Mail\PremiumInvoice;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContractRenewalReminder;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ContractRenewJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $contracts=\App\Models\Contract::where('end_date','=',\Carbon\Carbon::now()->format('d-m-Y'))
                                        ->whereNull('status')
                                        ->where(function($q){
                                            $q->whereIn('renewal_interval',['one_time','unlimited']);
                                        })
                                        ->orderBy('end_date','asc')->get();
    
        foreach ($contracts as $key => $contract) {
            if($contract->renewal_interval=='unlimited' || ($contract->renewal_interval=='one_time' && !$contract->renew_contracts->count()) ){
                $new_contract = $contract->replicate();
                $contract->status='COMPLETED';
                $contract->save();

                $new_contract->order_id = uniqid();
                $new_contract->start_date = $contract->getAttributes()['end_date'];
                $new_contract->end_date = \Carbon\Carbon::parse($contract->end_date)->addDays(\Carbon\Carbon::parse($contract->start_date)->diffInDays($contract->end_date))->format('d-m-Y');
                $new_contract->renewal_date =  $new_contract->getAttributes()['end_date'];
                $new_contract->renewal_reminder_date = \Carbon\Carbon::parse($new_contract->end_date)->subDays(\Carbon\Carbon::parse($contract->end_date)->diffInDays($contract->renewal_reminder_date))->format('d-m-Y');
                $new_contract->status = null;
                $new_contract->renew_from =$contract->id;
                $new_contract->save();

                // replicate media
                foreach($contract->media as $med)
                {
                    $new_contract->media()->create([
                        "contract_id" => $new_contract->id,
                        "file" => $med->file,
                        "orig_name" => $med->orig_name
                    ]);
                }
                
                // replicate categories
                foreach($contract->product_categories as $cat)
                {
                    $new_contract->product_categories()->create([
                        "contract_id" => $new_contract->id,
                        "product_category_id" => $cat->product_category_id,
                    ]);
                }

                createNotification(
                    "contract",
                    $new_contract->emp_id,
                    "Contract Renewed",
                    "Contract #".$new_contract->order_id." has been renewed",
                    [
                        "contract_id" => $new_contract->id,
                    ]
                );

                $data=[
                    'base_url' => url('/'),
                    'contract'=>$contract,
                ];

                try {
                    $email = new ContractRenewalReminder($data);
                    Mail::to($contract->emp->email)->send($email);
                } catch (\Exception $e) {
                    
                }
            }
        }
        
        
    }
}
