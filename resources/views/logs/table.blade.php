@push('styles')
    @include('layouts.datatables_css')

<style>
.wrap {
    word-wrap: break-word;
}
</style>
@endpush

<div class="card-body px-4">
    {!! $dataTable->table(['width' => '100%', 'class' => 'table table-striped table-bordered']) !!}
</div>

@push('scripts')
    @include('layouts.datatables_js')
    {!! $dataTable->scripts() !!}
@endpush
