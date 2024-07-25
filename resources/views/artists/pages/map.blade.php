@extends('artists.layout')
@section('content')
<div class="m-4">
    @livewire('artists.dashboard-artist-progress-livewire')
    @livewire('artists.dashboard-artist-map-livewire')
</div>
@endsection