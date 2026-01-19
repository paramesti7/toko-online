<div class="modal fade" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content modal-md">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">{{$title}}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm" action="{{ route('updateData', $data->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3 row">
                        <label for="sku" class="col-sm-5 col-form-label">SKU</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control-plaintext" id="sku" name="sku"
                                value="{{ $data->sku }}" readonly>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="nameProduct" class="col-sm-5 col-form-label">Nama Product</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="nameProduct" name="nama" value="{{$data->nama_product}}">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="deskripsi" class="col-sm-5 col-form-label">Deskripsi</label>
                        <div class="col-sm-7">
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3">{{$data->deskripsi}}</textarea>
                        </div>
                    </div>
                    {{-- sunah start --}}
                    <div class="mb-3 row">
                        <label for="type" class="col-sm-5 col-form-label">Type Product</label>
                        <div class="col-sm-7">
                            <select type="text" class="form-control" id="type" name="type">
                                <option value="">Pilih Type</option>
                                <option value="Oleh-Oleh" {{$data->type === 'Oleh-Oleh' ? 'selected' : '' }}>Oleh-Oleh</option>
                                {{-- <option value="rengginang" {{$data->type === 'rengginang' ? 'selected' : '' }}>Rengginang</option>
                                <option value="abon" {{$data->type === 'abon' ? 'selected' : '' }}>Abon</option> --}}
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="katergori" class="col-sm-5 col-form-label">Katergori Product</label>
                        <div class="col-sm-7">
                            <select type="text" class="form-control" id="katergori" name="kategori">
                                <option value="">Pilih katergori</option>
                                <option value="Makanan" {{$data->kategory === 'Makanan' ? 'selected' : '' }}>Makanan</option>
                                <option value="Minuman" {{$data->kategory === 'Minuman' ? 'selected' : '' }}>Minuman</option>
                                {{-- <option value="Dessert" {{$data->kategory === 'Dessert' ? 'selected' : '' }}>Dessert</option> --}}
                            </select>
                        </div>
                    </div>
                    {{-- sunah end --}}
                    <div class="mb-3 row">
                        <label for="harga" class="col-sm-5 col-form-label">Harga Product</label>
                        <div class="col-sm-7">
                            <input type="number" class="form-control" id="harga" name="harga" value="{{$data->harga}}">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="quantity" class="col-sm-5 col-form-label">Qty Product</label>
                        <div class="col-sm-7">
                            <input type="number" class="form-control" id="quantity" name="quantity" value="{{$data->quantity}}">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="foto" class="col-sm-5 col-form-label">Foto Product</label>
                        <div class="col-sm-7">
                            <input type="hidden" name="foto" value="{{$data->foto}}">
                            <img src="{{asset('storage/product/'.$data->foto)}}" class="mb-2 preview" style="width: 100px">
                            <input type="file" class="form-control" accept=".png, .jpg, .jpeg" id="inputFoto" name="foto" onchange="previewImg()">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function previewImg() {
        const fotoIn = document.querySelector('#inputFoto');
        const preview = document.querySelector('.preview');

        preview.style.display = 'block';

        const oFReader = new FileReader();
        oFReader.readAsDataURL(fotoIn.files[0]);

        oFReader.onload = function(oFREvent) {
            preview.src = oFREvent.target.result;
        }
    }
</script>