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
</script>
@endsection
