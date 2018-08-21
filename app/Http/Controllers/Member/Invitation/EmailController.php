<?php

namespace App\Http\Controllers\Member\Invitation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Member\Invitation\Link;
use App\Http\Requests\Member\Invitation\Email\SaveForm;
use Carbon\Carbon;
use Auth;
use Lang;
use Mail;

class EmailController extends Controller
{
    public function store(SaveForm $request)
    {
        $emails = array_filter($request->only('emails')['emails']);
        $organization = Auth::user()->selectedOrganization();

        foreach($emails as $email) {
            $invitation_link = $organization->member_invitation_links()->create([
                'organization_id'   => $organization->id,
                'token'             => Link::generateToken(),
                'email'             => $email
            ]);

            Mail::to($email)->send(new \App\Mail\Member\EmailInvitation($invitation_link));
        }

        return redirect()->back()->with('success', '招待メールが送信されました。');
    }
}
