<?php

namespace App\Http\Controllers;

use App\Http\Requests\MemberForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Member;
use Auth;
use Lang;

class MemberController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $members = $user->selectedOrganization()->members()->orderBy('id', 'desc')->paginate(20);
        return view('member.index', [
            'members'       => $members,
        ]);
    }

    public function create()
    {
        return view('member.create', []);
    }


    public function store(MemberForm $request)
    {
        $data = $request->only('name', 'email', 'password');
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $organization = Auth::user()->selectedOrganization();

        Member::create([
            'organization_id' => $organization->id,
            'user_id' => $user->id,
            'role' => 'user',
            'selected' => true
        ]);

        return redirect()->route('member.index')->with('success', Lang::get('common.registrationd_has_been_completed'));
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $member = $user->selectedOrganization()->members()->find($id);
        if ($member) {
            if(1 == $member->user->members()->count()) {
                // どの組織にも属さない場合、ユーザー毎削除
                $member->user->delete();
            } else {
                $member->delete();
            }
        }
        return redirect()->route('member.index')->with('success', Lang::get('common.delete_has_been_completed'));
    }
}
