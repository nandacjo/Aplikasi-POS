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
                        <button onclick="addForm()" class="btn btn-success btn-xs btn-flat">
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
       $(function () {
        table = $('.table').DataTable({
            processing: true,
            autoWidth: false,
            // ajax: {
            //     url: '{{ route('kategori.data') }}'
            // }
        })
       })

       function addForm(){
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Tambah Kategori')
       }
    </script>

    @endpush

</x-app-layout>