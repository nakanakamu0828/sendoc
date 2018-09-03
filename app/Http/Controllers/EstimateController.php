<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Estimate\SaveForm;
use App\Http\Requests\Estimate\SearchForm;
use App\Models\User;
use App\Models\Estimate;
use App\Models\Estimate\Organization;
use App\Models\Estimate\Item;
use App\Repositories\Interfaces\EstimateRepositoryInterface;
use Auth;
use Lang;

class EstimateController extends Controller
{

    const SEARCH_SESSION_KEY = 'estimate.search';
    const SELECTION_ID_SESSION_KEY = 'estimate.selection.id';

    private $estimateRepository;

    public function __construct(EstimateRepositoryInterface $estimateRepository)
    {
        $this->estimateRepository = $estimateRepository;
        $this->middleware(function ($request, $next) {
            $this->estimateRepository->setUser(Auth::user());
            return $next($request);
        });
    }

    public function index(SearchForm $request)
    {
        $condition = $request->isMethod('post') ? $request->all() : $request->session()->get(static::SEARCH_SESSION_KEY, []);
        $request->session()->put(static::SEARCH_SESSION_KEY, $condition);
        $estimates = $this->estimateRepository->paginateByCondition($condition, 'id', 'desc', 20);
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

        $estimate = new Estimate();
        $estimate->generateEstimateNo($organization->id);
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
        $this->estimateRepository->create($data);

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

        $estimate = $this->estimateRepository->find($id);
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

        $this->estimateRepository->update($id, $data);

        return redirect()->route('estimate.index')->with('success', Lang::get('common.update_has_been_completed'));
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

        $estimate = $this->estimateRepository->find($id);
        $estimate->generateEstimateNo($organization->id);

        return view('estimate.create', [
            'estimate' => $estimate,
            'clientOptions' => $clientOptions,
            'sourceOptions' => $sourceOptions,
        ]);
    }

    public function destroy($id)
    {
        $this->estimateRepository->delete($id);
        return redirect()->route('estimate.index')->with('success', Lang::get('common.delete_has_been_completed'));
    }
}
