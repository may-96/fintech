@if (session('success'))
    @php
        $icon = "<i class='uil uil-check-circle text-success fs-22'></i>";
        $message = nl2br(session('success'));
        $class = 'alert-success';
    @endphp
@elseif (session('verified'))
    @php
        $icon = "<i class='uil uil-check-circle text-success fs-22'></i>";
        $message = 'Your email verified successfully.';
        $class = 'alert-success';
    @endphp
@elseif(session('warning'))
    @php
        $icon = "<i class='uil uil-exclamation-triangle text-warning fs-22'></i>";
        $message = nl2br(session('warning'));
        $class = 'alert-warning';
    @endphp
@elseif(session('danger'))
    @php
        $icon = "<i class='uil uil-times-circle text-danger fs-22'></i>";
        $message = nl2br(session('danger'));
        $class = 'alert-danger';
    @endphp
@elseif(session('info'))
    @php
        $icon = "<i class='uil uil-info-circle text-info fs-22'></i>";
        $message = nl2br(session('info'));
        $class = 'alert-info';
    @endphp
@elseif($errors->any())
    @php
        $icon = "<i class='uil uil-times-circle text-danger fs-22'></i>";
        $message = nl2br(implode('', $errors->all(':message' . "\n")));
        $class = 'alert-danger';
    @endphp
@endif

@if (isset($message) && trim($message) != '' && $message != null)
    <div class="toast toast-container position-absolute end-0 p-3" style="top: 65px;" role="alert" data-bs-autohide="true" data-bs-delay="15000" aria-live="assertive" aria-atomic="true">
        <div class="align-items-center p-2 border rounded {{ $class }}">
            <div class="d-flex toast-body align-items-center">
                {!! $icon !!} <span class="ms-1">{!! $message !!}</span>
                <button type="button" class="btn-sm btn-close mx-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
@endif
