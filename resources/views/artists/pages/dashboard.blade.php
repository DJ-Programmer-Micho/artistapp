@extends('artists.layout')
@section('content')
<div class="m-4">
    @livewire('artists.youtube-card-livewire')
    @livewire('artists.dashboard-artist-chart-livewire')
</div>
@endsection
