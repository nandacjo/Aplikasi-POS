<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member as Model;

class MemberController extends Controller
{
    public function index()
    {
        return view('member.index');
    }

    public function data()
    {
        $model = Model::orderBy('id')->get();
        return datatables()
            ->of($model)
            ->addIndexColumn()
            ->addColumn('select_all', function ($model) {
                return '<input type="checkbox" name="member_id[]" value="' . $model->id . '">';
            })
            ->addColumn('member_code', function ($model) {
                return "<span class='label label-success'>" . $model->member_code . "</span>";
            })
            ->addColumn('aksi', function ($model) {
                return '
                <div class="btn-group">
                    <button onclick="editForm(`' . route('member.update', $model->id) . '`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                    <button onclick="deleteData(`' . route('member.destroy', $model->id) . '`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi', 'member_code', 'select_all'])
            ->make(true);
    }

    public function store(Request $request)
    {
        // Ambil anggota terakhir dari database
        $member = Model::latest()->first();

        // Jika tidak ada anggota sebelumnya, set kode pertama menjadi 1
        $kode_member = $member ? (int) substr($member->member_code, 1) + 1 : 1;

        // Panggil fungsi tambah_nol_didepan untuk memastikan panjang kode tetap 5 digit
        $kode_member = tambah_nol_didepan($kode_member, 5);

        // Simpan anggota baru
        $model = new Model();
        $model->member_code = $kode_member;
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
}
