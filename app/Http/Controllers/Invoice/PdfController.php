<?php

namespace App\Http\Controllers\Invoice;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\InvoiceRepositoryInterface;
use Auth;
use PDF;

class PdfController extends Controller
{

    private $invoiceRepository;

    public function __construct(InvoiceRepositoryInterface $invoiceRepository)
    {
        $this->invoiceRepository = $invoiceRepository;
        $this->middleware(function ($request, $next) {
            $this->invoiceRepository->setUser(Auth::user());
            return $next($request);
        });
    }

    public function preview($id)
    {
        $invoice = $this->invoiceRepository->find($id);
        $pdf = PDF::loadView('invoice/pdf/template', [
            'invoice' => $invoice
        ])
            ->setOption('encoding', 'utf-8')
            ->setOption('user-style-sheet', base_path('public/css/pdf.css'))
        ;
        return $pdf->inline('thisis.pdf');
    }    

    public function download($id)
    {
        $invoice = $this->invoiceRepository->find($id);
        $pdf = PDF::loadView('invoice/pdf/template', [
            'invoice' => $invoice
        ])
            ->setOption('encoding', 'utf-8')
            ->setOption('user-style-sheet', base_path('public/css/pdf.css'))
        ;
        return $pdf->download('thisis.pdf');
    }
}
