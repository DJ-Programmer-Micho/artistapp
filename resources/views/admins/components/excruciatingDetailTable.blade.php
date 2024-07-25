<div>
    <div class="m-4">
        <div class="d-flex justidy-content-between mb-1">
            <h2 class="text-lg text-white font-medium mr-auto">
                <b>{{__('TABLE SONGS EXCRUCIATING DETAILS')}}</b>
            </h2>

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
                <select wire:model.live="selectArtistFilter" wire:change="updateSongList" name="selectArtistFilter" id="selectArtistFilter" class="form-control">
                    <option value="">{{__('Select Artist')}}</option>
                    @foreach ($artistList as $artist)
                        <option value="{{$artist->id}}">{{$artist->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-12 col-lg-3">
                <label>{{__('Song Track')}}</label>
                <select wire:model.live="selectSongFilter" name="selectSongFilter" id="selectSongFilter" class="form-control">
                    <option value="">{{__('Select Song')}}</option>
                    @foreach ($songList as $song)
                        <option value="{{$song->id}}">{{$song->song_name}}</option>
                    @endforeach
                </select>
            </div>

        </div>
        @if (session()->has('message'))
        <h5 class="alert alert-success">{{ session('message') }}</h5>
        @endif

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
                        @php
                            $songDetails = \App\Models\SongDetail::where('song_id', $item->id)->get();
                        @endphp
                        @foreach ($songDetails as $detail)
                            <tr>
                                @foreach ($cols_td as $col)
                                    <td class="align-middle">
                                        @if ($col === 'status')
                                            <span class="{{ $item->status == 1 ? 'text-success' : 'text-danger' }}">
                                                <b>{{ $item->status == 1 ? __('Active') : __('Non-Active') }}</b>
                                            </span>
                                        @elseif ($col === 'poster')
                                            <img src="{{ app('distCloud') . $item->poster }}" alt="{{ app('distCloud') . $item->poster }}" width="75">
                                        @elseif ($col === 'earnings_usd')
                                            {{ number_format($detail->earnings_usd, 2) }} USD
                                        @elseif ($col === 'artistProfit')
                                            {{ number_format($artistProfits[$detail->id] ?? 0, 2) }} USD
                                        @elseif ($col === 'myProfit')
                                            {{ number_format($myProfits[$detail->id] ?? 0, 2) }} USD
                                        @else
                                            {{ data_get($item, $col) }}
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="{{ count($cols_th) + 1 }}">{{ __('No Record Found') }}</td>
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