@if (session('logout'))
    <div class="row justify-content-center mt-3">
        <div class="alert alert-success text-center alert-dismissible fade show" role="alert">
            <strong>{{ session('logout') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
@endif