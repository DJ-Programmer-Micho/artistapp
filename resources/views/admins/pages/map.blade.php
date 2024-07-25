@extends('admins.layout')
@section('content')
<div class="m-4">
    @livewire('admin.dashboard-artist-progress-livewire')
    @livewire('admin.dashboard-admin-map-livewire')
</div>
@endsection