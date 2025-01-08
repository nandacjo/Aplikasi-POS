<script>
    let table;

    // Select all
    $('[name=select_all]').on('click', function() {
    $('input[type=checkbox]').prop('checked', $(this).prop('checked'));
    });

    $(function() {
        table = $('.table').DataTable({
            processing: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('produk.data') }}',
            },
            columns: [
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
            })
        }
    });

    function addForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Tambah Produk');

        $('#modal-form form')[0].reset();
        $("#modal-form form").attr('action', url);
        $('#modal-form [name=_method]').val('post');
        $('#modal-form [name=product_name]').focus();
    }

    function editForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit Produk');

        $('#modal-form form')[0].reset();
        $("#modal-form form").attr('action', url);
        $('#modal-form [name=_method]').val('put');
        $('#modal-form [name=product_name]').focus();

        $.get(url)
            .done((response) => {
                $('#modal-form [name=product_name]').val(response.product_name);
                $('#modal-form [name=product_code]').val(response.product_code);
                $('#modal-form [name=id_category]').val(response.id_category);
                $('#modal-form [name=brand_name]').val(response.brand_name);
                $('#modal-form [name=purchase_price]').val(response.purchase_price);
                $('#modal-form [name=selling_price]').val(response.selling_price);
                $('#modal-form [name=discount]').val(response.discount);
                $('#modal-form [name=stock]').val(response.stock);
            })
            .fail((errors) => {
                alert('Tidak dapat menampilkan data');
            });
    }

    function deleteData(url) {
        $.post(url, {
            '_token': $('[name=csrf-token]').attr('content'),
            '_method': 'delete'
        })
        .done(() => {
            table.ajax.reload();
        })
        .fail(() => {
            alert('Tidak dapat menghapus data');
        });
    }

    // Fungsi Hapus Data yang Dipilih
    function deleteSelectedData(url) {
        if ($('input:checked').length > 1) {
            if (confirm('Yakin ingin menghapus data terpilih')) {
                $.post(url, $('.form-produk').serialize())
                    .done(() => {
                        table.ajax.reload();
                    })
                    .fail(() => {
                        alert('Tidak dapat menghapus data');
                    });
            }
        } else {
            alert('Pilih data yang akan dihapus');
        }
    }

    function cetakBarcode(url) {
        if ($('input:checked').length < 1) {
            $('.form-produk')
                .attr('target', '_blank')
                .attr('action', url)
                .submit();
        } else if ($('input:checked').length == 1) {
            $('.form-produk')
                .attr('target', '_blank')
                .attr('action', url)
                .submit();
        } else if ($('input:checked').length < 3) {
            alert('Pilih minimal 3 data untuk dicetak');
        } else {
            $('.form-produk')
                .attr('target', '_blank')
                .attr('action', url)
                .submit();
        }
    }
</script>