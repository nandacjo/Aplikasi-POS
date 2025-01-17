<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier as Model;

class SupplierController extends Controller
{
    public function index()
    {
        return view('supplier.index');
    }

    public function data()
    {
        $model = Model::orderBy('id')->get();
        return datatables()
            ->of($model)
            ->addIndexColumn()
            ->addColumn('select_all', function ($model) {
                return '<input type="checkbox" name="supplier_id[]" value="' . $model->id . '">';
            })
            ->addColumn('aksi', function ($model) {
                return '
                <div class="btn-group">
                    <button onclick="editForm(`' . route('supplier.update', $model->id) . '`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                    <button onclick="deleteData(`' . route('supplier.destroy', $model->id) . '`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi', 'supplier_code', 'select_all'])
            ->make(true);
    }

    public function store(Request $request)
    {

        // Simpan anggota baru
        $model = new Model();
        $model->name = $request->name;
        $model->phone = $request->phone;
        $model->address = $request->address;
        $model->save();

        return response()->json('Data berhasil disimpan', 200);
    }


    public function show($id)
    {
        $model = Model::find($id);
        return response()->json($model);
    }

    public function update(Request $request, $id)
    {
        $model = Model::find($id);
        $model->name = $request->name;
        $model->phone = $request->phone;
        $model->address = $request->address;
        $model->update();

        return response()->json('Data berhasil disimpan', 200);
    }

    public function destroy($id)
    {
        $model = model::find($id);
        $model->delete();
        return response(null, 204);
    }

    public function deleteSelected(Request $request)
    {
        print_r($request->supplier_id);
        foreach ($request->supplier_id as $id) {
            $product = Model::find($id);
            $product->delete();
        }
        return response(null, 204);
    }
}
