@extends('main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Role
                            <a href="{{route('users.index')}}" class="btn btn-danger float-end" >Back</a>
                        </h4>
                    </div>

                    <div class="card-body">
                        <form action="{{route('users.store')}}" method="post">
                            @csrf

                           <div class="mb-3">
                            <label for="Name">Name</label>
                            <input type="text" name="name" placeholder="Name" class="form-control" >
                           </div>

                           <div class="mb-3">
                            <label for="Email">Email</label>
                            <input type="text" name="email" placeholder="Email" class="form-control" >
                           </div>

                           <div class="mb-3">
                            <label for="Password">Password</label>
                            <input type="password" name="password" placeholder="Password" class="form-control" >
                           </div>

                           <div class="mb-3">
                            <label for="Name">Roles</label>
                           <select name="roles[]" id="roles" class="form-select" multiple >
                            <option value="">---Select---</option>
                            @foreach ($roles as $role)
                                <option value="{{$role}}">{{$role}}</option>
                            @endforeach
                           </select>
                           </div>
                           <div class="mb-3">
                            <button type="submit" class="btn btn-success" >Submit</button>
                           </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection