<?php

namespace Mvaliolahi\Auth\Jobs;


use Mvaliolahi\Auth\Contracts\ShortMessageService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendSMSJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var ShortMessageService
     */
    protected $sms;

    /**
     * @var string
     */
    protected $number;

    /**
     * @var string
     */
    protected $message;

    public function __construct($number, $message = "")
    {
        $this->sms = app(ShortMessageService::class);
        $this->number = $number;
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        return $this->sms->send($this->number, "Verification code: " .  $this->message);
    }
}
