<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ClientForm;
use App\Http\Requests\Client\SearchForm;
use App\Models\User;
use App\Models\Client;
use Auth;
use Lang;
use App\Repositories\Interfaces\ClientRepositoryInterface;

class ClientController extends Controller
{

    const SEARCH_SESSION_KEY = 'client.search';

    private $clientRepository;

    public function __construct(ClientRepositoryInterface $clientRepository)
    {
        $this->clientRepository = $clientRepository;
        $this->middleware(function ($request, $next) {
            $this->clientRepository->setUser(Auth::user());
            return $next($request);
        });
    }

    public function index(SearchForm $request)
    {
        $condition = $request->isMethod('post') ? $request->all() : $request->session()->get(static::SEARCH_SESSION_KEY, []);
        $request->session()->put(static::SEARCH_SESSION_KEY, $condition);
        $clients = $this->clientRepository->paginateByCondition($condition, 'id', 'desc', 20);
        return view('client.index', [
            'condition'     => $condition,
            'clients'       => $clients,
        ]);
    }

    public function create()
    {
        return view('client.create');
    }

    public function store(ClientForm $request)
    {
        $this->clientRepository->create($request->all());
        return redirect()->route('client.index')->with('success', Lang::get('common.registrationd_has_been_completed'));
    }

    public function edit($id)
    {
        return view('client.edit', [ 'client' => $this->clientRepository->find($id) ]);
    }

    public function update(ClientForm $request, $id)
    {
        $this->clientRepository->update($id, $request->all());
        return redirect()->route('client.index')->with('success', Lang::get('common.update_has_been_completed'));
    }

    public function destroy($id)
    {
        $this->clientRepository->delete($id);
        return redirect()->route('client.index')->with('success', Lang::get('common.delete_has_been_completed'));
    }
}
