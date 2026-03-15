@extends('layouts.app')

@section('content')
    <div class="container">

        <h4>Assign Role User</h4>

        <form action="{{ route('roleuser.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label>User</label>
                <select name="user_id" class="form-control">

                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">
                            {{ $user->nama }}
                        </option>
                    @endforeach

                </select>
            </div>

            <div class="mb-3">
                <label>Role</label>

                <select name="role_id" class="form-control">

                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}">
                            {{ $role->nama_role }}
                        </option>
                    @endforeach

                </select>

            </div>

            <button class="btn btn-success">
                Simpan
            </button>

        </form>

    </div>
@endsection
