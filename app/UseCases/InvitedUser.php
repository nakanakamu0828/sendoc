<?php
declare(strict_types=1);

namespace App\UseCases;

use App\Models\Member\Invitation\Link;
use App\Models\User;
use App\Models\User\Profile;
use App\Models\Member;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Repositories\Interfaces\Member\Invitation\LinkRepositoryInterface;
use Carbon\Carbon;
use DB;

class InvitedUser
{

    private $linkRepository;

    public function __construct(LinkRepositoryInterface $linkRepository)
    {
        $this->linkRepository = $linkRepository;
    }

    /**
     * @param array $data
     * @return User
     */
    public function __invoke(string $token, array $data): User
    {
        return DB::transaction(function () use($token, $data) {

            $link = $this->linkRepository->findByToken($token);

            $user = User::create([
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'verified' => $link->email && $data['email']
            ]);
            $user->profile()->save(new Profile([ 'name' => $data['name'] ]));

            Member::create([
                'organization_id' => $link->organization->id,
                'user_id' => $user->id,
                'role' => 'user',
                'selected' => true
            ]);

            if ($link->email) $link->delete();

            return $user;
        });
    }
}
