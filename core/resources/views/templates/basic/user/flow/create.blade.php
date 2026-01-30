@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="dashboard-container">
        <div id="flow-builder"></div>
    </div>
@endsection

@push('script')
    @viteReactRefresh
    @vite(['resources/js/flow_builder/app.jsx'])
@endpush

@push('style')
    <style>
        .tooltip {
            z-index: 11 !important;
        }
    </style>
@endpush
