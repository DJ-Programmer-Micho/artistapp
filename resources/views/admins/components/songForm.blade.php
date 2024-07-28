{{-- INSERT MODAL --}}
<div wire:ignore.self class="modal fade overflow-auto" id="songAddModal" tabindex="-1" aria-labelledby="songAddModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl text-white mx-1 mx-lg-auto" style="max-width: 1140px;">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="songAddModalLabel">{{__('Add New Song')}}</h5>
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close"
                    wire:click="closeModal">
                    <span aria-hidden="true"><i class="fas fa-times"></i></span></button>
            </div>
            <form wire:submit.prevent="saveSong">
                <div class="modal-body">
                    <h3>{{__('Song Information')}}</h3>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label>{{__('First Name')}}</label>
                                <select wire:model="selectArtist" name="selectArtist" id="selectArtist" class="form-control">
                                    <option value="">{{__('Select Artist')}}</option>
                                    @foreach ($artistList as $artist)
                                        <option value="{{$artist->id}}">{{$artist->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>{{__('Song Name')}}</label>
                                <input type="text" wire:model="songName" class="form-control" >
                                @error('songName') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label>{{__('Status')}}</label>
                                <select wire:model="status" name="status" id="status" class="form-control">
                                    <option value="">{{__('Choose Status')}}</option>
                                    <option value="1">{{__('Active')}}</option>
                                    <option value="0">{{__('Non Active')}}</option>
                                </select>
                                <small class="bg-info text-white px-2 rounded"><b>{{__('Active or non-active / Show or Hide')}}</b></small>
                                @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label>{{__('Release Date')}}</label>
                                <input type="date" wire:model="releaseDate" class="form-control" wire:change="addYear">
                                @error('releaseDate') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label>{{__('Expire Date')}}</label>
                                <input type="date" wire:model="expireDate" class="form-control" >
                                @error('expireDate') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label>{{__('Cost')}}</label>
                                <input type="number" wire:model="cost" class="form-control" >
                                @error('cost') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6">                  
                            <div class="mb-3">
                                <label>{{__('Poster URL Path')}}</label>
                                <input type="text" wire:model="poster" class="form-control" wire:change="posterViewer">
                                @error('poster') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3 d-flex justify-content-center mt-1">
                                <img id="showPoster" class="img-thumbnail rounded" src="{{$distViewer ?? $emptyImg}}">
                            </div>
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

{{-- UPDATE MODAL --}}
<div wire:ignore.self class="modal fade overflow-auto" id="songUpdateModal" tabindex="-1" aria-labelledby="songUpdateModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl text-white mx-1 mx-lg-auto" style="max-width: 1140px;">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="songUpdateModalLabel">{{__('Update Song')}}</h5>
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close"
                    wire:click="closeModal">
                    <span aria-hidden="true"><i class="fas fa-times"></i></span></button>
            </div>
            <form wire:submit.prevent="updateSong">
                <div class="modal-body">
                    <h3>{{__('Song Information')}}</h3>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label>{{__('First Name')}}</label>
                                <select wire:model="selectArtist" name="selectArtist" id="selectArtist" class="form-control">
                                    <option value="">{{__('Select Artist')}}</option>
                                    @foreach ($artistList as $artist)
                                        <option value="{{$artist->id}}">{{$artist->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>{{__('Song Name')}}</label>
                                <input type="text" wire:model="songName" class="form-control" >
                                @error('songName') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label>{{__('Status')}}</label>
                                <select wire:model="status" name="status" id="status" class="form-control">
                                    <option value="">{{__('Choose Status')}}</option>
                                    <option value="1">{{__('Active')}}</option>
                                    <option value="0">{{__('Non Active')}}</option>
                                </select>
                                <small class="bg-info text-white px-2 rounded"><b>{{__('Active or non-active / Show or Hide')}}</b></small>
                                @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label>{{__('Release Date')}}</label>
                                <input type="date" wire:model="releaseDate" class="form-control" wire:change="addYear">
                                @error('releaseDate') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label>{{__('Expire Date')}}</label>
                                <input type="date" wire:model="expireDate" class="form-control" >
                                @error('expireDate') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label>{{__('Cost')}}</label>
                                <input type="number" wire:model="cost" class="form-control" >
                                @error('cost') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6">                  
                            <div class="mb-3">
                                <label>{{__('Poster URL Path')}}</label>
                                <input type="text" wire:model="poster" class="form-control" wire:change="posterViewer">
                                @error('poster') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3 d-flex justify-content-center mt-1">
                                <img id="showPoster" class="img-thumbnail rounded" src="{{$distViewer ?? $emptyImg}}" onerror="this.onerror=null; this.src='{{ $emptyImg }}';">
                            </div>
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

{{-- Calendar MODAL --}}
<div wire:ignore.self class="modal fade overflow-auto" id="calendarModal" tabindex="-1" aria-labelledby="calendarModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl text-white mx-1 mx-lg-auto" style="max-width: 1140px;">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="calendarModalLabel">{{__('Update Song')}}</h5>
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close"
                    wire:click="closeModal">
                    <span aria-hidden="true"><i class="fas fa-times"></i></span></button>
            </div>
                <div class="modal-body">
                    <h3>{{__('Song History Renewals')}}</h3>



                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-sm table-dark">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Song Name</th>
                                    <th>Release Date</th>
                                    <th>Renew Date</th>
                                    <th>Expire Date</th>
                                    <th>Cost</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($renewalsHistory as $item)
                                <tr>
                                    <td class="align-middle">{{ $item->id }}</td>
                                    <td class="align-middle">{{ $item->song->song_name }}</td>
                                    <td class="align-middle">{{ $item->release_date }}</td>
                                    <td class="align-middle">{{ $item->renew_date }}</td>
                                    <td class="align-middle">{{ $item->expire_date }}</td>
                                    <td class="align-middle">{{ $item->cost }}</td>
                                    <td class="align-middle">
                                        <button type="button" data-toggle="modal" data-target="#songRenewUpdateModal"
                                            wire:click="editRenew({{ $item->id }})" class="btn btn-primary m-1">
                                            <i class="far fa-edit"></i>
                                        </button>
                                        <button type="button" data-toggle="modal" data-target="#deleteRenewModal"
                                            wire:click="deleteRenew({{ $item->id }})" class="btn btn-danger m-1">
                                            <i class="far fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6">{{__('No Record Found')}}</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    



                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeModal"
                        data-dismiss="modal">{{__('Close')}}</button>
                    {{-- <button type="submit" class="btn btn-primary">{{__('Save')}}</button> --}}
                </div>
        </div>
    </div>
</div>

{{-- UPDATE RENEW MODAL --}}
<div wire:ignore.self class="modal fade" id="songRenewUpdateModal" tabindex="-1" aria-labelledby="songRenewUpdateModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog text-white">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="songRenewUpdateModalLabel">{{__('Update Song')}}</h5>
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close"
                    wire:click="closeModal">
                    <span aria-hidden="true"><i class="fas fa-times"></i></span></button>
            </div>
            <form wire:submit.prevent="updateRenew">
                <div class="modal-body">
                    <h3>{{__('Renew Information')}}</h3>

                            <div class="mb-3">
                                <label>{{__('Song Name')}}</label>
                                <input type="text" wire:model="songName" class="form-control" disabled>
                                @error('songName') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label>{{__('Release Date')}}</label>
                                <input type="date" wire:model="releaseDate" class="form-control" wire:change="addYear" disabled>
                                @error('releaseDate') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label>{{__('Renew Date')}}</label>
                                <input type="date" wire:model="renewDate" class="form-control" wire:change="addYear">
                                @error('renewDate') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label>{{__('Expire Date')}}</label>
                                <input type="date" wire:model="expireDate" class="form-control" >
                                @error('expireDate') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label>{{__('Cost')}}</label>
                                <input type="number" wire:model="cost" class="form-control" >
                                @error('cost') <span class="text-danger">{{ $message }}</span> @enderror
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

{{-- RENEW MODAL --}}
<div wire:ignore.self class="modal fade overflow-auto" id="songRenewModal" tabindex="-1" aria-labelledby="songRenewModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl text-white mx-1 mx-lg-auto" style="max-width: 1140px;">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="songRenewModalLabel">{{__('Update Song')}}</h5>
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close"
                    wire:click="closeModal">
                    <span aria-hidden="true"><i class="fas fa-times"></i></span></button>
            </div>
            <form wire:submit.prevent="renewSong">
                <div class="modal-body">
                    <h3>{{__('Song Information')}}</h3>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label>{{__('First Name')}}</label>
                                <select wire:model="selectArtist" name="selectArtist" id="selectArtist" class="form-control" disabled>
                                    <option value="">{{__('Select Artist')}}</option>
                                    @foreach ($artistList as $artist)
                                        <option value="{{$artist->id}}">{{$artist->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>{{__('Song Name')}}</label>
                                <input type="text" wire:model="songName" class="form-control" disabled>
                                @error('songName') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label>{{__('Status')}}</label>
                                <select wire:model="status" name="status" id="status" class="form-control" disabled>
                                    <option value="">{{__('Choose Status')}}</option>
                                    <option value="1">{{__('Active')}}</option>
                                    <option value="0">{{__('Non Active')}}</option>
                                </select>
                                <small class="bg-info text-white px-2 rounded"><b>{{__('Active or non-active / Show or Hide')}}</b></small>
                                @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label>{{__('Release Date')}}</label>
                                <input type="date" wire:model="releaseDate" class="form-control" disabled>
                                @error('releaseDate') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label>{{__('Renew Date')}}</label>
                                <input type="date" wire:model="renewDate" class="form-control" wire:change="addYear">
                                @error('renewDate') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label>{{__('Expire Date')}}</label>
                                <input type="date" wire:model="expireDate" class="form-control" disabled>
                                @error('expireDate') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label>{{__('Cost')}}</label>
                                <input type="number" wire:model="cost" class="form-control" >
                                @error('cost') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6">                  
                            <div class="mb-3">
                                <label>{{__('Poster URL Path')}}</label>
                                <input type="text" wire:model="poster" class="form-control" wire:change="posterViewer" disabled>
                                @error('poster') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3 d-flex justify-content-center mt-1">
                                <img id="showPoster" class="img-thumbnail rounded" src="{{$distViewer ?? $emptyImg}}" onerror="this.onerror=null; this.src='{{ $emptyImg }}';">
                            </div>
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
<div wire:ignore.self class="modal fade" id="deleteSongModal" tabindex="-1" aria-labelledby="deleteSongModalLabel"
    aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog text-white">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteSongModalLabel">{{__('Delete Song')}}</h5>
                <button type="button" class="btn btn-danger" data-dismiss="modal" wire:click="closeModal"
                    aria-label="Close"><i class="fas fa-times"></i></button>
            </div>
            <form wire:submit.prevent="destroySong">
                <div class="modal-body">
                    <p class="text-danger"><b>{{ __('Are you sure you want to delete this Song?') }}</b></p>
                    <p>{{ __('Please enter the name below to confirm:')}}</p>
                    <p><strong>{{$showTextTemp}}</strong></p>
                    <input type="text" wire:model.live="songNameToDelete" class="form-control">
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

<!-- Delete Renew Modal -->
<div wire:ignore.self class="modal fade" id="deleteRenewModal" tabindex="-1" aria-labelledby="deleteRenewModalLabel"
    aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog text-white">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteRenewModalLabel">{{__('Delete Renew')}}</h5>
                <button type="button" class="btn btn-danger" data-dismiss="modal" wire:click="closeModal"
                    aria-label="Close"><i class="fas fa-times"></i></button>
            </div>
            <form wire:submit.prevent="destroyRenew">
                <div class="modal-body">
                    <p class="text-danger"><b>{{ __('Are you sure you want to delete this Renew?') }}</b></p>
                    <p>{{ __('Please enter the number below to confirm:')}}</p>
                    <p><strong>{{$showTextTemp}}</strong></p>
                    <input type="text" wire:model.live="songNameToDelete" class="form-control">
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