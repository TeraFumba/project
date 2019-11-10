@extends(backpack_view('blank'))

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <div class="box-title"><h3>Edit Contact</h3></div>
                </div>

                <div id="app">
                    <contact_edit  @if(isset($contact)) :contact="{{ $contact }}" @endif  @if(isset($numberTypes)) :number-types="{{ $numberTypes }}" @endif>

                    </contact_edit>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('after_scripts')
    <script src="{{ asset('js/app.js') }}"></script>
@endpush
