@if (!auth()->user()->hasVerifiedEmail())
    <div class="alert alert-danger">
        Please verify your email to access full features.
        <a href="{{ route('verification.notice') }}" class="btn btn-primary">Verify Now</a>
    </div>
@endif
