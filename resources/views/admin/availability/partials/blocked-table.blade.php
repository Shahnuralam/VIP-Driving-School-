<div class="card-body table-responsive p-0">
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th>Date</th>
                <th>Time</th>
                <th>Service</th>
                <th>Location</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($blockedSlots as $slot)
                <tr>
                    <td>{{ $slot->date->format('D, M j, Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($slot->end_time)->format('H:i') }}</td>
                    <td>{{ $slot->service ? $slot->service->name : 'All Services' }}</td>
                    <td>{{ $slot->location ? $slot->location->name : 'All Locations' }}</td>
                    <td>
                        @if($slot->is_blocked)
                            <span class="badge badge-danger">Blocked</span>
                        @else
                            <span class="badge badge-warning">Unavailable</span>
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('admin.availability.toggle-block', $slot) }}" method="POST" class="d-inline remote-submit" data-target="#blocked-dates-content">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-sm btn-success" title="Unblock">
                                <i class="fas fa-unlock"></i> Unblock
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">No blocked dates found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@if($blockedSlots instanceof \Illuminate\Pagination\LengthAwarePaginator)
    <div class="card-footer">
        {{ $blockedSlots->withQueryString()->links('pagination::bootstrap-4') }}
    </div>
@endif
