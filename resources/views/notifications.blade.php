@if($flash = session('error'))
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> {{ $flash }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
</div>
@endif

@if($flash = session('success'))
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {{ $flash }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
</div>
@endif

@if($flash = session('info'))
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <strong>Information!</strong> {{ $flash }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
</div>
@endif

@if($flash = session('warning'))
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Warning!</strong> {{ $flash }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
</div>
@endif

{{-- display validation errors.  --}}
@if ($errors->count() > 0)
    @foreach ($errors->all() as $error)
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> {{ $error }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </div>
    @endforeach
@endif