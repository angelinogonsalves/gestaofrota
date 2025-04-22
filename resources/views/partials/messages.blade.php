@if (Session::has('success'))
    <div class="alert alert-success">
        {{ Session::get('success') }}
        @php
            Session::forget('success');
        @endphp
    </div>
@endif

@if ($errors)
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger">
            {{ $error }}</div>
    @endforeach
@endif