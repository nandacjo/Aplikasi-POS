<x-app-layout>

  <x-slot name="title">Data Penjualan</x-slot>

  @section('breadcrumb')
    @parent
    <li class="active">Daftar Penjualan</li>
  @endsection

  <div class="row">
    <div class="col-lg-12">
      <div class="box">
        <div class="box-body table-responsive">
          <table class="table table-stiped table-bordered table-penjualan">
            <thead>
              <th width="5%">No</th>
              <th>Tanggal</th>
              <th>Kode Member</th>
              <th>Total Item</th>
              <th>Total Harga</th>
              <th>Diskon</th>
              <th>Total Bayar</th>
              <th>Kasir</th>
              <th width="15%"><i class="fa fa-cog"></i></th>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>

  @push('scripts')
    <script>
      let table, table1;

      $(function() {
        table = $('.table-penjualan').DataTable({
          responsive: true,
          processing: true,
          serverSide: true,
          autoWidth: false,

          ajax: {
            url: '{{ route('penjualan.data') }}'
          },
          columns: [{
              data: 'DT_RowIndex',
              searchable: false,
              sortable: false
            },
            {
              data: 'date'
            },
            {
              data: 'member_code'
            },
            {
              data: 'total_items'
            },
            {
              data: 'total_price'
            },
            {
              data: 'discount'
            },
            {
              data: 'paid'
            },
            {
              data: 'kasir'
            },
            {
              data: 'aksi',
              searchable: false,
              sortable: false
            },
          ]
        })
      });
    </script>
  @endpush

</x-app-layout>
