<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\Purchase;
use App\Models\Product;
use App\Models\PurchaseDetail;

class PembelianController extends Controller
{
    public function index()
    {
        $supplier = Supplier::orderBy('name')->get();
        return view('pembelian.index', compact('supplier'));
    }

    public function data()
    {
        $purchase = Purchase::orderBy('id', 'desc')->get();

        return datatables()
        ->of($purchase)
        ->addIndexColumn()
        ->addColumn('total_price', function ($purchase) {
            return format_uang($purchase->total_price);
        })
        ->addColumn('total_bayar', function($purchase) {
            return format_uang($purchase->paid);
        })
        ->addColumn('tanggal', function($purchase){
            return tanggal_indonesia($purchase->created_at, false);
        })
         ->addColumn('supplier', function ($purchase) {
                return $purchase->supplier->name;
            })
            ->editColumn('discount', function ($purchase) {
                return $purchase->discount . '%';
            })
            ->addColumn('aksi', function ($purchase) {
                return '
                <div class="btn-group">
                    <button onclick="showDetail(`'. route('pembelian.show', $purchase->id) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-eye"></i></button>
                    <button onclick="deleteData(`'. route('pembelian.destroy', $purchase->id) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create($id)
    {
        $pembelian = new Purchase();
        $pembelian->supplier_id = $id;
        $pembelian->total_items = 0;
        $pembelian->total_price = 0;
        $pembelian->discount = 0;
        $pembelian->paid = 0;
        $pembelian->save();

        session(['purchase_id' => $pembelian->id]);
        session(['supplier_id' => $pembelian->supplier_id]);

        return redirect()->route('pembelian_detail.index');

    }

    public function store(Request $request)
    {
        $purchase = Purchase::findOrFail($request->purchase_id);
        $purchase->total_items = $request->total_items;
        $purchase->total_price = $request->total;
        $purchase->discount = $request->discount;
        $purchase->paid = $request->paid;
        $purchase->update();

        $detail = PurchaseDetail::where('purchase_id', $purchase->id)->get();
        foreach($detail as $item){
            $produk = Product::find($item->product_id);
            $produk->stock += $item->quantity;
            $produk->update();
        }

        return redirect()->route('pembelian.index');
    }

    public function show($id)
    {
        $detail = PurchaseDetail::with('product')->where('purchase_id', $id)->get();

        return datatables()->of($detail)
            ->addIndexColumn()
            ->addColumn('product_code', function ($detail) {
                return '<span class="label label-success">'. $detail->product->product_code .'</span>';
            })
             ->addColumn('product_name', function ($detail) {
                return $detail->product->product_name;
            })
            ->addColumn('purchase_price', function ($detail) {
                return 'Rp. '. format_uang($detail->purchase_price);
            })
            ->addColumn('quantity', function ($detail) {
                return $detail->quantity;
            })
            ->addColumn('subtotal', function ($detail) {
                return 'Rp. '. format_uang($detail->subtotal);
            })
            ->rawColumns(['product_code'])
            ->make(true);
            
            ;
    }

    public function destroy($id)
    {
        $purchase = Purchase::find($id);
        $detail = PurchaseDetail::where("purchase_id", $purchase->id)->get();

        foreach($detail as $item){
            $prodcut = Product::find($item->purchase_id);
            if($prodcut){
                $prodcut->stock -= $item->quantity;
                $prodcut->update();
            }
            $item->delete();
        }

        $purchase->delete();

        return response(null, 204);
    }
}
