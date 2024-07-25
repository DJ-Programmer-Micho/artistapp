<div>
    @include('admins.components.detailForm')
    <div class="m-4">
        <div class="d-flex justify-content-between mb-1">
            <h2 class="text-lg text-white font-medium mr-auto">
                <b>{{ __('TABLE SONGS DETAILS') }}</b>
            </h2>

            <div class="">
                <button class="btn btn-success" data-toggle="modal" data-target="#detailAddModal">{{ __('Add New Song Details') }}</button>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12 col-lg-3">
                <label class="text-white">{{ __('Search') }}</label>
                <h2 class="text-lg font-medium mr-auto">
                    <input type="search" wire:model.live="search" class="form-control bg-white text-black"
                        placeholder="{{ __('Search...') }}" style="border: 1px solid var(--primary)" />
                </h2>
            </div>

            <div class="col-12 col-lg-3">
                <label>{{ __('Artist') }}</label>
                <select wire:model.live="selectArtistFilter" name="selectArtistFilter" id="selectArtistFilter" class="form-control">
                    <option value="">{{ __('Select Artist') }}</option>
                    @foreach ($artistList as $artist)
                        <option value="{{ $artist->id }}">{{ $artist->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-12 col-lg-3">
                <label class="text-white">{{ __('Status Select') }}</label>
                <select wire:model.live="statusFilter" class="form-control bg-white text-black w-100">
                    <option value="" default>{{ __('All') }}</option>
                    <option value="1">{{ __('Active') }}</option>
                    <option value="0">{{ __('Non-Active') }}</option>
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
                    <tr>
                        @foreach ($cols_td as $col)
                        <td class="align-middle">
                            @if ($col === 'status')
                                <span class="{{ $item['status'] == 1 ? 'text-success' : 'text-danger' }}">
                                   <b>{{ $item['status'] == 1 ? __('Active') : __('Non-Active') }}</b>
                                </span>
                            @elseif ($col === 'poster')     
                                <img src="{{ app('distCloud').$item['poster'] }}" alt="{{ $item['poster'] }}" width="75">   
                            @elseif ($col === 'earnings_usd')
                                {{ number_format($item['earnings_usd'], 2) }} USD
                            @elseif ($col === 'artistProfit')
                                {{ number_format($item['artistProfit'], 2) }} USD
                            @elseif ($col === 'myProfit')
                                {{ number_format($item['myProfit'], 2) }} USD
                            @else
                                {{ data_get($item, $col) }}
                            @endif
                        </td>
                        @endforeach
                        <td class="align-middle">
                            <button type="button"
                                wire:click="updateStatus({{ $item['id'] }})"
                                class="btn {{ $item['status'] == 0 ? 'btn-danger' : 'btn-success' }} m-1">
                                <i class="far {{ $item['status'] == 0 ? 'fa-times-circle' : 'fa-check-circle' }}"></i>
                            </button>
                            <button type="button" data-toggle="modal" data-target="#deleteSongModal"
                                wire:click="deleteSong({{ $item['id'] }})" class="btn btn-danger m-1">
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
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

@if(session()->has('alert'))
    @php $alert = session()->get('alert'); @endphp
    <script>
        toastr.{{ $alert['type'] }}('{{ $alert['message'] }}');
    </script>
@endif

@push('cropper')
@endpush
