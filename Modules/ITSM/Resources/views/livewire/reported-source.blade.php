{{-- <div class="col-lg-8 fv-row"> --}}
    <select id="source" name="source" class="js-select2 form-control">
        <option value="">=== Select Source Report ===</option>
        @foreach ($sourceReport as $sources)
            <option value="{{ $sources }}">{{ $sources }}</option>
        @endforeach
</select>
{{-- </div> --}}

@push('scripts')
<script>
$('#source').select2({
    tags: true, // Enable tags for new values
    // maximumSelectionLength: 2
});
</script>
@endpush

