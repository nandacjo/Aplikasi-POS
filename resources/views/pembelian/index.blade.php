<x-app-layout>

  <x-slot name="title">Daftar Pembelian</x-slot>

  @section('breadcrumb')
    @parent
    <li class="active">Daftar Pembelian</li>
  @endsection

<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header with-border">
                <button onclick="addForm()" class="btn btn-success btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Transaksi Baru</button>
                @empty(! session('purchase_id'))
                <a href="{{ route('pembelian_detail.index') }}" class="btn btn-info btn-xs btn-flat"><i class="fa fa-pencil"></i> Transaksi Aktif</a>
                @endempty
            </div>
            <div class="box-body table-responsive">
                <table class="table table-stiped table-bordered table-pembelian">
                    <thead>
                        <th width="5%">No</th>
                        <th>Tanggal</th>
                        <th>Supplier</th>
                        <th>Total Item</th>
                        <th>Total Harga</th>
                        <th>Diskon</th>
                        <th>Total Bayar</th>
                        <th width="15%"><i class="fa fa-cog"></i></th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

@includeIf('pembelian.supplier')
@includeIf('pembelian.detail')

</x-app-layout>

@push('scripts')

  <script>
      let table, table1;

    $(function () {
        table = $('.table-pembelian').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: "{{ route('pembelian.data') }}"
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'tanggal'},
                {data: 'supplier'},
                {data: 'total_items'},
                {data: 'total_price'},
                {data: 'discount'},
                {data: 'total_bayar'},
                {data: 'aksi', searchable: false, sortable:false},
            ]
        });

         $('.table-supplier').DataTable();

        table1 = $('.table-detail').DataTable({
            processing:true,
            bsort: false,
            dom: 'Brt',
            columns: [
                    {data: 'DT_RowIndex', searchable: true, sortable: false},
                    {data: 'product_code'},
                    {data: 'product_name'},
                    {data: 'purchase_price'},
                    {data: 'quantity'},
                    {data: 'subtotal'},
                ]
        });
    });

        function addForm(){
            $('#modal-supplier').modal('show')
        }

        function showDetail(url){
            
            $('#modal-detail').modal('show');

            table1.ajax.url(url);
            table1.ajax.reload();
        }

        function deleteData(url) {
        if (confirm('Yakin ingin menghapus data terpilih?')) {
            $.post(url, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'delete'
                })
                .done((response) => {
                    table.ajax.reload();
                })
                .fail((errors) => {
                    alert('Tidak dapat menghapus data');
                    console.log(errors);
                    
                    return;
                });
        }
    }
  </script>
    

@enspush