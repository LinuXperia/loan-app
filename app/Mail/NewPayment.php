<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewPayment extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var
     */
    public $payment;
    /**
     * @var
     */
    private $pdf;

    /**
     * Create a new message instance.
     *
     * @param $payment
     * @param $pdf
     */
    public function __construct($payment, $pdf)
    {
        //
        $this->payment = $payment;
        $this->pdf = $pdf;
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
            ->subject('First Line Credit Loan Payment')
            ->attachData($this->pdf->output(), 'loan-payment-details.pdf', [
                'mime' => 'application/pdf',
            ])
            ->markdown('payments.mails.newPayment');
    }
}
