<?php

namespace App\Http\Controllers\Member\Invitation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Member\Invitation\Link;
use App\Http\Requests\Member\Invitation\Email\SaveForm;
use Carbon\Carbon;
use Auth;
use Lang;

class EmailController extends Controller
{
    public function store(SaveForm $request)
    {
        $data = $request->only('emails');
        $emails = explode(',', $data['emails']);

        $errors = [];
        foreach($emails as $email) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['emails'][] = Lang::get('validation.email', [ 'attribute' => $email ]);
            }
        }

        if (!empty($errors)) {
            $request->flash();
            return redirect()->back()->withErrors($errors);
        }

        $organization = Auth::user()->selectedOrganization();

        foreach($emails as $email) {
            $invitation_link = $organization->member_invitation_links()->create([
                'organization_id'   => $organization->id,
                'token'             => Link::generateToken(),
                'email'             => $email
            ]);

            // メール送信
        }

        return redirect()->back()->with('success', '招待メールが送信されました。');
    }
}
