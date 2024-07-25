<div>
    <div class="card hovercard mb-4">
        <div class="cardheader" style="background: url('{{ $bannerImageUrl }}') no-repeat center center; background-size: cover;">
        </div>
        <div class="avatar">
            <img alt="" src="{{$thumbnails}}">
        </div>
    
    
    
        <div class="info">
            <div class="title">
                <h2 class="text-white">{{$channelName}}</h2>
            </div>
            <div class="text-white">{{$customUrl}} - {{$country}}</div>
    
            <div class="text-white">{{$description}}</div>
        </div>
    </div>
    @livewire('artists.dashboard-card-livewire',[
        "subscribe" => $subscribersCount,
        "views" => $viewCount,
        "uploads" => $uploadsCount,
    ])
</div>