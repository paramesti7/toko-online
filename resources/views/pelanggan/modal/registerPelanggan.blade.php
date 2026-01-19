<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="registerModalLabel">Register</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('storePelanggan') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3 row">
                        <label for="nama" class="col-sm-3 col-form-label">Nama <span style="color: red">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="nama" id="nama" value="" placeholder="Masukan nama Anda" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="email" class="col-sm-3 col-form-label">Email <span style="color: red">*</span></label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control" name="email" id="email" value="" placeholder="Masukan Email Anda" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="password" class="col-sm-3 col-form-label">Password <span style="color: red">*</span></label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" name="password" id="password" placeholder="Masukan Password Anda" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="alamat" class="col-sm-3 col-form-label">Alamat <span style="color: red">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Masukan Alamat Anda" required>
                        </div>
                    </div>
                    {{-- sunah start1 --}}
                    <div class="mb-3 row">
                        <label for="alamat" class="col-sm-3 col-form-label">Alamat 2</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="alamat2" id="alamat2" placeholder="Masukan Alamat Anda">
                        </div>
                    </div>
                    {{-- sunah end1 --}}
                    <div class="mb-3 row">
                        <label for="tlp" class="col-sm-3 col-form-label">Nomor Telpon <span style="color: red">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="tlp" name="tlp" placeholder="Masukan Nomor Telpon Anda">
                        </div>
                    </div>
                    {{-- sunah start 2 --}}
                    <div class="mb-3 row">
                        <label for="date" class="col-sm-3 col-form-label">Tanggal Lahir <span style="color: red">*</span></label>
                        <div class="col-sm-9">
                            <input type="date" class="form-control" id="date" name="date" placeholder="Masukan Tanggal Lahir Anda">
                        </div>
                    </div>
                    {{-- sunah end 2 --}}
                    <div class="mb-3 row">
                        <label for="foto" class="col-sm-3 col-form-label">Foto Anda</label>
                        <div class="col-sm-9">
                            <input type="file" class="form-control" accept=".png, .jpg, .jpeg" id="inputFoto"
                                name="foto" onchange="previewImg()">
                            <img class="mt-2 preview" style="width: 100px;">
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-success col-sm-12 mt-2">Register</button>

                    <button type="button" class="btn btn-danger col-sm-12 mt-2"data-bs-dismiss="modal">Close</button>

                </form>
            </div>
        
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