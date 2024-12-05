@extends('main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                @if (session('status'))
                    <div class="alert alert-success ">{{ session('status') }}</div>
                @endif
                <div class="card">
                    <div class="card-header">
                        <h4>Role :{{ $role->name }}
                            <a href="{{ route('roles.index') }}" class="btn btn-danger float-end">Back</a>
                        </h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('updatePermissionRole', $role) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="Name">Permission</label>
                                <div class="row">
                                    @foreach ($permission as $item)
                                        <div class="col-md-3">
                                            <label for="">
                                                <input type="checkbox" name="permission[]" value="{{ $item->name }}"
                                                    {{ in_array($item->id, $rolePermissions) ?'checked':'' }}>
                                                {{ $item->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>

                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-success">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
