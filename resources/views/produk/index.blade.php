<x-app-layout>

  <x-slot name="title">Produk</x-slot>

  @section('breadcrumb')
    @parent
    <li class="active">Produk</li>
  @endsection

  <div class="row">
    <div class="col-md-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">
            <div class="btn-group">
              <button onclick="addForm('{{ route('produk.store') }}')" class="btn btn-success btn-xs btn-flat">
                <i class="fa fa-plus-circle"> Tambah</i>
              </button>
              <button onclick="deleteSelectedData('{{ route('produk.delete.selected') }}')"
                class="btn btn-danger btn-xs btn-flat">
                <i class="fa fa-trash"> Hapus</i></button>

              <button onclick="cetakBarcode('{{ route('produk.cetak.barcode') }}')"
                class="btn btn-info btn-xs btn-flat">
                <i class="fa fa-barcode"> Cetak Barcode</i></button>
            </div>
          </h3>
        </div>
        <div class="box-body">
          <form action="" method="post" class="form-produk">
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
                  <th>Kategori</th>
                  <th>Merek</th>
                  <th>Harga Beli</th>
                  <th>Harga Jual</th>
                  <th>Diskon</th>
                  <th>Stok</th>
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

  @includeIf('produk.form')
  @push('scripts')
    <script>
      let table;

      $(function() {
        initializeDataTable();
        setupModalFormSubmission();

      });

      // Select all
      $('[name=select_all]').on('click', function() {
        $('input[type=checkbox]').prop('checked', $(this).prop('checked'));
      });

      // Inisialisasi DataTable
      function initializeDataTable() {
        table = $('.table').DataTable({
          processing: true,
          autoWidth: false,
          ajax: {
            url: '{{ route('produk.data') }}',
          },
          columns: [{
              data: 'select_all'
            },
            {
              data: 'DT_RowIndex',
              searchable: false,
              sortable: false
            },
            {
              data: "product_code",
              name: "product_code"
            },
            {
              data: "product_name",
              name: "product_name"
            },
            {
              data: 'category_name',
              name: 'category.name',
              orderable: true,
              searchable: true
            },
            {
              data: "brand_name",
              name: "brand_name"
            },
            {
              data: "purchase_price",
              name: "purchase_price"
            },
            {
              data: "selling_price",
              name: "selling_price"
            },
            {
              data: "discount",
              name: "discount"
            },
            {
              data: "stock",
              name: "stock"
            },
            {
              data: 'aksi',
              searchable: false,
              sortable: false
            },
          ],
        });
      }

      // Pengaturan Submit Form Modal
      function setupModalFormSubmission() {
        $('#modal-form').validator().on('submit', function(e) {
          if (!e.preventDefault()) {
            const form = $('#modal-form form');
            $.ajax({
                url: form.attr('action'),
                type: 'post',
                data: form.serialize(),
              })
              .done(() => {
                $('#modal-form').modal('hide');
                table.ajax.reload();
              })
              .fail((errors) => {
                alert("Tidak dapat menyimpan data");
                console.error(errors);
              });
          }
        });
      }

      // Fungsi Tambah Data
      function addForm(url) {
        openModal('Tambah Produk', 'post', url);
      }

      // Fungsi Edit Data
      function editForm(url) {

        $('.form-produk').on('submit', function(e) {
          // Mencegah aksi form berjalan (default action)
          e.preventDefault();
        });

        openModal('Edit Produk', 'put', url);


        $.get(url)
          .done((response) => {
            populateForm(response);
          })
          .fail(() => {
            alert('Tidak dapat menampilkan data');
          });
      }

      // Fungsi Hapus Data
      function deleteData(url) {

        $('.form-produk').on('submit', function(e) {
          e.preventDefault();
        });

        if (confirm('Apakah anda yakin hapus data produk ini?')) {
          $.post(url, {
              '_token': $('[name=csrf-token]').attr('content'),
              '_method': 'delete',
            })
            .done(() => {
              table.ajax.reload();
            })
            .fail(() => {
              alert('Tidak dapat menghapus data');
            });
        }

      }

      // Fungsi Membuka Modal
      function openModal(title, method, url) {
        const form = $('#modal-form form');
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text(title);
        form[0].reset();
        form.attr('action', url);
        $('#modal-form [name=_method]').val(method);
        $('#modal-form [name=product_name]').focus();
      }

      // Fungsi Mengisi Form dengan Data
      function populateForm(data) {
        $('#modal-form [name=product_name]').val(data.product_name);
        $('#modal-form [name=product_code]').val(data.product_code);
        $('#modal-form [name=id_category]').val(data.id_category);
        $('#modal-form [name=brand_name]').val(data.brand_name);
        $('#modal-form [name=purchase_price]').val(data.purchase_price);
        $('#modal-form [name=selling_price]').val(data.selling_price);
        $('#modal-form [name=discount]').val(data.discount);
        $('#modal-form [name=stock]').val(data.stock);
      }

      // Fungsi Hapus Data yang Dipilih
      function deleteSelectedData(url) {
        if ($('input:checked').length > 1) {
          if (confirm('Yakin ingin menghapus data terpilih')) {
            $.post(url, $('.form-produk').serialize())
              .done((response) => {
                table.ajax.reload();
              })
              .fail((errors) => {
                alert('Tidak dapat menghapus data');
                return
              })
          }
        } else {
          alert('Pilih data yang akan dihapus');
          return
        }
      }

      function cetakBarcode(url) {
        if ($('input:checked').length < 1) {
          $('.form-produk')
            .attr('target', '_blank')
            .attr('action', url)
            .attr('_method', 'post')
            .submit();
        } else
        if ($('input:checked').length == 1) {
          $('.form-produk').attr('target', '_blank').attr('action', url).submit();
        } else if ($('input:checked').length < 3) {
          alert('Pilih minimal 3 data untuk dicetak');
        } else {
          $('.form-produk')
            .attr('target', '_blank').attr('action', url).submit();
        }
      }
    </script>
  @endpush


</x-app-layout>
