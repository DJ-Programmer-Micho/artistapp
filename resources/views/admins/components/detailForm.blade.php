@section('dropZone')
<link href="{{asset('assets/css/filepond.css')}}" rel="stylesheet">
<script src="{{asset('assets/js/filepond.js')}}"></script>
@endsection

<div wire:ignore.self class="modal fade overflow-auto" id="detailAddModal" tabindex="-1" aria-labelledby="detailAddModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog  text-white mx-1 mx-lg-auto" >
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="detailAddModalLabel">{{__('Add New Song Detail')}}</h5>
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close"
                    wire:click="closeModal">
                    <span aria-hidden="true"><i class="fas fa-times"></i></span></button>
            </div>
            <form>
                <div class="modal-body">
                    <h3>{{__('Song Information')}}</h3>
                    {{-- <div class="row"> --}}
                        <div class="col-12">
                            <div wire:ignore class="mb-3">
                                <label>{{__('Upload File Here')}}</label><br>
                                <input type="file" name="data" id="data">
                                @error('data') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label>{{__('Select Artist')}}</label>
                                <select wire:model="selectArtist" name="selectArtist" id="selectArtist" wire:change="updateSongList" class="form-control">
                                    <option value="">{{__('Select Artist')}}</option>
                                    @foreach ($artistList as $artist)
                                        <option value="{{$artist->id}}">{{$artist->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>{{__('Select Song')}}</label>
                                <select wire:model="selectSong" name="selectSong" id="selectSong" class="form-control">
                                    <option value="">{{__('Select Song')}}</option>
                                    @forelse ($songList as $song)
                                        <option value="{{$song->id}}">{{$song->song_name}}</option>
                                    @empty
                                        <option value="">Please Select the artist first</option>
                                    @endforelse
                                </select>
                            </div>
                        </div>
                    {{-- </div> --}}
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeModal" data-dismiss="modal">{{__('Close')}}</button>
                    <button type="button" class="btn btn-primary" wire:click="confirmationData">{{__('Check')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div wire:ignore.self class="modal fade overflow-auto" id="addComformationModal" tabindex="-1" aria-hidden="true" data-backdrop="static" data-keyboard="false" aria-labelledby="addComformationModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header">
                <h5 class="modal-title" id="addComformationModalLabel">{{__('Double Check!')}}</h5>
                <button class="close eButt" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <h5>{{__('Is This Information Correct?')}}</h5>
                <p>{{__('Artist Name: ')}} {{ $artistNameTmp }}</p>
                <p>{{__('Song Name: ')}} {{ $songNameTmp }}</p>
                <p>{{__('File Name: ')}} {{ $fileNameTmp }}</p>
                <br>
                <div class="timer">Elapsed time: <span id="elapsed-time">0</span> seconds</div>
                <div class="progress my-1">
                    <div class="progress-bar progress-bar-striped progress-bar-animated uploadProgress" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                @if (session()->has('message'))
                <h5 class="alert alert-info">{{ session('message') }}</h5>
                @endif
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger nButt" type="button" data-dismiss="modal">
                    {{__('No')}}
                </button>
                <button class="btn btn-primary yButt" type="button" wire:click="saveSongDetails" onclick="startTimer()">
                    {{__('Yes, Upload Now')}}
                </button>
            </div>
        </div>
    </div>
</div>

<!-- BULK Modal -->
<div wire:ignore.self class="modal fade overflow-auto" id="detailAddBulkModal" tabindex="-1" aria-labelledby="detailAddBulkModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog  text-white mx-1 mx-lg-auto" >
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="detailAddBulkModalLabel">{{__('Add Bulk Song Detail')}}</h5>
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close"
                    wire:click="closeModal">
                    <span aria-hidden="true"><i class="fas fa-times"></i></span></button>
            </div>
            <form>
                <div class="modal-body">
                    <h3>{{__('Song Bulk Information')}}</h3>
                    {{-- <div class="row"> --}}
                        <div class="col-12">
                            <div wire:ignore class="mb-3">
                                <label>{{__('Upload File Here')}}</label><br>
                                <input type="file" name="data" id="data">
                                @error('data') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label>{{__('Select Artist')}}</label>
                                <select wire:model="selectArtist" name="selectArtist" id="selectArtist" wire:change="updateSongList" class="form-control">
                                    <option value="">{{__('Select Artist')}}</option>
                                    @foreach ($artistList as $artist)
                                        <option value="{{$artist->id}}">{{$artist->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    {{-- </div> --}}
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeModal" data-dismiss="modal">{{__('Close')}}</button>
                    <button type="button" class="btn btn-primary" wire:click="confirmationBulkData">{{__('Check')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div wire:ignore.self class="modal fade overflow-auto" id="addBulkComformationModal" tabindex="-1" aria-hidden="true" data-backdrop="static" data-keyboard="false" aria-labelledby="addBulkComformationModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header">
                <h5 class="modal-title" id="addBulkComformationModalLabel">{{__('Double Check!')}}</h5>
                <button class="close eButt" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <h5>{{__('Is This Information Correct?')}}</h5>
                <p>{{__('Artist Name: ')}} {{ $artistNameTmp }}</p>
                <p>{{__('File Name: ')}} {{ $fileNameTmp }}</p>
                @if ($nonExistingSongs != [])
                <ul>
                    @foreach ($nonExistingSongs as $item)
                        <li>
                            <small class="text-danger">
                                <i class="fas fa-ban"></i> {{ $item }}
                            </small>
                        </li>
                    @endforeach
                </ul>
                @endif
                @if ($existingSongs != [])
                <ul>
                    @foreach ($existingSongs as $item)
                        <li>
                            <small class="text-success">
                                <i class="far fa-check-circle"></i> {{ $item }}
                            </small>
                        </li>
                    @endforeach
                </ul>
                @endif
                <br>
                <div class="timer">Elapsed time: <span id="elapsed-time-bulk">0</span> seconds</div>
                <div class="progress my-1">
                    <div class="progress-bar bg-danger progress-bar-striped progress-bar-animated uploadProgressBulk" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                @if (session()->has('message'))
                <h5 class="alert alert-info">{{ session('message') }}</h5>
                @endif
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger nButt" type="button" data-dismiss="modal">
                    {{__('No')}}
                </button>
                <button class="btn btn-primary yButt" type="button" wire:click="saveBulkSongDetails" onclick="startTimerBulk()" @if ($nonExistingSongs == []) disabled @endif>
                    {{__('Yes, Upload Now')}}
                </button>
            </div>
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

@script
<script>
        $wire.on('showConfirmationModal', () => {
            console.log('Comfirmation Modal');
            $('#addComformationModal').modal('show'); // Assuming you're using jQuery for Bootstrap modals
        });


        $wire.on('stopTimer', () => {
            clearInterval(timer);
            document.querySelector('.yButt').disabled = false;
            document.querySelector('.nButt').disabled = false;
            document.querySelector('.eButt').disabled = false;
        });


        $wire.on('stopProgress', () => {
            clearInterval(interval);
        });


        const inputElement = document.querySelector('input[type="file"]');
        const pond = FilePond.create(inputElement);

        pond.setOptions({
            server: {
                process: (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                    @this.upload('data', file, load, error, progress);
                },
                revert: (filename, load) => {
                    @this.removeUpload('data', filename, load);
                }
            }
        });

        $wire.on('filepond-reset', () => {
            pond.removeFiles(); // Clear the FilePond files
        });

        // BULK FUNCTION SCRIPT
        $wire.on('showBulkConfirmationModal', () => {
            console.log('Comfirmation Modal');
            $('#addBulkComformationModal').modal('show'); 
        });


        $wire.on('stopTimer', () => {
            clearInterval(timer);
            document.querySelector('.yButt').disabled = false;
            document.querySelector('.nButt').disabled = false;
            document.querySelector('.eButt').disabled = false;
        });


        $wire.on('stopProgress', () => {
            clearInterval(interval);
        });


        const inputBulkElement = document.querySelector('input[type="file"]');
        const pondBulk = FilePond.create(inputBulkElement);

        pondBulk.setOptions({
            server: {
                process: (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                    @this.upload('data', file, load, error, progress);
                },
                revert: (filename, load) => {
                    @this.removeUpload('data', filename, load);
                }
            }
        });

        $wire.on('filepond-reset', () => {
            pondBulk.removeFiles(); // Clear the FilePond files
        });
</script>
@endscript
<script>
    let timer;
let startTime;
let progressInterval;

function startTimer() {
    console.log('timer');
    document.querySelector('.yButt').disabled = true;
    document.querySelector('.nButt').disabled = true;
    document.querySelector('.eButt').disabled = true;

    let currentProgress = {!! $progress !!};
    const progressBar = document.querySelector('.uploadProgress');

    // Clear any existing intervals to prevent multiple timers
    clearInterval(progressInterval);
    clearInterval(timer);

    progressInterval = setInterval(function () {
        const randomIncrement = Math.floor(Math.random() * (12 - 10 + 1)) + 2;
        currentProgress += randomIncrement;

        if (currentProgress <= 100) {
            progressBar.style.width = currentProgress + '%';
            progressBar.setAttribute('aria-valuenow', currentProgress);
        } else {
            clearInterval(progressInterval);
            progressBar.style.width = '100%';
            progressBar.setAttribute('aria-valuenow', '100');
        }
    }, 1000);

    startTime = new Date();
    timer = setInterval(() => {
        const elapsedTime = Math.floor((new Date() - startTime) / 1000);
        document.getElementById('elapsed-time').innerText = elapsedTime;
    }, 1000);
}

function resetTimerAndProgress() {
    // Clear intervals
    clearInterval(timer);
    clearInterval(progressInterval);

    // Reset progress and timer elements
    const progressBar = document.querySelector('.uploadProgress');
    progressBar.style.width = '0%';
    progressBar.setAttribute('aria-valuenow', '0');
    document.getElementById('elapsed-time').innerText = '0';
}

// BULK UPLOAD TIMER
let timerBulk;
let startTimeBulk;
let progressIntervalBulk;

function startTimerBulk() {
    console.log('timerBulk');
    document.querySelector('.yButt').disabled = true;
    document.querySelector('.nButt').disabled = true;
    document.querySelector('.eButt').disabled = true;

    let currentProgress = {!! $progress !!};
    const progressBar = document.querySelector('.uploadProgressBulk');

    // Clear any existing intervals to prevent multiple timers
    clearInterval(progressIntervalBulk);
    clearInterval(timerBulk);

    progressIntervalBulk = setInterval(function () {
        const randomIncrement = Math.floor(Math.random() * (12 - 10 + 1)) + 2;
        currentProgress += randomIncrement;

        if (currentProgress <= 100) {
            progressBar.style.width = currentProgress + '%';
            progressBar.setAttribute('aria-valuenow', currentProgress);
        } else {
            clearInterval(progressIntervalBulk);
            progressBar.style.width = '100%';
            progressBar.setAttribute('aria-valuenow', '100');
        }
    }, 1000);

    startTimeBulk = new Date();
    timerBulk = setInterval(() => {
        const elapsedTime = Math.floor((new Date() - startTimeBulk) / 1000);
        document.getElementById('elapsed-time-bulk').innerText = elapsedTime;
    }, 1000);
}

function resetTimerAndProgressBulk() {
    // Clear intervals
    clearInterval(timerBulk);
    clearInterval(progressIntervalBulk);

    // Reset progress and timer elements
    const progressBar = document.querySelector('.uploadProgressBulk');
    progressBar.style.width = '0%';
    progressBar.setAttribute('aria-valuenow', '0');
    document.getElementById('elapsed-time-bulk').innerText = '0';
}

// Event listeners for dispatch calls
window.addEventListener('stopTimer', () => {
    resetTimerAndProgress();
    resetTimerAndProgressBulk();
});

</script>
{{-- <script>

    let timer;
    let startTime;
    function startTimer() {
        console.log('timer');
        document.querySelector('.yButt').disabled = true;
        document.querySelector('.nButt').disabled = true;
        document.querySelector('.eButt').disabled = true;
        let currentProgress = {!! $progress !!};
        let randomIncrement = 0;
        const progressBar = document.querySelector('.uploadProgress');
        const interval = setInterval(function () {
            randomIncrement = Math.floor(Math.random() * (12 - 10 + 1)) + 2;
            currentProgress += randomIncrement;
            if (currentProgress <= 100 || {!! $progress !!} < 100) {
                progressBar.style.width = currentProgress + '%';
                progressBar.setAttribute('aria-valuenow', currentProgress);
            } else {
                clearInterval(interval);
                progressBar.style.width = '100%';
                if(currentProgress >= 100){
                    currentProgress = 0;
                }
                progressBar.setAttribute('aria-valuenow', '0');

            }
        }, 1000);


        startTime = new Date();
        timer = setInterval(() => {
            const elapsedTime = Math.floor((new Date() - startTime) / 1000);
            document.getElementById('elapsed-time').innerText = elapsedTime;
        }, 10);
    }

    // FOR BULK PROGRESS
    let timerBulk;
    let startTimeBulk;
    function startTimerBulk() {
        console.log('timerBulk');
        document.querySelector('.yButt').disabled = true;
        document.querySelector('.nButt').disabled = true;
        document.querySelector('.eButt').disabled = true;
        let currentProgress = {!! $progress !!};
        let randomIncrement = 0;
        const progressBar = document.querySelector('.uploadProgressBulk');
        const interval = setInterval(function () {
            randomIncrement = Math.floor(Math.random() * (12 - 10 + 1)) + 2;
            currentProgress += randomIncrement;
            if (currentProgress <= 100 || {!! $progress !!} < 100) {
                progressBar.style.width = currentProgress + '%';
                progressBar.setAttribute('aria-valuenow', currentProgress);
            } else {
                clearInterval(interval);
                progressBar.style.width = '100%';
                if(currentProgress >= 100){
                    currentProgress = 0;
                }
                progressBar.setAttribute('aria-valuenow', '0');

            }
        }, 1000);


        startTimeBulk = new Date();
        timerBulk = setInterval(() => {
            const elapsedTime = Math.floor((new Date() - startTimeBulk) / 1000);
            document.getElementById('elapsed-time-bulk').innerText = elapsedTime;
        }, 10);
    }
</script> --}}