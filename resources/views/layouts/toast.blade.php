<div id="toast" class="toast" role="alert" aria-live="assertive" aria-atomic="true"
data-delay="5000">
{{--    data-autohide="false"--}}
    <div class="toast-header">
        <strong class="mr-auto">{{ucfirst(config('app.name'))}}</strong>
        <!--    <small class="text-muted">11 mins ago</small>-->
        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="toast-body"></div>
</div>
