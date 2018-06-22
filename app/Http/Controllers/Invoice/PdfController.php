<?php

namespace App\Http\Controllers\Invoice;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use PDF;

class PdfController extends Controller
{
    public function preview($id)
    {
        $organization = Auth::user()->selectedOrganization();
        $invoice = $organization->invoices()->find($id);

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
        $organization = Auth::user()->selectedOrganization();
        $invoice = $organization->invoices()->find($id);

        $pdf = PDF::loadView('invoice/pdf/template', [
            'invoice' => $invoice
        ])
            ->setOption('encoding', 'utf-8')
            ->setOption('user-style-sheet', base_path('public/css/pdf.css'))
        ;
        return $pdf->download('thisis.pdf');
    }
}
