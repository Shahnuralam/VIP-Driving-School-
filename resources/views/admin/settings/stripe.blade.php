@extends('adminlte::page')

@section('title', 'Stripe Settings')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fab fa-stripe mr-2"></i>Stripe Payment Settings</h1>
        <a href="{{ route('admin.settings.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-1"></i>Back to Settings
        </a>
    </div>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {{ session('error') }}
        </div>
    @endif

    <div class="alert alert-info">
        <i class="fas fa-info-circle mr-2"></i>
        <strong>Important:</strong> Stripe API keys are stored securely in your environment file (.env). Changes will take effect immediately.
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">API Keys</h3>
        </div>
        <form action="{{ route('admin.settings.stripe.update') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label>Publishable Key</label>
                    <input type="text" name="stripe_key" class="form-control" value="{{ $stripeKey ?? '' }}" placeholder="pk_test_...">
                    <small class="form-text text-muted">Your Stripe publishable key (starts with pk_test_ or pk_live_)</small>
                </div>

                <div class="form-group">
                    <label>Secret Key</label>
                    <div class="input-group">
                        <input type="password" name="stripe_secret" class="form-control" id="stripeSecret" value="{{ $stripeSecret ?? '' }}" placeholder="sk_test_...">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-outline-secondary" onclick="togglePassword()">
                                <i class="fas fa-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                    </div>
                    <small class="form-text text-muted">Your Stripe secret key (starts with sk_test_ or sk_live_)</small>
                </div>

                <div class="form-group">
                    <label>Webhook Secret (Optional)</label>
                    <input type="text" name="stripe_webhook_secret" class="form-control" value="{{ $webhookSecret ?? '' }}" placeholder="whsec_...">
                    <small class="form-text text-muted">Used for verifying webhook signatures</small>
                </div>

                <div class="alert alert-warning mt-4">
                    <h5><i class="fas fa-exclamation-triangle mr-2"></i>Test vs Live Mode</h5>
                    <p class="mb-0">
                        <strong>Test keys</strong> (pk_test_, sk_test_) are for development and testing.<br>
                        <strong>Live keys</strong> (pk_live_, sk_live_) are for processing real payments.
                    </p>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-1"></i>Save Stripe Settings
                </button>
            </div>
        </form>
    </div>

    <!-- Testing Section -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-vial mr-2"></i>Test Cards</h3>
        </div>
        <div class="card-body">
            <p>Use these test card numbers in test mode:</p>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Card Type</th>
                        <th>Number</th>
                        <th>Result</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Visa</td>
                        <td><code>4242 4242 4242 4242</code></td>
                        <td><span class="badge badge-success">Success</span></td>
                    </tr>
                    <tr>
                        <td>Visa (Declined)</td>
                        <td><code>4000 0000 0000 0002</code></td>
                        <td><span class="badge badge-danger">Declined</span></td>
                    </tr>
                    <tr>
                        <td>Mastercard</td>
                        <td><code>5555 5555 5555 4444</code></td>
                        <td><span class="badge badge-success">Success</span></td>
                    </tr>
                </tbody>
            </table>
            <small class="text-muted">Use any future expiry date and any 3-digit CVC</small>
        </div>
    </div>
@stop

@section('js')
<script>
function togglePassword() {
    const input = document.getElementById('stripeSecret');
    const icon = document.getElementById('toggleIcon');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>
@stop
