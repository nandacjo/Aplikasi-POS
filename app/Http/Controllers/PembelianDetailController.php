<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\Product;
use App\Models\Supplier;

class PembelianDetailController extends Controller
{
    public function index()
    {
        $purchase_id = session('purchase_id');
        $produk = Product::orderBy('product_name')->get();
        $supplier = Supplier::find(session('supplier_id'));
        $diskon = Purchase::find($purchase_id)->diskon ?? 0;

        if(! $supplier){
            abort(404);
        }

        return view('pembelian_detail.index', compact('purchase_id', 'produk', 'supplier', 'diskon'));
    }

    public function data($id)
    {
        $detail = PurchaseDetail::with('product')
            ->where('purchase_id', $id)
            ->get();
        $data = array();
        $total = 0;
        $total_item = 0;

        foreach ($detail as $item) {
            $row = array();
            $row['product_code'] = '<span class="label label-success">'. $item->product['product_code'] .'</span';
            $row['product_name'] = $item->product['product_name'];
            $row['purchase_price'] = format_uang($item->purchase_price);
            $row['quantity']      = '<input type="number" class="form-control input-sm quantity" data-id="'. $item->id .'" value="'. $item->quantity .'">';
            $row['subtotal']    = format_uang($item->subtotal);
            $row['aksi']        = '<div class="btn-group">
                                    <button onclick="deleteData(`'. route('pembelian_detail.destroy', $item->id) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                                </div>';
            $data[] = $row;
            $total += $item->purchase_price * $item->quantity;
            $total_item += $item->quantity;
        }
         $data[] = [
            'product_code' => '
                <div class="total hide">' . $total . '</div>
                <div class="total_item hide">' . $total_item . '</div>',
            'product_name' => '',
            'purchase_price'  => '',
            'quantity'      => '',
            'subtotal'    => '',
            'aksi'        => '',
        ];

        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->rawColumns(['aksi', 'product_code', 'quantity'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $product = Product::where('id', $request->product_id)->first();
        if(! $product){
            return response()->json('Data gagal disimpan', 400);
        }

        $detail = new PurchaseDetail();
        $detail->purchase_id = $request->purchase_id;
        $detail->product_id = $product->id;
        $detail->purchase_price = $product->purchase_price;
        $detail->quantity = 1;
        $detail->subtotal = $product->purchase_price;
        $detail->save();

        return response()->json('Data berhasil disimpan', 200);
    }

    public function update(Request $request, $id)
    {
        $detail = PurchaseDetail::find($id);
        $detail->quantity = $request->quantity;
        $detail->subtotal = $detail->purchase_price * $request->quantity;
        $detail->update();
    }

     public function destroy($id)
    {
        $detail = PurchaseDetail::find($id);
        $detail->delete();

        return response(null, 204);
    }

    public function loadForm($discount, $total)
    {
        $price = $total - ($discount / 100 * $total);
        $data = [
            'total_rp' => format_uang($total),
            'price' => $price,
            'bayar_rp' => format_uang($price),
            'terbilang' => ucwords(terbilang($price) . ' Rupiah')
        ];

        return response()->json($data);
    }


}
