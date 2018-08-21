<?php

namespace App\Mail\Member;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Member\Invitation\Link;
use Lang;

class EmailInvitation extends Mailable
{
    use Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Link $link)
    {
        $this->data = [ 'link' => $link];
        $this->title = Lang::get('common.invited_from_:name', [ 'name' => $link->organization->name ]);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.member.invitation')
            ->subject($this->title)
            ->with($this->data);
    }
}
