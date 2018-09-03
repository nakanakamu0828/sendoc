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
use App\UseCases\InvitedUser;
use App\Repositories\Interfaces\Member\Invitation\LinkRepositoryInterface;

class MemberController extends Controller
{

    private $linkRepository;

    public function __construct(LinkRepositoryInterface $linkRepository)
    {
        $this->linkRepository = $linkRepository;
    }


    public function create($token)
    {
        return view('invitation.member.register', [
            'member_invitation_link' => $this->linkRepository->findByToken($token)
        ]);
    }

    public function store(InvitedUser $usecase, RegisterForm $request, $token)
    {
        $user = $usecase($token, $request->all());
        \Auth::login($user);

        return redirect()->route('dashboard');
    }
}
