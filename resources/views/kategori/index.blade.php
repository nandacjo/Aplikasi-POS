<x-app-layout>

    <x-slot name="title">Kategori</x-slot>

    @section('breadcrumb')
        @parent
        <li class="active">Kategori</li>
    @endsection

    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <button onclick="addForm('{{ route('kategori.store') }}')"
                            class="btn btn-success btn-xs btn-flat">
                            <i class="fa fa-plus-circle">Tambah</i>
                        </button>
                    </h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Kategori</th>
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

    @includeIf('kategori.form')

    @push('scripts')
        <script>
            let table;
            $(function() {
                table = $('.table').DataTable({
                    processing: true,
                    autoWidth: false,
                    ajax: {
                        url: '{{ route('kategori.data') }}'
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            searchable: false,
                            sortable: false
                        },
                        {
                            data: "category_name"
                        },
                        {
                            data: 'aksi',
                            searchable: false,
                            sortable: false
                        }
                    ]
                })
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
                            alert("Tidak dapat menyimpan data");
                            return
                        })
                }
            })

            function addForm(url) {
                $('#modal-form').modal('show');
                $('#modal-form .modal-title').text('Tambah Kategori')

                $('#modal-form form')[0].reset();
                $("#modal-form form").attr('action', url);
                $('#modal-form [name=_method]').val('post');
                $('#modal-form [name=category_name]').focus();
            }

            function editForm(url) {
                $('#modal-form').modal('show');
                $('#modal-form .modal-title').text('Edit Kategori')

                $('#modal-form form')[0].reset();
                $("#modal-form form").attr('action', url);
                $('#modal-form [name=_method]').val('put');
                $('#modal-form [name=category_name]').focus();

                $.get(url)
                    .done((response) => {
                        $('#modal-form [name=category_name]').val(response.category_name)
                    })
                    .fail((errors) => {
                        alert('Tidak dapat menampilkan data');
                        return;
                    })
            }

            function deleteData(url) {
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
        </script>
    @endpush

</x-app-layout>
