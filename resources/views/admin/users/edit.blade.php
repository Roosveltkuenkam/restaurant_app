@extends('layouts.admin')

@section('title', 'Edit user ' . $user->name)

@section('content')
<div class="block" style="max-width:600px;">
    <h3 style="text-align:center;margin-bottom:20px;">Edit the user</h3>

    @if ($errors->any())
        <div style="padding:12px;background:#f8d7da;color:#721c24;border-radius:8px;margin-bottom:16px;">
            <strong>Erreurs :</strong>
            <ul style="margin:8px 0 0 20px;padding:0;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.users._form', ['user' => $user, 'roles' => $roles])

        <div style="margin-top:20px;display:flex;gap:10px;">
            <button type="submit" style="padding:10px 20px;background:#9BAF0A;color:white;border:none;border-radius:4px;cursor:pointer;font-weight:600;font-size:14px;">
                Update
            </button>
            <a href="{{ route('admin.users.index') }}" style="padding:10px 20px;background:#cccccc;color:#333;border:none;border-radius:4px;cursor:pointer;text-decoration:none;font-weight:600;font-size:14px;">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
