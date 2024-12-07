@extends('admins.layout')
@section('content')
    {{-- @include('admins.components.artistTable') --}}
    @livewire('admin.detail-livewire')
@endsection
@section('modalScript')
<script>
    window.addEventListener('close-modal', event => { $('#detailAddModal').modal('hide'); }) 
    window.addEventListener('close-modal-bulk', event => { $('#detailAddBulkModal').modal('hide'); }) 
    
    window.addEventListener('close-modal-confirmation', event => { $('#addComformationModal').modal('hide'); }) 
    window.addEventListener('close-modal-confirmation-bulk', event => { $('#addBulkComformationModal').modal('hide'); }) 
    // window.addEventListener('close-modal', event => { $('#detailAddModal').modal('hide'); }) 
</script>
{{-- @script
<script>       
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
</script>


@endscript --}}

@endsection
