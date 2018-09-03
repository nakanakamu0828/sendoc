<?php

namespace App\Http\Controllers\Setting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\Profile\UpdateForm;
use Illuminate\Support\Facades\Hash;
use App\Models\User\Profile;
use Auth;
use Lang;
use Storage;

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
        $profile = Auth::user()->profile;

        $file = $request->file('file');
        if ($file) {
            if ($profile->image) Storage::delete($profile->image);
            $profile->image = $file->store('public/user/profile/image');
        } else {
            if($request->input('delete_image')) {
                if ($profile->image) Storage::delete($profile->image);
                $profile->image = null;
            }
        }
        $profile->fill($data)->save();

        return redirect()->back()->with('success', Lang::get('common.update_has_been_completed'));
    }
}
