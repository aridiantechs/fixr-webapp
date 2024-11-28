<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Mail\ContractEndReminder;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ContractEndReminderJob implements ShouldQueue
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
        $intervals = \App\Models\Contract::getReminderContracts();
        foreach ($intervals as $key1 => $contracts) {
            foreach ($contracts as $key2 => $contract) {

                $data=[
                    'base_url' => url('/'),
                    'contract'=>$contract,
                    'remaining_time_period'=>$key1
                ];

                // try {
                    $email = new ContractEndReminder($data);
                    Mail::to($contract->emp->email)->send($email);
                /* } catch (\Throwable $th) {
                    
                } */
            }
        }
    }
}
