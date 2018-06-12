<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ClientForm;
use App\Http\Requests\Client\SearchForm;
use App\Models\User;
use App\Models\Client;
use Auth;
use Lang;

class ClientController extends Controller
{

    const SEARCH_SESSION_KEY = 'client.search';
    const SELECTION_ID_SESSION_KEY = 'client.selection.id';

    public function index(SearchForm $request)
    {
        $condition = $request->isMethod('post') ? $request->all() : $request->session()->get(static::SEARCH_SESSION_KEY, []);
        $request->session()->put(static::SEARCH_SESSION_KEY, $condition);
        
        $user = Auth::user();
        $clients = $user->selectedOrganization()
            ->clients()
            ->searchByCondition($condition)
            ->orderBy('id', 'desc')
            ->paginate(20);

        $memberOptions = Auth::user()->selectedOrganization()
            ->members()
            ->join('users', 'users.id', '=', 'members.user_id')
            ->pluck('users.name', 'users.id');

        return view('client.index', [
            'condition'     => $condition,
            'clients'       => $clients,
            'memberOptions' => $memberOptions,
            'selections'    => $request->session()->get(static::SELECTION_ID_SESSION_KEY, [])
        ]);
    }

    public function create()
    {
        $memberOptions = Auth::user()->selectedOrganization()->members()->join('users', 'users.id', '=', 'members.user_id')->pluck('users.name', 'users.id');
        return view('client.create', [ 'memberOptions' => $memberOptions ]);
    }

    public function store(ClientForm $request)
    {
        $data = $request->only('name', 'contact_name', 'email', 'user_id', 'client_type', 'remarks');

        $organization = Auth::user()->selectedOrganization();
        $organization->clients()->create(['organization_id' => $organization->id] + $data);
        return redirect()->route('client.index')->with('success', Lang::get('common.registrationd_has_been_completed'));
    }

    public function selection(Request $request)
    {
        $ids = array_merge($request->input('selection', []), $request->session()->get(static::SELECTION_ID_SESSION_KEY, []));
        $request->session()->put(static::SELECTION_ID_SESSION_KEY, $ids);
        return back()->with('success', Lang::get('common.update_has_been_completed'));
    }

    public function edit($id)
    {
        $organization = Auth::user()->selectedOrganization();
        $client = $organization->clients()->find($id);
        $memberOptions = $organization->members()->join('users', 'users.id', '=', 'members.user_id')->pluck('users.name', 'users.id');
        return view('client.edit', [ 'client' => $client, 'memberOptions' => $memberOptions ]);
    }

    public function update(ClientForm $request, $id)
    {
        $data = $request->only('name', 'contact_name', 'email', 'user_id', 'client_type', 'remarks');

        $organization = Auth::user()->selectedOrganization();
        $client = $organization->clients()->find($id);
        $client->fill($data)->save();
        return redirect()->route('client.index')->with('success', Lang::get('common.update_has_been_completed'));
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $client = $user->selectedOrganization()->clients()->find($id);
        if ($client) {
            $client->delete();
        }
        return redirect()->route('client.index')->with('success', Lang::get('common.delete_has_been_completed'));
    }
}
