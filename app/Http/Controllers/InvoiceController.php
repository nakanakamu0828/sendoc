<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Invoice\SaveForm;
use App\Http\Requests\Invoice\SearchForm;
use App\Models\User;
use App\Models\Invoice;
use App\Models\Invoice\Item;
use App\Models\Invoice\Payee;
use App\Repositories\Interfaces\InvoiceRepositoryInterface;
use Auth;
use Lang;

class InvoiceController extends Controller
{

    const SEARCH_SESSION_KEY = 'invoce.search';
    const SELECTION_ID_SESSION_KEY = 'invoce.selection.id';

    private $invoiceRepository;

    public function __construct(InvoiceRepositoryInterface $invoiceRepository)
    {
        $this->invoiceRepository = $invoiceRepository;
        $this->middleware(function ($request, $next) {
            $this->invoiceRepository->setUser(Auth::user());
            return $next($request);
        });
    }

    public function index(SearchForm $request)
    {
        $condition = $request->isMethod('post') ? $request->all() : $request->session()->get(static::SEARCH_SESSION_KEY, []);
        $request->session()->put(static::SEARCH_SESSION_KEY, $condition);
        $invoices = $this->invoiceRepository->paginateByCondition($condition, 'id', 'desc', 20);
        return view('invoice.index', [
            'condition'     => $condition,
            'invoices'      => $invoices,
            'selections'    => $request->session()->get(static::SELECTION_ID_SESSION_KEY, [])
        ]);
    }

    public function create()
    {
        $user = Auth::user();
        $organization = $user->selectedOrganization();

        $invoice = new Invoice();
        $invoice->generateInvoiceNo($organization->id);
        $invoice->items->add(new Item());
        $invoice->payees->add(new Payee());

        $clientOptions = $organization
            ->clients()
            ->pluck('name', 'id');

        $sourceOptions = $organization
            ->sources()
            ->pluck('name', 'id');


        return view('invoice.create', [
            'invoice' => $invoice,
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

        $subtotal = 0;
        $tax = 0;
        foreach ($request->only('items')['items'] as $item) {
            if (!$item['_delete'] && $item['name'] && $item['price'] && $item['quantity']) {
                $subtotal += floatval($item['price']);
                if (isset($item['in_tax'])) $tax += (floatval($item['price']) * floatval($item['tax_rate']) / 100);
            }
        }

        $data['subtotal'] = $subtotal;
        $data['tax'] = $tax;
        $data['total'] = $subtotal + $tax;
        $this->invoiceRepository->create($data);

        return redirect()->route('invoice.index')->with('success', Lang::get('common.registrationd_has_been_completed'));
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

        $invoice = $organization->invoices()->find($id);
        return view('invoice.edit', [
            'invoice' => $invoice,
            'clientOptions' => $clientOptions,
            'sourceOptions' => $sourceOptions,
        ]);
    }

    public function update(SaveForm $request, $id)
    {
        $organization = Auth::user()->selectedOrganization();
        $data = $request->all();

        $client = $organization->clients()->firstOrCreate(['name' => $data['recipient']]);
        $data['client_id'] = $client->id;

        $source = $organization->sources()->firstOrCreate(['name' => $data['sender']]);
        $data['source_id'] = $source->id;

        $subtotal = 0;
        $tax = 0;
        foreach ($request->only('items')['items'] as $item) {
            if (!$item['_delete'] && $item['name'] && $item['price'] && $item['quantity']) {
                $subtotal += floatval($item['price']);
                if (isset($item['in_tax'])) $tax += (floatval($item['price']) * floatval($item['tax_rate']) / 100);
            }
        }

        $data['subtotal'] = $subtotal;
        $data['tax'] = $tax;
        $data['total'] = $subtotal + $tax;

        $this->invoiceRepository->update($id, $data);

        return redirect()->route('invoice.index')->with('success', Lang::get('common.update_has_been_completed'));
    }

    public function copy($id)
    {
        $organization = Auth::user()->selectedOrganization();
        
        $clientOptions = $organization
            ->clients()
            ->pluck('name', 'id');

        $sourceOptions = $organization
            ->sources()
            ->pluck('name', 'id');

        $invoice = $organization->invoices()->find($id);
        return view('invoice.create', [
            'invoice' => $invoice,
            'clientOptions' => $clientOptions,
            'sourceOptions' => $sourceOptions,
        ]);
    }

    public function destroy($id)
    {
        $this->invoiceRepository->delete($id);
        return redirect()->route('invoice.index')->with('success', Lang::get('common.delete_has_been_completed'));
    }
}
