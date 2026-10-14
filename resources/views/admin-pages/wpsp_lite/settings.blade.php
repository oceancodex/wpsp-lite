@section('title')
    {{ wpsp_lite_trans('Settings', true) }}
@endsection

@section('content')
    <form method="POST" autocomplete="off">
        <input name="action" value="save_settings" type="hidden"/>
        @include('admin-pages.poststuff')
    </form>
@endsection

@push('scripts')
	<script src="{{ wpsp_lite_asset('widen/plugins/autonumeric/autoNumeric.min.js') }}"></script>
	<script src="{{ wpsp_lite_asset('widen/plugins/jquery-repeater/jquery.repeater.min.js') }}"></script>
@endpush