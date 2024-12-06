@extends('main')

@section('content')
    <div>
        
        <livewire:category-show>
    </div>
@endsection

@section('script')
    <script>
        window.addEventListener('close-modal',event =>{
            $('#categoryModal').modal('hide');
        })
    </script>
@endsection
