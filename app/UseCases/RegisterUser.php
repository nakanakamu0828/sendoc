<?php
declare(strict_types=1);

namespace App\UseCases;

use App\Models\User;
use App\Models\User\Profile;
use App\Models\Organization;
use App\Models\Member;
use Illuminate\Support\Facades\Hash;
use DB;

class RegisterUser
{

    /**
     * @param array $data
     * @return User
     */
    public function __invoke(array $data): User
    {
        return DB::transaction(function () use($data) {

            $organization = Organization::create([
                'name' => $data['organization_name'],
            ]);

            $user = User::create([
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'email_token' => User::generateEmailToken()
            ]);
            $user->profile()->save(new Profile([ 'name' => $data['name'] ]));
        
            Member::create([
                'organization_id' => $organization->id,
                'user_id' => $user->id,
                'role' => 'admin',
                'selected' => true
            ]);

            return $user;
        });
    }
}
