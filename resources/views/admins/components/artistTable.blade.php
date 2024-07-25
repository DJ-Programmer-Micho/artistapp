<div>
    @include('admins.components.artistForm')
    <div class="m-4">
        <div class="d-flex justidy-content-between mb-1">
            <h2 class="text-lg text-white font-medium mr-auto">
                <b>{{__('TABLE ARTISTS')}}</b>
            </h2>
            <div class="">
                <button class="btn btn-info" data-toggle="modal"
                    data-target="#artistAddModal">{{__('Add New Artist')}}</button>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12 col-lg-3">
                <label class="text-white">{{__('Search')}}</label>
                <input type="search" wire:model.live="search" class="form-control bg-white text-black"
                    placeholder="{{__('Search...')}}" style="border: 1px solid var(--primary)"/>
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
                        <td>
                            @if ($col === 'status')
                                <span class="{{ $item->status == 1 ? 'text-success' : 'text-danger' }}">
                                   <b>{{ $item->status == 1 ? __('Active') : __('Non-Active') }}</b>
                                </span>
                            @elseif ($col === 'poster')        
                                <input type="number" id="priority_{{ $item->id }}" value="{{ $item->priority }}" class="form-control bg-dark text-white">
                            @else
                                {{ data_get($item, $col) }}
                            @endif
                        </td>
                        @endforeach
                        <td>
                            <button type="button"
                                wire:click="updateStatus({{ $item->id }})"
                                class="btn {{ $item->status == 0 ? 'btn-danger' : 'btn-success' }} m-1">
                                <i class="far {{ $item->status == 0 ? 'fa-times-circle' : 'fa-check-circle' }}"></i>
                            </button>
                            <button type="button" data-toggle="modal" data-target="#artistUpdateModal"
                                wire:click="editArtist({{ $item->id }})" class="btn btn-primary m-1">
                                <i class="far fa-edit"></i>
                            </button>
                            <button type="button" data-toggle="modal" data-target="#deleteArtistModal"
                                wire:click="deleteArtist({{ $item->id }})" class="btn btn-danger m-1">
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
@if(session()->has('alert'))
    @php $alert = session()->get('alert'); @endphp
    <script>
        toastr.{{ $alert['type'] }}('{{ $alert['message'] }}');
    </script>
@endif
@push('cropper')
{{-- <script>
    function updatePriorityValue(itemId) {
        var input = document.getElementById('priority_' + itemId);
        var updatedPriority = input.value;
        @this.call('updatePriority', itemId, updatedPriority);
    }
</script> --}}
@endpush