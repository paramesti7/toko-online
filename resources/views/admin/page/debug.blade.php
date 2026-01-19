@extends('admin.layout.index')

@section('content')
<div class="container mt-5">
    <h2>Debug Admin Users</h2>
    
    @php
        $users = \App\Models\User::where('is_admin', 1)->get();
    @endphp
    
    @if($users->count() > 0)
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>is_admin</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td><span class="badge bg-success">{{ $user->is_admin }}</span></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-warning">
            <strong>Tidak ada user admin!</strong> Silakan buat user admin terlebih dahulu.
        </div>
    @endif
    
    <hr>
    
    <h3>Semua Users</h3>
    @php
        $allUsers = \App\Models\User::all();
    @endphp
    
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>is_admin</th>
            </tr>
        </thead>
        <tbody>
            @foreach($allUsers as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if($user->is_admin == 1)
                            <span class="badge bg-success">Admin</span>
                        @else
                            <span class="badge bg-secondary">User</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
