<!-- Insert Modal -->
<div wire:ignore.self class="modal fade overflow-auto" id="profitAddModal" tabindex="-1" aria-labelledby="profitAddModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog  text-white mx-1 mx-lg-auto">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="profitAddModalLabel">{{__('Add New Profit')}}</h5>
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close"
                    wire:click="closeModal">
                    <span aria-hidden="true"><i class="fas fa-times"></i></span></button>
            </div>
            <form wire:submit.prevent="saveProfit">
                <div class="modal-body">
                    <h3>{{__('Artist Profit')}}</h3>
                    <div class="col-12">
                        <div class="mb-3">
                            <label>{{__('Select Artist')}}</label>
                            <select wire:model="selectArtist" name="selectArtist" id="selectArtist" class="form-control">
                                <option value="">{{__('Select Artist')}}</option>
                                @foreach ($artistList as $artist)
                                    <option value="{{$artist->id}}">{{$artist->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>{{__('Profit %')}}</label>
                            <input type="number" wire:model="profitPercentage" class="form-control" >
                            @error('profitPercentage') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label>{{__('Effective Date')}}</label>
                            <input type="date" wire:model="effectiveDate" class="form-control">
                            @error('effectiveDate') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label>{{__('End Date')}}</label>
                            <input type="date" wire:model="endDate" class="form-control">
                            <small class="text-info"><b>(OPTIONAL)</b></small>
                            @error('endDate') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeModal"
                        data-dismiss="modal">{{__('Close')}}</button>
                    <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Update Modal -->
<div wire:ignore.self class="modal fade overflow-auto" id="profitUpdateModal" tabindex="-1" aria-labelledby="profitUpdateModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog text-white mx-1 mx-lg-auto">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="profitUpdateModalLabel">{{__('Update Artist Profit')}}</h5>
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close"
                    wire:click="closeModal">
                    <span aria-hidden="true"><i class="fas fa-times"></i></span></button>
            </div>
            <form wire:submit.prevent="updateProfit">
                <div class="modal-body">
                    <h3>{{__('Artist Profit')}}</h3>
                    <div class="col-12">
                        <div class="mb-3">
                            <label>{{__('Select Artist')}}</label>
                            <select wire:model="selectArtist" name="selectArtist" id="selectArtist" class="form-control">
                                <option value="">{{__('Select Artist')}}</option>
                                @foreach ($artistList as $artist)
                                    <option value="{{$artist->id}}">{{$artist->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>{{__('Profit %')}}</label>
                            <input type="number" wire:model="profitPercentage" class="form-control" >
                            @error('profitPercentage') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label>{{__('Effective Date')}}</label>
                            <input type="date" wire:model="effectiveDate" class="form-control">
                            @error('effectiveDate') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label>{{__('End Date')}}</label>
                            <input type="date" wire:model="endDate" class="form-control">
                            @error('endDate') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeModal"
                        data-dismiss="modal">{{__('Close')}}</button>
                    <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div wire:ignore.self class="modal fade" id="deleteProfitModal" tabindex="-1" aria-labelledby="deleteProfitModalLabel"
    aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog text-white">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteProfitModalLabel">{{__('Delete Artist Profit')}}</h5>
                <button type="button" class="btn btn-danger" data-dismiss="modal" wire:click="closeModal"
                    aria-label="Close"><i class="fas fa-times"></i></button>
            </div>
            <form wire:submit.prevent="destroyProfit">
                <div class="modal-body">
                    <p class="text-danger"><b>{{ __('Are you sure you want to delete this Artist Profit?') }}</b></p>
                    <p>{{ __('Please enter the name below to confirm:')}}</p>
                    <p><strong>{{$showTextTemp}}</strong></p>
                    <input type="text" wire:model.live="artistNameToDelete" class="form-control">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeModal"
                        data-dismiss="modal">{{__('Cancel')}}</button>
                        <button type="submit" class="btn btn-danger" {{!$confirmDelete ? "disabled" : ""}}>
                            {{ __('Yes! Delete') }}
                        </button>
                </div>
            </form>
        </div>
    </div>
</div>