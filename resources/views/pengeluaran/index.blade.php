<x-app-layout>

  <x-slot name="title">Data Pengeluaran</x-slot>

  @section('breadcrumb')
  @parent
  <li class="active">Pengeluaran</li>
  @endsection

  <div class="row">
    <div class="col-md-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">
            <div class="btn-group">
              <button onclick="addForm('{{ route('pengeluaran.store') }}')" class="btn btn-success btn-xs btn-flat">
                <i class="fa fa-plus-circle"> Tambah</i>
              </button>
            </div>
          </h3>
        </div>
        <div class="box-body">
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <th width="5%">No</th>
                <th>Description</th>
                <th>Amount</th>
                <th><i class="fa fa-cog"></i></th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  @includeIf('pengeluaran.form')

  @push('scripts')
  <script>
    let table;
    $(function() {
      table = $('.table').DataTable({
        processing: true
        , autoWidth: false
        , ajax: {
          url: '{{ route("pengeluaran.data") }}'
        }
        , columns: [

          {
            data: 'DT_RowIndex'
            , searchable: false
            , sortable: false
          }
          , {
            data: "description"
          }
          , {
            data: "amount"
          }
          , {
            data: 'aksi'
            , searchable: false
            , sortable: false
          }
        ]
      })
    });

    // Select all


    $('#modal-form').validator().on('submit', function(e) {
      if (!e.preventDefault()) {
        $.ajax({
            url: $('#modal-form form').attr('action')
            , type: 'post'
            , data: $('#modal-form form').serialize()
          })
          .done((response) => {
            $('#modal-form').modal('hide');
            table.ajax.reload();
          })
          .fail((errors) => {
            console.log(errors);

            alert("Tidak dapat menyimpan data");
            return
          })
      }
    })

    function addForm(url) {
      $('#modal-form').modal('show');
      $('#modal-form .modal-title').text('Tambah Pengeluaran')
      $('#modal-form form')[0].reset();
      $("#modal-form form").attr('action', url);
      $('#modal-form [name=_method]').val('post');
      $('#modal-form [name=name]').focus();
    }

    function editForm(url) {
      $('#modal-form').modal('show');
      $('#modal-form .modal-title').text('Edit Pengeluaran')

      $('#modal-form form')[0].reset();
      $("#modal-form form").attr('action', url);
      $('#modal-form [name=_method]').val('put');
      $('#modal-form [name=name]').focus();

      $.get(url)
        .done((response) => {
          $('#modal-form [name=description]').val(response.description)
          $('#modal-form [name=amount]').val(response.amount)
        })
        .fail((errors) => {
          alert('Tidak dapat menampilkan data');
          return;
        })
    }

    function deleteData(url) {
      if (confirm('Apakah anda yakin hapus data member ini?')) {
        $.post(url, {
            '_token': $('[name=csrf-token]').attr('content')
            , '_method': 'delete'
          })
          .done((response) => {
            table.ajax.reload()
          })
          .fail((errors) => {
            alert('Tidak dapa menghapus data');
            return;
          })
      }

    }

  </script>
  @endpush

</x-app-layout>
