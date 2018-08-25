<?php

namespace App\Http\Controllers\Setting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\Profile\UpdateForm;
use Illuminate\Support\Facades\Hash;
use App\Models\User\Profile;
use Auth;
use Lang;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('setting.profile.edit', [
            'profile' => Auth::user()->profile
        ]);
    }

    public function update(UpdateForm $request)
    {
        $data = $request->all();
        Auth::user()->profile->fill($data)->save();

        return redirect()->back()->with('success', Lang::get('common.update_has_been_completed'));
    }
}
