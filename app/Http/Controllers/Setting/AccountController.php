<?php

namespace App\Http\Controllers\Setting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\Account\UpdateForm;
use Illuminate\Support\Facades\Hash;
use Auth;
use Lang;

class AccountController extends Controller
{
    public function edit()
    {
        return view('setting.account.edit');
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
