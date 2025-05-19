@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Daftar Profile</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Username</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->username }}</td>
                <td>
                    <a href="{{ route('admin.show', $user->id) }}" class="btn btn-primary btn-sm">Lihat Hasil</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
