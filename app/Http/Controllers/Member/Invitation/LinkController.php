<?php

namespace App\Http\Controllers\Member\Invitation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Member\Invitation\Link;
use App\Http\Requests\Member\Invitation\Link\SaveForm;
use Carbon\Carbon;
use Auth;

class LinkController extends Controller
{
    public function store(SaveForm $request)
    {
        $data = $request->only('expire');
        $expired_at = null;
        if (isset($data['expire']) && is_numeric($data['expire'])) {
            $expired_at = Carbon::now();
            $expired_at->addDays($data['expire']);    
        }

        $organization = Auth::user()->selectedOrganization();
        $invitation_link = $organization->member_invitation_links()->create([
            'organization_id'   => $organization->id,
            'token'             => Link::generateToken(),
            'expired_at'        => $expired_at,
        ]);
        return redirect()->back()->with('invitation_link', route('invitation.member.register', [$invitation_link->token]));

    }
}
