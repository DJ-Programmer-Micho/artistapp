<div>
    @include('admins.components.songForm')
    <div class="m-4">
        <div class="d-flex justidy-content-between mb-1">
            <h2 class="text-lg text-white font-medium mr-auto">
                <b>{{__('TABLE SONGS')}} - {{$song_count}}</b>
            </h2>

            <div class="">
                <button class="btn btn-success" data-toggle="modal"
                    data-target="#songAddModal">{{__('Add New Song')}}</button>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12 col-lg-3">
                <label class="text-white">{{__('Search')}}</label>
                <h2 class="text-lg font-medium mr-auto">
                    <input type="search" wire:model.live="search" class="form-control bg-white text-black"
                        placeholder="{{__('Search...')}}" style="border: 1px solid var(--primary)" />
                </h2>
            </div>

            <div class="col-12 col-lg-3">
                <label>{{__('Artist')}}</label>
                <select wire:model.live="selectArtistFilter" name="selectArtistFilter" id="selectArtistFilter" class="form-control">
                    <option value="">{{__('Select Artist')}}</option>
                    @foreach ($artistList as $artist)
                        <option value="{{$artist->id}}">{{$artist->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-12 col-lg-3">
                <label class="text-white">{{__('Status Select')}}</label>
                <select wire:model.live="statusFilter" class="form-control bg-white text-black w-100">
                    <option value="" default>{{__('All')}}</option>
                    <option value="1">{{__('Active')}}</option>
                    <option value="0">{{__('Non-Active')}}</option>
                </select>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover table-sm table-dark">
                <thead>
                    <tr>
                        @foreach ($cols_th as $col)
                        <th>{{ __($col) }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $item)
                    <tr>
                        @foreach ($cols_td as $col)
                        <td class="align-middle">
                            @if ($col === 'status')
                                <span class="{{ $item->status == 1 ? 'text-success' : 'text-danger' }}">
                                   <b>{{ $item->status == 1 ? __('Active') : __('Non-Active') }}</b>
                                </span>
                                @elseif ($col === 'poster')     
                                <img src="{{app('distCloud').$item->poster}}" alt="{{app('distCloud').$item->poster}}" 
                                width="75" onerror="this.onerror=null; this.src='{{ $emptyImg }}';">   
                                
                                @elseif ($col === 'latestRenewal.expire_date')
                                @php
                                    $expireDate = \Carbon\Carbon::parse($item->latestRenewal->expire_date);
                                    $currentDate = \Carbon\Carbon::now();
                                    $daysDifference = $expireDate->diffInDays($currentDate, false); // Calculate the difference in days with negative values
                                    $colorClass = 'text-success'; // Default color is green

                                    if ($daysDifference >= 0) {
                                        $colorClass = 'text-danger'; // Red color if expired
                                    } elseif ($daysDifference <= 0 && $daysDifference >= -10) {
                                        $colorClass = 'text-warning'; // Yellow color if within 10 days of expiry
                                    }
                                @endphp
                                <span class="{{ $colorClass }}">
                                    <b>{{ $item->latestRenewal->expire_date }} ({{$daysDifference}})</b>
                                </span>
                                @else
                                {{ data_get($item, $col) }}
                            @endif
                        </td>
                        @endforeach
                        <td class="align-middle">
                            <button type="button"
                                wire:click="updateStatus({{ $item->id }})"
                                class="btn {{ $item->status == 0 ? 'btn-danger' : 'btn-success' }} m-1">
                                <i class="far {{ $item->status == 0 ? 'fa-times-circle' : 'fa-check-circle' }}"></i>
                            </button>
                            <button type="button" data-toggle="modal" data-target="#songUpdateModal"
                                wire:click="editSong({{ $item->id }})" class="btn btn-primary m-1">
                                <i class="far fa-edit"></i>
                            </button>
                            <button type="button" data-toggle="modal" data-target="#songRenewModal"
                                wire:click="editSong({{ $item->id }})" class="btn btn-warning text-dark m-1">
                                <i class="fas fa-history fa-flip-horizontal"></i>
                            </button>
                            <button type="button" data-toggle="modal" data-target="#deleteSongModal"
                                wire:click="deleteSong({{ $item->id }})" class="btn btn-danger m-1">
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ count($cols_th) + 1 }}">{{__('No Record Found')}}</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="dark:bg-gray-800 dark:text-white">
            {{ $items->links() }}
        </div>

    </div>
</div>
</div>

</div>