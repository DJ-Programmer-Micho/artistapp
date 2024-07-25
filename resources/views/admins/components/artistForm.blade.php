{{-- style="{{$locale == "ar" || $locale == 'ku' ? "direction: rtl;" : ""}}" --}}

<!-- Insert Modal -->
<div wire:ignore.self class="modal fade overflow-auto" id="artistAddModal" tabindex="-1" aria-labelledby="artistAddModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl text-white mx-1 mx-lg-auto" style="max-width: 1140px;">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="artistAddModalLabel">{{__('Add New Artist')}}</h5>
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close"
                    wire:click="closeModal">
                    <span aria-hidden="true"><i class="fas fa-times"></i></span></button>
            </div>
            <form wire:submit.prevent="saveArtist">
                <div class="modal-body">
                    <h3>{{__('Artist Information')}}</h3>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="row">
                                <div class="mb-3 col-6">
                                    <label>{{__('First Name')}}</label>
                                    <input type="text" wire:model="firstName" class="form-control" >
                                    @error('firstName') <span class="text-danger">{{ $message }}</span> @enderror
                                    <small class="bg-info text-white px-2 rounded"><b>{{__('Actual Name')}}</b></small>
                                </div>
                                <div class="mb-3 col-6">
                                    <label>{{__('Last Name')}}</label>
                                    <input type="text" wire:model="lastName" class="form-control" >
                                    @error('lastName') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                            </div>
                            <div class="mb-3">
                                <label>{{__('Artist Name')}}</label>
                                <input type="text" wire:model="artistName" class="form-control" >
                                @error('artistName') <span class="text-danger">{{ $message }}</span> @enderror
                                <small class="bg-danger text-white px-2 rounded"><b>{{__('Small Letters and no white Spaces')}}</b></small>
                            </div>
                            <div class="mb-3">
                                <label>{{__('Country')}}</label>
                                <input type="text" wire:model="country" class="form-control" >
                                @error('country') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label>{{__('City')}}</label>
                                <input type="text" wire:model="city" class="form-control" >
                                @error('city') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label>{{__('MET Email')}}</label>
                                <input type="email" wire:model="metEmail" class="form-control" >
                                @error('metEmail') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label>{{__('Password')}}</label>
                                <input type="password" wire:model="password" class="form-control" autocomplete="true">
                                @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    
                        <div class="col-12 col-md-6">
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
                                <label>{{__('Profit')}}</label>
                                <select wire:model="profit" name="profit" id="profit" class="form-control">
                                    <option value="">{{__('Choose Profit')}}</option>
                                    <option value="10">{{__('10%')}}</option>
                                    <option value="20">{{__('20%')}}</option>
                                    <option value="30">{{__('30%')}}</option>
                                    <option value="40">{{__('40%')}}</option>
                                    <option value="50">{{__('50%')}}</option>
                                    <option value="60">{{__('60%')}}</option>
                                    <option value="70">{{__('70%')}}</option>
                                    <option value="80">{{__('80%')}}</option>
                                    <option value="90">{{__('90%')}}</option>
                                </select>
                                <small class="bg-danger text-white px-2 rounded"><b>{{__('(FIXED) cannot be changed')}}</b></small>
                                @error('profit') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                  
                            <div class="mb-3">
                                <label>{{__('Phone Number')}}</label>
                                <input type="text" wire:model="phoneNumber" class="form-control" >
                                @error('phoneNumber') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label>{{__('Passport')}}</label>
                                <input type="text" wire:model="passport" class="form-control" >
                                @error('passport') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label>{{__('YouTube Channel')}}</label>
                                <input type="text" wire:model="youtube" class="form-control" >
                                @error('youtube') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label>{{__('Official Email')}}</label>
                                <input type="email" wire:model="officialEmail" class="form-control" >
                                @error('officialEmail') <span class="text-danger">{{ $message }}</span> @enderror
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

<!-- Update Modal -->
<div wire:ignore.self class="modal fade overflow-auto" id="artistUpdateModal" tabindex="-1" aria-labelledby="artistUpdateModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl text-white mx-1 mx-lg-auto" style="max-width: 1140px;">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="artistUpdateModalLabel">{{__('Add New Artist')}}</h5>
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close"
                    wire:click="closeModal">
                    <span aria-hidden="true"><i class="fas fa-times"></i></span></button>
            </div>
            <form wire:submit.prevent="updateArtist">
                <div class="modal-body">
                    <h3>{{__('Artist Information')}}</h3>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="row">
                                <div class="mb-3 col-6">
                                    <label>{{__('First Name')}}</label>
                                    <input type="text" wire:model="firstName" class="form-control" >
                                    @error('firstName') <span class="text-danger">{{ $message }}</span> @enderror
                                    <small class="bg-info text-white px-2 rounded"><b>{{__('Actual Name')}}</b></small>
                                </div>
                                <div class="mb-3 col-6">
                                    <label>{{__('Last Name')}}</label>
                                    <input type="text" wire:model="lastName" class="form-control" >
                                    @error('lastName') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                            </div>
                            <div class="mb-3">
                                <label>{{__('Artist Name')}}</label>
                                <input type="text" wire:model="artistName" class="form-control" >
                                @error('artistName') <span class="text-danger">{{ $message }}</span> @enderror
                                <small class="bg-danger text-white px-2 rounded"><b>{{__('Small Letters and no white Spaces')}}</b></small>
                            </div>
                            <div class="mb-3">
                                <label>{{__('Country')}}</label>
                                <input type="text" wire:model="country" class="form-control" >
                                @error('country') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label>{{__('City')}}</label>
                                <input type="text" wire:model="city" class="form-control" >
                                @error('city') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label>{{__('MET Email')}}</label>
                                <input type="email" wire:model="metEmail" class="form-control" >
                                @error('metEmail') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label>{{__('Password')}}</label>
                                <input type="password" wire:model="password" class="form-control" autocomplete="true">
                                @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    
                        <div class="col-12 col-md-6">
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
                                <label>{{__('Profit')}}</label>
                                <select wire:model="profit" name="profit" id="profit" class="form-control">
                                    <option value="">{{__('Choose Profit')}}</option>
                                    <option value="10">{{__('10%')}}</option>
                                    <option value="20">{{__('20%')}}</option>
                                    <option value="30">{{__('30%')}}</option>
                                    <option value="40">{{__('40%')}}</option>
                                    <option value="50">{{__('50%')}}</option>
                                    <option value="60">{{__('60%')}}</option>
                                    <option value="70">{{__('70%')}}</option>
                                    <option value="80">{{__('80%')}}</option>
                                    <option value="90">{{__('90%')}}</option>
                                </select>
                                <small class="bg-danger text-white px-2 rounded"><b>{{__('(FIXED) cannot be changed')}}</b></small>
                                @error('profit') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                  
                            <div class="mb-3">
                                <label>{{__('Phone Number')}}</label>
                                <input type="text" wire:model="phoneNumber" class="form-control" >
                                @error('phoneNumber') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label>{{__('Passport')}}</label>
                                <input type="text" wire:model="passport" class="form-control" >
                                @error('passport') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label>{{__('YouTube Channel')}}</label>
                                <input type="text" wire:model="youtube" class="form-control" >
                                @error('youtube') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label>{{__('Official Email')}}</label>
                                <input type="email" wire:model="officialEmail" class="form-control" >
                                @error('officialEmail') <span class="text-danger">{{ $message }}</span> @enderror
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
<div wire:ignore.self class="modal fade" id="deleteArtistModal" tabindex="-1" aria-labelledby="deleteArtistModalLabel"
    aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog text-white">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteArtistModalLabel">{{__('Delete Artist')}}</h5>
                <button type="button" class="btn btn-danger" data-dismiss="modal" wire:click="closeModal"
                    aria-label="Close"><i class="fas fa-times"></i></button>
            </div>
            <form wire:submit.prevent="destroyArtist">
                <div class="modal-body">
                    <p class="text-danger"><b>{{ __('Are you sure you want to delete this Artist?') }}</b></p>
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