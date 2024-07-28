@extends('admins.layout')
@section('content')
    {{-- @include('admins.components.artistTable') --}}
    @livewire('admin.song-livewire')
@endsection
@section('modalScript')
<script>
    window.addEventListener('close-modal', event => {
    $('#songAddModal').modal('hide');
    $('#songUpdateModal').modal('hide');
    $('#songRenewModal').modal('hide');
}) 

window.addEventListener('close-modal-renew', event => {
    $('#deleteRenewModal').modal('hide');
    $('#songRenewUpdateModal').modal('hide');
}) 
</script>
@endsection
