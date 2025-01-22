<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;

class PenjualanController extends Controller
{
    public function index()
    {
        return view('penjualan.index');
    }

    public function data()
    {
        $selling = Sale::with('member')->orderBy('id', 'desc')->get();

        return datatables()
            ->of($selling)
            ->addIndexColumn()
            ->addColumn('total_items', function ($selling){
                return format_uang($selling->total_items);
            })
            ->addColumn('total_price', function ($selling) {
                return format_uang($selling->total_price);
            })
            ->addColumn('paid', function ($selling){
                return format_uant($selling->padi);
            })
            ->addColumn('date', function ($selling){
                return tanggal_indonesia($selling->created_at, false);
            })
            ->addColumn('member_code', function ($selling) {
                $member = $selling->member->member_code ?? '';
                return '<span class="label label-success">'. $member .'</spa>';
            })
            ->editColumn('discount', function ($selling){
                return $selling->discount . '%';
            })
            ->editColumn('kasir', function($selling){
                return $selling->user->name ?? '';
            })
             ->addColumn('aksi', function ($selling) {
                return '
                <div class="btn-group">
                    <button onclick="showDetail(`'. route('penjualan.show', $selling->id) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-eye"></i></button>
                    <button onclick="deleteData(`'. route('penjualan.destroy', $selling->id) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi', 'member_code'])
            ->make('true');

    }
}
