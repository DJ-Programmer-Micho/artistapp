<!-- Insert Modal -->
<div wire:ignore.self class="modal fade overflow-auto" id="widthrawAddModal" tabindex="-1" aria-labelledby="widthrawAddModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog  text-white mx-1 mx-lg-auto">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="widthrawAddModalLabel">{{__('Add New Widthraw')}}</h5>
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close"
                    wire:click="closeModal">
                    <span aria-hidden="true"><i class="fas fa-times"></i></span></button>
            </div>
            <form wire:submit.prevent="saveWidthraw">
                <div class="modal-body">
                    <h3>{{__('Artist Widthraw')}}</h3>
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
                            <label>{{__('Widthraw Date')}}</label>
                            <input type="date" wire:model="widthrawDate" class="form-control">
                            @error('widthrawDate') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label>{{__('Amount')}}</label>
                            <input type="number" wire:model="amount" class="form-control" >
                            @error('amount') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label>{{__('Note')}}</label>
                            <textarea name="" id=""  wire:model="note" cols="30" rows="5" class="form-control"></textarea>
                            @error('note') <span class="text-danger">{{ $message }}</span> @enderror
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
<div wire:ignore.self class="modal fade overflow-auto" id="widthrawUpdateModal" tabindex="-1" aria-labelledby="widthrawUpdateModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog text-white mx-1 mx-lg-auto">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="widthrawUpdateModalLabel">{{__('Update Artist Widthraw')}}</h5>
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close"
                    wire:click="closeModal">
                    <span aria-hidden="true"><i class="fas fa-times"></i></span></button>
            </div>
            <form wire:submit.prevent="updateWidthraw">
                <div class="modal-body">
                    <h3>{{__('Artist Widthraw')}}</h3>
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
                            <label>{{__('Widthraw Date')}}</label>
                            <input type="date" wire:model="widthrawDate" class="form-control">
                            @error('widthrawDate') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label>{{__('Amount')}}</label>
                            <input type="number" wire:model="amount" class="form-control" >
                            @error('amount') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label>{{__('Note')}}</label>
                            <textarea name="" id=""  wire:model="note" cols="30" rows="5" class="form-control"></textarea>
                            @error('note') <span class="text-danger">{{ $message }}</span> @enderror
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
<div wire:ignore.self class="modal fade" id="deleteWidthrawModal" tabindex="-1" aria-labelledby="deleteWidthrawModalLabel"
    aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog text-white">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteWidthrawModalLabel">{{__('Delete Artist Widthraw')}}</h5>
                <button type="button" class="btn btn-danger" data-dismiss="modal" wire:click="closeModal"
                    aria-label="Close"><i class="fas fa-times"></i></button>
            </div>
            <form wire:submit.prevent="destroyWidthraw">
                <div class="modal-body">
                    <p class="text-danger"><b>{{ __('Are you sure you want to delete this Artist Widthraw?') }}</b></p>
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