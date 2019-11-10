@extends(backpack_view('blank'))

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <div class="box-title"><h3>Manage Contacts</h3></div>
                </div>
                <div id="app">
                    <contacts></contacts>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('after_scripts')
    <script src="{{ asset('js/app.js') }}"></script>
@endpush
