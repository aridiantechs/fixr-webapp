<?php

namespace App\Jobs;

use App\Mail\PremiumInvoice;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ChargePremiumUserJob implements ShouldQueue
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
        $premium_user = \App\Models\User::where('is_premium',1)->whereHas('receipts', function($q){
                            $q->where('payment_status', 'UNPAID');
                        })
                        ->get()
                        ->take(10);
        // Send Emails
        foreach($premium_user as $user){
            $total_amount=$user->receipts->where('payment_status', 'UNPAID')->sum('total_including_vat');
            $total_posts=$user->receipts->where('payment_status', 'UNPAID')->sum('num_of_posts');

            $data=[
                'user'=>$user,
                'total_amount'=>$total_amount,
                'total_posts'=>$total_posts,
            ];

            try {
                $email = new PremiumInvoice($data);
                Mail::to($user->email)->send($email);

            } catch (\Throwable $th) {
                
            }
            
        }
        
    }
}
