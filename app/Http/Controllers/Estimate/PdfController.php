<?php

namespace App\Http\Controllers\Estimate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use PDF;

class PdfController extends Controller
{
    public function preview($id)
    {
        $organization = Auth::user()->selectedOrganization();
        $estimate = $organization->estimates()->find($id);

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
        $organization = Auth::user()->selectedOrganization();
        $estimate = $organization->estimates()->find($id);

        $pdf = PDF::loadView('estimate/pdf/template', [
            'estimate' => $estimate
        ])
            ->setOption('encoding', 'utf-8')
            ->setOption('user-style-sheet', base_path('public/css/pdf.css'))
        ;
        return $pdf->download('thisis.pdf');
    }
}
