<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Source\SaveForm;
use App\Http\Requests\Source\SearchForm;
use App\Models\Source;
use App\Models\Source\Payee;
use Auth;
use Lang;
use App\Repositories\Interfaces\SourceRepositoryInterface;

class SourceController extends Controller
{

    const SEARCH_SESSION_KEY = 'source.search';

    private $sourceRepository;

    public function __construct(SourceRepositoryInterface $sourceRepository)
    {
        $this->sourceRepository = $sourceRepository;
        $this->middleware(function ($request, $next) {
            $this->sourceRepository->setUser(Auth::user());
            return $next($request);
        });
    }

    public function index(SearchForm $request)
    {
        $condition = $request->isMethod('post') ? $request->all() : $request->session()->get(static::SEARCH_SESSION_KEY, []);
        $request->session()->put(static::SEARCH_SESSION_KEY, $condition);
        $sources = $this->sourceRepository->paginateByCondition($condition, 'id', 'desc', 20);
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
        $source = $this->sourceRepository->create($request->all());
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
        $source = $this->sourceRepository->update($id, $request->all());
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
        $this->sourceRepository->delete($id);
        return redirect()->route('source.index')->with('success', Lang::get('common.delete_has_been_completed'));
    }
}
