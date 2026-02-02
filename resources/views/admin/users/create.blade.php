@extends('layouts.admin')

@section('title', 'Add a user')

@section('content')
<div class="block" style="max-width:800px;">
    <h3 style="text-align:center;margin-bottom:30px;">Add a user</h3>

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

    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        @include('admin.users._form', ['user' => null, 'roles' => $roles])

        <div style="margin-top:30px;display:flex;gap:20px;justify-content:center;">
            <a href="{{ route('admin.users.index') }}" style="padding:10px 40px;background:#cccccc;color:#333;border:none;border-radius:4px;cursor:pointer;text-decoration:none;font-weight:600;">
                cancel
            </a>
            <button type="submit" style="padding:10px 40px;background:#9BAF0A;color:white;border:none;border-radius:4px;cursor:pointer;font-weight:600;">
                Save
            </button>
        </div>
    </form>
</div>
@endsection
