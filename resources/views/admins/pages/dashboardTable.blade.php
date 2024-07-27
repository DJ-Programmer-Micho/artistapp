@extends('admins.layout')
@section('content')
<div class="m-4">
    {{-- @livewire('admin.dashboard-card-livewire') --}}
    {{-- @livewire('admin.dashboard-artist-chart-livewire') --}}
    @livewire('admin.dashboard-table-livewire')
</div>
@endsection
