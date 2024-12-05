@extends('main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Permission
                            <a href="{{route('permissions.index')}}" class="btn btn-danger float-end" >Back</a>
                        </h4>
                    </div>

                    <div class="card-body">
                        <form action="{{route('permissions.update',$permission)}}" method="post">
                            @csrf
                            @method('PUT')
                           <div class="mb-3">
                            <label for="Name">Name</label>
                            <input type="text" name="name" placeholder="Name" class="form-control" value="{{$permission->name}}" >
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