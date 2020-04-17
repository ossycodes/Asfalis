<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Components\Sms\Facades\SMS;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendRegisterationCode implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $code = substr($this->user->password, 3, 5);  // bcd
        try {
            return SMS::to($this->user->phonenumber)->content("Your Registeration Code is {$code}")->send();
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}
