@extends('customer.layouts.app')

@section('title', 'My Reviews')

@section('content')
<h4 class="mb-4"><i class="fas fa-star me-2"></i>My Reviews</h4>

<div class="card">
    <div class="card-body">
        @forelse($reviews as $r)
        <div class="border-bottom pb-3 mb-3">
            <div class="d-flex justify-content-between">
                <div class="text-warning">
                    @for($i = 1; $i <= 5; $i++)
                    <i class="fas fa-star{{ $i <= $r->overall_rating ? '' : '-o' }}"></i>
                    @endfor
                    <span class="text-dark ms-2">{{ $r->overall_rating }}/5</span>
                </div>
                <span class="badge bg-{{ $r->getStatusBadgeClass() }}">{{ ucfirst($r->status) }}</span>
            </div>
            @if($r->title)<h6 class="mt-2">{{ $r->title }}</h6>@endif
            <p class="mb-1">{{ $r->content }}</p>
            <small class="text-muted">{{ $r->booking->service->name ?? $r->booking->package->name ?? 'Lesson' }} — {{ $r->created_at->format('M j, Y') }}</small>
        </div>
        @empty
        <p class="text-muted mb-0">You haven't submitted any reviews yet. After completing a lesson, you can leave a review from your booking details.</p>
        @endforelse
    </div>
    @if($reviews->hasPages())
    <div class="card-footer">{{ $reviews->links('pagination::bootstrap-4') }}</div>
    @endif
</div>
@endsection
