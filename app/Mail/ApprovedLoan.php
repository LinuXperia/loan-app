<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ApprovedLoan extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var
     */
    public $loan;

    /**
     * Create a new message instance.
     *
     * @param $loan
     */
    public function __construct($loan)
    {
        //
        $this->loan = $loan;
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
            ->subject('Loan Approval')
            ->markdown('loans.mails.ApprovedLoan');
    }
}
