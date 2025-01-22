<x-app-layout>

  <x-slot name="title">Member</x-slot>

  @section('breadcrumb')
    @parent
    <li class="active">Member</li>
  @endsection

  <div class="row">
    <div class="col-md-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">
            <div class="btn-group">
              <button onclick="addForm('{{ route('member.store') }}')" class="btn btn-success btn-xs btn-flat">
                <i class="fa fa-plus-circle"> Tambah</i>
              </button>
              <button onclick="cetakCardMember('{{ route('member.cetak.card') }}')"
                class="btn btn-info btn-xs btn-flat">
                <i class="fa fa-id-card"> Cetak Kartu</i>
              </button>
            </div>
          </h3>
        </div>
        <div class="box-body">
          <form action="" method="POST" class="form-member">
            @csrf
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>
                    <input type="checkbox" name="select_all" id="select_all">
                  </th>
                  <th width="5%">No</th>
                  <th>Kode</th>
                  <th>Nama</th>
                  <th>Phone</th>
                  <th>Alamat</th>
                  <th><i class="fa fa-cog"></i></th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </form>
        </div>
      </div>
    </div>
  </div>

  @includeIf('member.form')

  @push('scripts')
    <script>
      let table;
      $(function() {
        table = $('.table').DataTable({
          processing: true,
          autoWidth: false,
          ajax: {
            url: '{{ route('member.data') }}'
          },
          columns: [{
              data: "select_all",
              searchable: false,
              sortable: false
            },

            {
              data: 'DT_RowIndex',
              searchable: false,
              sortable: false
            },
            {
              data: 'member_code'
            },
            {
              data: "name"
            },
            {
              data: "phone"
            },
            {
              data: "address"
            },
            {
              data: 'aksi',
              searchable: false,
              sortable: false
            }
          ]
        })


        // Select all
        $('[name=select_all]').on('click', function() {
          $('input[type=checkbox]').prop('checked', $(this).prop('checked'));
        });
      });

      $('#modal-form').validator().on('submit', function(e) {
        if (!e.preventDefault()) {
          $.ajax({
              url: $('#modal-form form').attr('action'),
              type: 'post',
              data: $('#modal-form form').serialize()
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
        $('#modal-form .modal-title').text('Tambah Member')

        $('#modal-form form')[0].reset();
        $("#modal-form form").attr('action', url);
        $('#modal-form [name=_method]').val('post');
        $('#modal-form [name=name]').focus();
      }

      function editForm(url) {
        $('.form-member').on('submit', function(e) {
          e.preventDefault();
        });
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit Member')

        $('#modal-form form')[0].reset();
        $("#modal-form form").attr('action', url);
        $('#modal-form [name=_method]').val('put');
        $('#modal-form [name=name]').focus();

        $.get(url)
          .done((response) => {
            $('#modal-form [name=name]').val(response.name)
            $('#modal-form [name=phone]').val(response.phone)
            $('#modal-form [name=address]').val(response.address)
          })
          .fail((errors) => {
            alert('Tidak dapat menampilkan data');
            return;
          })
      }

      function deleteData(url) {
        $('.form-member').on('submit', function(e) {
          e.preventDefault();
        });
        if (confirm('Apakah anda yakin hapus data member ini?')) {
          $.post(url, {
              '_token': $('[name=csrf-token]').attr('content'),
              '_method': 'delete'
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

      function cetakCardMember(url) {
        console.log('hello')
        if ($('input:checked').length < 1) {
          $('.form-member')
            .attr('target', '_blank')
            .attr('action', url)
            .attr('_method', 'post')
            .submit();
        } else {
          if ($('input:checked').length == 1) {
            $('.form-member').attr('target', '_blank').attr('action', url).submit();
          } else if ($('input:checked').length < 3) {
            alert('Pilih minimal 3 data untuk dicetak');
          } else {
            $('.form-member')
              .attr('target', '_blank').attr('action', url).submit();
          }
        }
      }
    </script>
  @endpush

</x-app-layout>
