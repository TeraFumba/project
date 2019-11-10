@extends(backpack_view('blank'))

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <div class="box-title"><h3>Add Contact</h3></div>
                </div>

                <div id="app">
                    <contact_add   @if(isset($numberTypes)) :number-types="{{ $numberTypes }}" @endif>

                    </contact_add>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('after_scripts')
    <script src="{{ asset('js/app.js') }}"></script>
@endpush
