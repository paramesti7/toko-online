<!DOCTYPE html>
<html>
<head>
    <title>Debug Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <div class="container">
        <h2>Debug: Semua Users di Database</h2>
        
        @if($users->count() > 0)
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>is_admin</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->is_admin }}</td>
                            <td>
                                @if($user->is_admin == 1)
                                    <span class="badge bg-success">ADMIN</span>
                                @else
                                    <span class="badge bg-secondary">USER</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="alert alert-danger">Tidak ada user di database!</div>
        @endif
        
        <hr>
        <p><strong>Total Users:</strong> {{ $users->count() }}</p>
        <p><strong>Admin Users:</strong> {{ $users->where('is_admin', 1)->count() }}</p>
        <p><a href="/admin" class="btn btn-primary">Kembali ke Login</a></p>
    </div>
</body>
</html>
