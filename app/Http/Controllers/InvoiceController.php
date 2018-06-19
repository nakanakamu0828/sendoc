<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Invoice\SaveForm;
use App\Http\Requests\Invoice\SearchForm;
use App\Models\User;
use App\Models\Invoice;
use App\Models\Invoice\Item;
use Auth;
use Lang;

class InvoiceController extends Controller
{

    const SEARCH_SESSION_KEY = 'invoce.search';
    const SELECTION_ID_SESSION_KEY = 'invoce.selection.id';


    public function index(SearchForm $request)
    {
        $condition = $request->isMethod('post') ? $request->all() : $request->session()->get(static::SEARCH_SESSION_KEY, []);
        $request->session()->put(static::SEARCH_SESSION_KEY, $condition);
        
        $user = Auth::user();
        $invoices = $user->selectedOrganization()
            ->invoices()
            ->searchByCondition($condition)
            ->orderBy('id', 'desc')
            ->paginate(20);

        return view('invoice.index', [
            'condition'     => $condition,
            'invoices'      => $invoices,
            'selections'    => $request->session()->get(static::SELECTION_ID_SESSION_KEY, [])
        ]);
    }

    public function create()
    {
        $invoice = new Invoice();
        $invoice->items->add(new Item());

        $clientOptions = Auth::user()->selectedOrganization()
            ->clients()
            ->pluck('name', 'id');

        return view('invoice.create', [
            'invoice' => $invoice,
            'clientOptions' => $clientOptions,
        ]);
    }

    public function store(SaveForm $request)
    {
        $data = $request->only('title', 'client_id', 'date', 'due', 'remarks');

        $organization = Auth::user()->selectedOrganization();
        $invoice = $organization->invoices()->create(['organization_id' => $organization->id] + $data);

        $subtotal = 0;
        $tax = 0;
        foreach ($request->only('items')['items'] as $form) {
            $item = isset($form['id']) ? $invoice->items()->find($form['id']) : new Item(['invoice_id' => $invoice->id]);
            if ((empty($form['name']) && empty($form['price']) && empty($form['quantity'])) || $form['_delete']) {
                $item->delete();
            } else {
                $item->fill($form)->save();

                $subtotal += intval($item->price);
                if ($invoice->in_tax) $tax += (floatval($item->price) * $invoice->tax_rate / 100);
            }
        }

        $invoice->subtotal = $subtotal;
        $invoice->tax = $tax;
        $invoice->total = $subtotal + $tax;
        $invoice->save();

        return redirect()->route('invoice.index')->with('success', Lang::get('common.registrationd_has_been_completed'));
    }

    public function edit($id)
    {
        $clientOptions = Auth::user()->selectedOrganization()
            ->clients()
            ->pluck('name', 'id');

        $organization = Auth::user()->selectedOrganization();
        $invoice = $organization->invoices()->find($id);
        return view('invoice.edit', [
            'invoice' => $invoice,
            'clientOptions' => $clientOptions,
        ]);
    }

    public function update(SaveForm $request, $id)
    {
        $data = $request->only('title', 'client_id', 'date', 'due', 'remarks');

        $organization = Auth::user()->selectedOrganization();
        $invoice = $organization->invoices()->find($id);

        $subtotal = 0;
        $tax = 0;
        foreach ($request->only('items')['items'] as $form) {
            $item = isset($form['id']) ? $invoice->items()->find($form['id']) : new Item(['invoice_id' => $invoice->id]);
            if ((empty($form['name']) && empty($form['price']) && empty($form['quantity'])) || $form['_delete']) {
                $item->delete();
            } else {
                $item->fill($form)->save();

                $subtotal += intval($item->price);
                if ($invoice->in_tax) $tax += (floatval($item->price) * $invoice->tax_rate / 100);
            }
        }

        $invoice->fill($data);
        $invoice->subtotal = $subtotal;
        $invoice->tax = $tax;
        $invoice->total = $subtotal + $tax;
        $invoice->save();

        return redirect()->route('invoice.index')->with('success', Lang::get('common.update_has_been_completed'));
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $invoice = $user->selectedOrganization()->invoices()->find($id);
        if ($invoice) {
            $invoice->delete();
        }
        return redirect()->route('invoice.index')->with('success', Lang::get('common.delete_has_been_completed'));
    }
}
