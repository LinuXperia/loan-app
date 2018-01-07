<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewLoan extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var
     */
    public $loan;
    /**
     * @var
     */
    private $pdf;

    /**
     * Create a new message instance.
     *
     * @param $loan
     * @param $pdf
     */
    public function __construct($loan, $pdf)
    {
        //
        $this->loan = $loan;
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
            ->subject('First Line Credit Loan')
            ->attachData($this->pdf->output(), 'loan-details.pdf', [
                'mime' => 'application/pdf',
            ])
            ->markdown('loans.mails.newLoan');
    }
}
