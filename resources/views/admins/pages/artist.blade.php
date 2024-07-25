@extends('admins.layout')
@section('content')
    {{-- @include('admins.components.artistTable') --}}
    @livewire('admin.artist-livewire')
@endsection
@section('modalScript')
<script>
    window.addEventListener('close-modal', event => {
    $('#artistAddModal').modal('hide');
    $('#artistUpdateModal').modal('hide');
    $('#deleteArtistModal').modal('hide');
}) 
</script>
@endsection
