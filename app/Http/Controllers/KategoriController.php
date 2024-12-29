<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class KategoriController extends Controller
{
    public function index()
    {
        return view('kategori.index');
    }

    public function data(){
        $category = Category::orderBy('id', 'desc')->get();
        return datatables()
            ->of($category)
            ->addIndexColumn()
            ->addColumn('aksi', function ($category) {
                return '
                <div class="btn-group">
                    <button onclick="editForm(`'.route('kategori.update', $category->id).'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                    <button onclick="deleteData(`'.route('kategori.destroy', $category->id).'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $kategori = new Category();
        $kategori->category_name = $request->category_name;
        $kategori->save();

        return response()->json('Data berhasil disimpan', 200);
    }

    public function show($id)
    {
        $category = Category::find($id);
        return response()->json($category);
    }

    public function update(Request $request, $id)
    {
        $kategori = Category::find($id);
        $kategori->category_name = $request->category_name;
        $kategori->update();

        return response()->json('Data berhasil disimpan', 200);
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();
        return response(null, 204);
    }
}