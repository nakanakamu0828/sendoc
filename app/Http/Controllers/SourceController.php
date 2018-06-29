<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Source\SaveForm;
use App\Http\Requests\Source\SearchForm;
use App\Models\Source;
use App\Models\Source\Payee;
use Auth;
use Lang;

class SourceController extends Controller
{

    const SEARCH_SESSION_KEY = 'source.search';

    public function index(SearchForm $request)
    {
        $condition = $request->isMethod('post') ? $request->all() : $request->session()->get(static::SEARCH_SESSION_KEY, []);
        $request->session()->put(static::SEARCH_SESSION_KEY, $condition);
        
        $user = Auth::user();
        $sources = $user->selectedOrganization()
            ->sources()
            ->searchByCondition($condition)
            ->orderBy('id', 'desc')
            ->paginate(20);

        return view('source.index', [
            'condition'     => $condition,
            'sources'       => $sources,
        ]);
    }

    public function create()
    {
        $organization = Auth::user()->selectedOrganization();
        $source = new Source();
        $source->payees->add(new Payee());

        $memberOptions = $organization
            ->members()
            ->join('users', 'members.user_id', 'users.id')
            ->pluck('users.name');

        return view('source.create', [
            'source' => $source,
            'memberOptions' => $memberOptions,
        ]);
    }

    public function store(SaveForm $request)
    {
        $data = $request->only('name', 'contact_name', 'email', 'postal_code', 'address1', 'address2', 'address3');

        $organization = Auth::user()->selectedOrganization();
        $source = $organization->sources()->create(['organization_id' => $organization->id] + $data);

        foreach ($request->only('payees')['payees'] as $form) {
            $payee = isset($form['id']) ? $source->payees()->find($form['id']) : new Payee(['source_id' => $source->id]);
            if (empty($form['detail']) || $form['_delete']) {
                $payee->delete();
            } else {
                $payee->fill($form)->save();
            }
        }

        return redirect()->route('source.index')->with('success', Lang::get('common.registrationd_has_been_completed'));
    }

    public function edit($id)
    {
        $organization = Auth::user()->selectedOrganization();
        $source = $organization->sources()->find($id);

        if(0 === count($source->payees)) $source->payees->add(new Payee());


        $memberOptions = $organization
            ->members()
            ->join('users', 'members.user_id', 'users.id')
            ->pluck('users.name');

        return view('source.edit', [
            'source' => $source,
            'memberOptions' => $memberOptions,
        ]);
    }

    public function update(SaveForm $request, $id)
    {
        $data = $request->only('name', 'contact_name', 'email', 'postal_code', 'address1', 'address2', 'address3', 'remarks');

        $organization = Auth::user()->selectedOrganization();
        $source = $organization->sources()->find($id);
        $source->fill($data)->save();

        foreach ($request->only('payees')['payees'] as $form) {
            $payee = isset($form['id']) ? $source->payees()->find($form['id']) : new Payee(['source_id' => $source->id]);
            if (empty($form['detail']) || $form['_delete']) {
                $payee->delete();
            } else {
                $payee->fill($form)->save();
            }
        }

        return redirect()->route('source.index')->with('success', Lang::get('common.update_has_been_completed'));
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $source = $user->selectedOrganization()->sources()->find($id);
        if ($source) {
            $source->delete();
        }
        return redirect()->route('source.index')->with('success', Lang::get('common.delete_has_been_completed'));
    }
}
