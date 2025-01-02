<!-- Modal -->
<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form">
    <div class="modal-dialog" role="document">
        <form action="" method="POST" class="form-horizontal">
            @csrf
            @method('post')
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="product_name" class="col-md-2 col-md-offset-1 control-label">Nama</label>
                        <div class="col-md-6">
                            <input type="text" name="product_name" class="form-control"
                                value="{{ old('product_name') }}" required autofocus>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="product_name" class="col-md-2 col-md-offset-1 control-label">Kategori</label>
                        <div class="col-md-6">
                            <select name="id_category" id="id_category" class="form-control" required>
                                <option value="">Pilih Kategori</option>
                                @foreach ($category as $key => $item)
                                    <option value="{{ $key }}">{{ $item }}</option>
                                @endforeach
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="brand_name" class="col-md-2 col-md-offset-1 control-label">Merek</label>
                        <div class="col-md-6">
                            <input type="text" name="brand_name" class="form-control" required autofocus>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="purchase_price" class="col-md-2 col-md-offset-1 control-label">Harga Beli</label>
                        <div class="col-md-6">
                            <input type="text" name="purchase_price" class="form-control" required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="selling_price" class="col-md-2 col-md-offset-1 control-label">Harga Jual</label>
                        <div class="col-md-6">
                            <input type="text" name="selling_price" class="form-control" required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="discount" class="col-md-2 col-md-offset-1 control-label">Diskon</label>
                        <div class="col-md-6">
                            <input type="number" name="discount" class="form-control" value="0" required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="stock" class="col-md-2 col-md-offset-1 control-label">Stok</label>
                        <div class="col-md-6">
                            <input type="number" name="stock" class="form-control" value="0" required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-flat btn-primary"><i class="fa fa-save"></i> Simpan</button>
                    <button type="button" class="btn btn-sm btn-flat btn-default" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>
