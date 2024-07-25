@extends('admins.layout')
@section('content')
    {{-- @include('admins.components.artistTable') --}}
    @livewire('admin.excruciating-detail-livewire')
@endsection
@section('modalScript')
<script>
    window.addEventListener('close-modal', event => { $('#detailAddModal').modal('hide'); }) 
    
    window.addEventListener('close-modal-confirmation', event => { $('#addComformationModal').modal('hide'); }) 
    // window.addEventListener('close-modal', event => { $('#detailAddModal').modal('hide'); }) 
</script>
@endsection
