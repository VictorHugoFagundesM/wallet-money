@if ($errors->any())
    <div class="alert alert-danger fixed top-[50px] left-1/2 -translate-x-1/2 bg-red-200 border border-gray-400/40 p-5 w-[90%]">

        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif
