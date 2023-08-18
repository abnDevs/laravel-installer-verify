@extends('installer::layouts.app', [
    'title' => 'Finish',
    'withoutSteps' => true,
])

@section('content')
    <h1>Congratulations on Your Installation!</h1>
    <p>We are thrilled to hear that your installation has been successfully completed! It's an impressive accomplishment, and we're sure it will serve you well.</p>
    <p>Best wishes,</p>
    <p>The {{ config('installer.company.name') }} Team</p>

    <div class="button-group">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6">
                <a href="{{ route('login') }}" class="btn btn-primary w-100">
                    Login
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
@endsection
