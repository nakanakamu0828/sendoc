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
        $data = $request->only('name', 'contact_name', 'email', 'postal_code', 'address1', 'address2', 'address3', 'remarks');

        $organization = Auth::user()->selectedOrganization();
        $organization->clients()->create(['organization_id' => $organization->id] + $data);
        return redirect()->route('client.index')->with('success', Lang::get('common.registrationd_has_been_completed'));
    }

    public function edit($id)
    {
        $organization = Auth::user()->selectedOrganization();
        $client = $organization->clients()->find($id);
        return view('client.edit', [
            'client' => $client
        ]);
    }

    public function update(ClientForm $request, $id)
    {
        $data = $request->only('name', 'contact_name', 'email', 'postal_code', 'address1', 'address2', 'address3', 'remarks');

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
