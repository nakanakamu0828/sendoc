<?php

namespace App\Http\Controllers;

use App\Http\Requests\MemberForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Member;
use Auth;
use Lang;
use App\Repositories\Interfaces\MemberRepositoryInterface;


class MemberController extends Controller
{

    private $memberRepository;

    public function __construct(MemberRepositoryInterface $memberRepository)
    {
        $this->memberRepository = $memberRepository;
        $this->middleware(function ($request, $next) {
            $this->memberRepository->setUser(Auth::user());
            return $next($request);
        });
    }

    public function index()
    {
        $user = Auth::user();
        $members = $this->memberRepository->paginateByCondition([], 'id', 'desc', 20);
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
        $data = $request->all();
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $this->memberRepository->create([
            'user_id' => $user->id,
            'role' => 'user',
            'selected' => true
        ]);
        return redirect()->route('member.index')->with('success', Lang::get('common.registrationd_has_been_completed'));
    }

    public function destroy($id)
    {
        $this->memberRepository->delete($id);
        return redirect()->route('member.index')->with('success', Lang::get('common.delete_has_been_completed'));
    }
}
