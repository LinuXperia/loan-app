<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ApprovedPayment extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var
     */
    public $payment;

    /**
     * Create a new message instance.
     *
     * @param $payment
     */
    public function __construct($payment)
    {
        //
        $this->payment = $payment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from('loans@firstlinecredit.co.ke')
            ->subject('Payment Approval')
            ->markdown('payments.mails.ApprovedPayment');
    }
}
