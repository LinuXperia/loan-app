<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendAgentAccountDetails extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var
     */
    private $user;
    /**
     * @var
     */
    private $password;

    /**
     * Create a new message instance.
     *
     * @param $user
     * @param $password
     */
    public function __construct($user,$password)
    {
        //
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = [
            'user' => $this->user,
            'password' =>$this->password
        ];
        return $this
            ->from('admin@firstlinecredit.com')
            ->subject('Agent Account Registration')
            ->markdown('admin.mail.agentAccount', $data);
    }
}
