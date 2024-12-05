@extends('main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if (session('status'))
                    <div class="alert alert-success ">{{session('status')}}</div>
                @endif
                <div class="card">
                    <div class="card-header">
                        <h4>Permission
                            <a href="{{route('permissions.create')}}" class="btn btn-primary float-end" >Add Permission</a>
                        </h4>

                        @include('role-permission.nav-link')
                    </div>

                    <div class="card-body">
                        <x-table-crud 
                        :headers="$table['headers']" 
                        :list="$table['list']" 
                        :actions="$table['actions']" 
                        :routes="$table['routes']" />

                    </div>
                    {{$table['list']->links()}}
                </div>
            </div>
        </div>
    </div>
@endsection