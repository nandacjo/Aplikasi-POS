<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Picqer\Barcode\BarcodeGeneratorHTML;

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
            ->addColumn('select_all', function ($product) {
                return '<input type="checkbox" name="product_id[]" value="' . $product->id . '">';
            })
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
            ->rawColumns(['aksi', 'product_code', 'select_all'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $lastProduct = Product::latest()->first();
        $nextId = $lastProduct ? $lastProduct->id + 1 : 1;
        $request["product_code"] = "P" . str_pad($nextId, 6, '0', STR_PAD_LEFT);
        // $request['prodcut_code'] = "P" . tambah_nol_didepan(int($product) + 1, 6);
        $request['purchase_price'] = str_replace('.', '', $request->purchase_price);
        $request['selling_price'] = str_replace('.', '', $request->selling_price);

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

    public function deleteSelected(Request $request)
    {
        foreach ($request->product_id as $id) {
            $product = Product::find($id);
            $product->delete();
        }
        return response(null, 204);
    }

    public function cetakBarcode(Request $request)
    {
        $dataProduk = [];
        if ($request->product_id) {
            foreach ($request->product_id as $idProduk) {
                $produk = Product::find($idProduk);
                $dataProduk[] = $produk;
            }
        } else {
            $dataProduk = Product::all();
        }


        $generatorHTML = new BarcodeGeneratorHTML();

        // Generate barcode untuk setiap produk
        $barcodes = [];
        foreach ($dataProduk as $produk) {
            // Ambil kode produk atau atribut lain yang digunakan untuk barcode
            $barcode = $generatorHTML->getBarcode($produk->product_code, $generatorHTML::TYPE_CODE_128);
            $barcodes[] = $barcode;
        }


        $no = 1;

        // Kirim dataProduk dan barcodes ke view
        $pdf = Pdf::loadView('produk.barcode', compact('dataProduk', 'barcodes', 'no'));
        $pdf->setPaper('a4', 'potrait');

        return $pdf->stream('produk.pdf');
    }


    // public function cetakBarcode(Request $request)
    // {
    //     $dataProduk = [];
    //     foreach ($request->product_id as $idProduk) {
    //         $produk = Product::find($idProduk);
    //         $dataProduk[] = $produk;
    //     }

    //     $generatorHTML = new BarcodeGeneratorHTML();
    //     $barcode = $generatorHTML->getBarcode('0001245259636', $generatorHTML::TYPE_CODE_128);

    //     $pdf = Pdf::loadView('produk.barcode', compact('dataProduk', 'barcode'));
    //     $pdf->setPaper('a4', 'potrait');

    //     return $pdf->stream('produk.pdf');
    // }
}
