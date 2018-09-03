<?php

namespace App\Http\Controllers\Estimate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\EstimateRepositoryInterface;
use Auth;
use PDF;

class PdfController extends Controller
{

    private $estimateRepository;

    public function __construct(EstimateRepositoryInterface $estimateRepository)
    {
        $this->estimateRepository = $estimateRepository;
        $this->middleware(function ($request, $next) {
            $this->estimateRepository->setUser(Auth::user());
            return $next($request);
        });
    }

    public function preview($id)
    {
        $estimate = $this->estimateRepository->find($id);
        $pdf = PDF::loadView('estimate/pdf/template', [
            'estimate' => $estimate
        ])
            ->setOption('encoding', 'utf-8')
            ->setOption('user-style-sheet', base_path('public/css/pdf.css'))
        ;
        return $pdf->inline('thisis.pdf');
    }    

    public function download($id)
    {
        $estimate = $this->estimateRepository->find($id);
        $pdf = PDF::loadView('estimate/pdf/template', [
            'estimate' => $estimate
        ])
            ->setOption('encoding', 'utf-8')
            ->setOption('user-style-sheet', base_path('public/css/pdf.css'))
        ;
        return $pdf->download('thisis.pdf');
    }
}
