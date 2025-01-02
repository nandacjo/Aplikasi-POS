<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $category = Category::all()->pluck('category_name', 'id');
        return view('produk.index', compact('category'));
    }

    public function data()
    {
        // $product = Product::leftJoin('categories', 'categories.id', '=', 'products.id_category')
        //     ->select(
        //         'products.*',
        //         'categories.category_name'
        //     )
        //     ->orderBy('products.id', 'desc');

        $product = Product::with('category')->select('products.*')->orderBy('product_code', 'asc');

        return datatables()
            ->of($product)
            ->addColumn('product_code', function ($product) {
                return "<span class='label label-success'>" . $product->product_code . "</span>";
            })
            ->addIndexColumn()
            ->addColumn('category_name', function ($product) {
                return $product->category ? $product->category->category_name : 'No Category';
            })
            ->addColumn('purchase_price', function ($product) {
                return format_uang($product->purchase_price);
            })
            ->addColumn('selling_price', function ($product) {
                return format_uang($product->selling_price);
            })
            ->addColumn('aksi', function ($product) {
                return '
                <div class="btn-group">
                    <button onclick="editForm(`' . route('produk.update', $product->id) . '`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                    <button onclick="deleteData(`' . route('produk.destroy', $product->id) . '`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi', 'product_code'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $lastProduct = Product::latest()->first();
        $nextId = $lastProduct ? $lastProduct->id + 1 : 1;
        $request["product_code"] = "P" . str_pad($nextId, 6, '0', STR_PAD_LEFT);
        // $request['prodcut_code'] = "P" . tambah_nol_didepan(int($product) + 1, 6);
        $product = Product::create($request->all());
        return response()->json('Data berhasil disimpan', 200);
    }

    public function show($id)
    {
        $product = Product::find($id);
        return response()->json($product);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->update($request->all());

        return response()->json('Data berhasil disimpan', 200);
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        return response(null, 204);
    }
}
