<div>
    <div class="m-4">
        <div class="d-flex justidy-content-between mb-1">
            <h2 class="text-lg text-white font-medium mr-auto">
                <b>{{__('TABLE ARTIST WIDTHRAW')}}</b>
            </h2>
        </div>
        {{-- <div class="row mb-3">
            <div class="col-12 col-lg-3">
                <label class="text-white">{{__('Search')}}</label>
                <h2 class="text-lg font-medium mr-auto">
                    <input type="search" wire:model.live="search" class="form-control bg-white text-black"
                        placeholder="{{__('Search...')}}" style="border: 1px solid var(--primary)" />
                </h2>
            </div>

        </div> --}}
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
                            @if ($col === 'amount')
                                <b class="text-success">{{ number_format($item->amount, 2) }} USD</b>
                            @else
                                {{ data_get($item, $col) }}
                            @endif
                        </td>
                        @endforeach
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

@if(session()->has('alert'))
    @php $alert = session()->get('alert'); @endphp
    <script>
        toastr.{{ $alert['type'] }}('{{ $alert['message'] }}');
    </script>
@endif

@push('cropper')
@endpush
