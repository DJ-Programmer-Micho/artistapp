@extends('admins.layout')
@section('content')
    @livewire('admin.artist-widthraw-livewire')
@endsection
@section('modalScript')
<script>
    window.addEventListener('close-modal', event => {
    $('#widthrawAddModal').modal('hide');
    $('#widthrawUpdateModal').modal('hide');
    $('#deleteWidthrawModal').modal('hide');
}) 
</script>
@endsection
