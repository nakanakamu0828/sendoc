<?php

namespace App\Http\Controllers\Invitation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Member\Invitation\Link;
use App\Models\User;
use App\Models\Member;
use App\Http\Requests\Invitation\Member\RegisterForm;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class MemberController extends Controller
{
    public function create($token)
    {
        $link = Link::where('token', $token)
            ->where(function($query){
                $query->where('expired_at', '>=', Carbon::now())->orWhereNull('expired_at');
            })
            ->first();
        if (empty($link)) {
            abort('404');
            return;
        }

        return view('invitation.member.register', [
            'member_invitation_link' => $link
        ]);
    }

    public function store(RegisterForm $request, $token)
    {
        $link = Link::where('token', $token)
            ->where(function($query){
                $query->where('expired_at', '>=', Carbon::now())->orWhereNull('expired_at');
            })
            ->first();
        if (empty($link)) {
            abort('404');
            return;
        }

        $data = $request->only('name', 'email', 'password');
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        Member::create([
            'organization_id' => $link->organization->id,
            'user_id' => $user->id,
            'role' => 'user',
            'selected' => true
        ]);

        \Auth::login($user);

        return redirect()->route('dashboard');
    }
}
