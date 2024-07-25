@extends('admins.layout')
@section('content')
    @livewire('admin.artist-profit-livewire')
@endsection
@section('modalScript')
<script>
    window.addEventListener('close-modal', event => {
    $('#profitAddModal').modal('hide');
    $('#profitUpdateModal').modal('hide');
    $('#deleteProfitModal').modal('hide');
}) 
</script>
@endsection
