<?php

namespace App\Http\Controllers\Setting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\Account\UpdateForm;
use Illuminate\Support\Facades\Hash;
use App\Models\User\Profile;
use Auth;
use Lang;

class ProfileController extends Controller
{
    public function edit()
    {
        $profile = $user->profile ?? new Profile();
        return view('setting.profile.edit', [
            'profile' => $profile
        ]);
    }

    public function update(UpdateForm $request)
    {
        $data = $request->only('email', 'password');
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }
        Auth::user()->fill($data)->save();

        return redirect()->back()->with('success', Lang::get('common.update_has_been_completed'));
    }
}
