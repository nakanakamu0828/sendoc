<?php
declare(strict_types=1);

namespace App\UseCases;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use DB;

class VerifyUser
{

    /**
     * @param array $data
     * @return User
     */
    public function __invoke(string $token): User
    {
        return DB::transaction(function () use($data) {

            $user = User::where('email_token', $token)->firstOrFail();
            $user->verified = 1;
            $user->save();
    
            return $user;
        });
    }
}
