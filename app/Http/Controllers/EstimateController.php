<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Estimate\SaveForm;
use App\Http\Requests\Estimate\SearchForm;
use App\Models\User;
use App\Models\Estimate;
use App\Models\Estimate\Item;
use Auth;
use Lang;

class EstimateController extends Controller
{

    const SEARCH_SESSION_KEY = 'estimate.search';
    const SELECTION_ID_SESSION_KEY = 'estimate.selection.id';


    public function index(SearchForm $request)
    {
        $condition = $request->isMethod('post') ? $request->all() : $request->session()->get(static::SEARCH_SESSION_KEY, []);
        $request->session()->put(static::SEARCH_SESSION_KEY, $condition);
        
        $user = Auth::user();
        $estimates = $user->selectedOrganization()
            ->estimates()
            ->searchByCondition($condition)
            ->orderBy('id', 'desc')
            ->paginate(20);

        return view('estimate.index', [
            'condition'     => $condition,
            'estimates'     => $estimates,
            'selections'    => $request->session()->get(static::SELECTION_ID_SESSION_KEY, [])
        ]);
    }

    public function create()
    {
        $user = Auth::user();
        $organization = $user->selectedOrganization();

        $estimate = new Estimate(['organization_id' => $organization->id]);
        $estimate->generateEstimateNo();
        $estimate->items->add(new Item());

        $clientOptions = $organization
            ->clients()
            ->pluck('name', 'id');

        $sourceOptions = $organization
            ->sources()
            ->pluck('name', 'id');


        return view('estimate.create', [
            'estimate' => $estimate,
            'clientOptions' => $clientOptions,
            'sourceOptions' => $sourceOptions,
        ]);
    }

    public function store(SaveForm $request)
    {
        $organization = Auth::user()->selectedOrganization();
        $data = $request->all();

        $client = $organization->clients()->firstOrCreate(['name' => $data['recipient']]);
        $data['client_id'] = $client->id;

        $source = $organization->sources()->firstOrCreate(['name' => $data['sender']]);
        $data['source_id'] = $source->id;
        $estimate = $organization->estimates()->create(['organization_id' => $organization->id] + $data);

        $subtotal = 0;
        $tax = 0;
        foreach ($request->only('items')['items'] as $form) {
            $item = isset($form['id']) ? $estimate->items()->find($form['id']) : new Item(['estimate_id' => $estimate->id]);
            if ((empty($form['name']) && empty($form['price']) && empty($form['quantity'])) || $form['_delete']) {
                $item->delete();
            } else {
                $item->fill($form)->save();

                $subtotal += intval($item->price);
                if ($estimate->in_tax) $tax += (floatval($item->price) * $estimate->tax_rate / 100);
            }
        }

        $estimate->subtotal = $subtotal;
        $estimate->tax = $tax;
        $estimate->total = $subtotal + $tax;
        $estimate->save();

        return redirect()->route('estimate.index')->with('success', Lang::get('common.registrationd_has_been_completed'));
    }

    public function edit($id)
    {
        $organization = Auth::user()->selectedOrganization();
        
        $clientOptions = $organization
            ->clients()
            ->pluck('name', 'id');

        $sourceOptions = $organization
            ->sources()
            ->pluck('name', 'id');

        $estimate = $organization->estimates()->find($id);
        return view('estimate.edit', [
            'estimate' => $estimate,
            'clientOptions' => $clientOptions,
            'sourceOptions' => $sourceOptions,
        ]);
    }

    public function update(SaveForm $request, $id)
    {
        $organization = Auth::user()->selectedOrganization();
        $data = $request->all();

        $estimate = $organization->estimates()->find($id);

        $subtotal = 0;
        $tax = 0;
        foreach ($request->only('items')['items'] as $form) {
            $item = isset($form['id']) ? $estimate->items()->find($form['id']) : new Item(['estimate_id' => $estimate->id]);
            if ((empty($form['name']) && empty($form['price']) && empty($form['quantity'])) || $form['_delete']) {
                $item->delete();
            } else {
                $item->fill($form)->save();

                $subtotal += intval($item->price);
                if ($estimate->in_tax) $tax += (floatval($item->price) * $estimate->tax_rate / 100);
            }
        }

        $client = $organization->clients()->firstOrCreate(['name' => $data['recipient']]);
        $data['client_id'] = $client->id;

        $source = $organization->sources()->firstOrCreate(['name' => $data['sender']]);
        $data['source_id'] = $source->id;

        $estimate->fill($data);
        $estimate->subtotal = $subtotal;
        $estimate->tax = $tax;
        $estimate->total = $subtotal + $tax;
        $estimate->save();

        return redirect()->route('estimate.index')->with('success', Lang::get('common.update_has_been_completed'));
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $estimate = $user->selectedOrganization()->estimates()->find($id);
        if ($estimate) {
            $estimate->delete();
        }
        return redirect()->route('estimate.index')->with('success', Lang::get('common.delete_has_been_completed'));
    }
}
