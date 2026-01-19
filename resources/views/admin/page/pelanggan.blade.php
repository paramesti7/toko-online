@extends('admin.layout.index')

@section('content')
    <div class="card rounded-full">
        <div class="card-header bg-transparent d-flex justify-content-between">
            <h4 class="mb-3">Data Pelanggan</h4>
        </div>

        <div class="card-body">
            <table class="table table-responsive table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No Tlp</th>
                        <th>Alamat</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key => $row)
                    <tr class="align-middle">
                        <td>{{ $data->firstItem() + $key }}</td>
                        <td>{{ $row->name }}</td>
                        <td>{{ $row->email }}</td>
                        <td>{{ $row->tlp }}</td>
                        <td>{{ $row->alamat }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="pagination d-flex flex-row justify-content-between mt-3">
                <div class="showData">
                    Data ditampilkan {{$data->count()}} dari {{$data->total()}}
                </div>
                <div>
                    {{ $data->links() }}
                </div>
            </div>
        </div>
    </div>

{{ $data->links() }}
@endsection
