<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense as Model;

class PengeluaranController extends Controller
{
    private $routeUpdate = 'pengeluaran.update';
    private $routeDestroy = 'pengeluaran.destroy';
    private $prefix = 'pengeluaran';

    public function index()
    {
        return view($this->prefix . '.index');
    }

    public function data()
    {
        $model = Model::orderBy('id')->get();
        return datatables()
            ->of($model)
            ->addIndexColumn()
            ->addColumn('amount', function ($model) {
                return format_uang($model->amount);
            })
            ->addColumn('aksi', function ($model) {
                return '
                <div class="btn-group">
                    <button onclick="editForm(`' . route($this->routeUpdate, $model->id) . '`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                    <button onclick="deleteData(`' . route($this->routeDestroy, $model->id) . '`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function store(Request $request)
    {
        // Simpan anggota baru
        $model = new Model();
        $model->description = $request->description;
        $model->amount = $request->amount;
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
        $model->description = $request->description;
        $model->amount = $request->amount;
        $model->update();

        return response()->json('Data berhasil disimpan', 200);
    }

    public function destroy($id)
    {
        $model = Model::find($id);
        $model->delete();
        return response(null, 204);
    }
}
