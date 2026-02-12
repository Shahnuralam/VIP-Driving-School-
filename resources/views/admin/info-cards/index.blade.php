@extends('adminlte::page')

@section('title', 'Info Cards')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Info Cards</h1>
        <a href="{{ route('admin.info-cards.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Info Card
        </a>
    </div>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <span class="text-muted">Manage informational cards displayed on different pages</span>
        </div>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th style="width: 50px;">Icon</th>
                    <th>Title</th>
                    <th>Page</th>
                    <th>Section</th>
                    <th>Status</th>
                    <th>Order</th>
                    <th style="width: 120px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($infoCards as $card)
                <tr>
                    <td class="text-center">
                        @if($card->icon_type === 'image' && $card->icon)
                            <img src="{{ asset('storage/' . $card->icon) }}" alt="{{ $card->title }}" style="max-height: 30px; max-width: 30px;">
                        @elseif($card->icon)
                            <i class="{{ $card->icon }} fa-lg"></i>
                        @else
                            <i class="fas fa-info-circle fa-lg text-muted"></i>
                        @endif
                    </td>
                    <td>
                        <strong>{{ $card->title }}</strong>
                        <br>
                        <small class="text-muted">{{ Str::limit(strip_tags($card->content), 50) }}</small>
                    </td>
                    <td>
                        <span class="badge badge-info">{{ ucfirst(str_replace('-', ' ', $card->page)) }}</span>
                    </td>
                    <td>
                        @if($card->section)
                            <span class="badge badge-secondary">{{ ucfirst($card->section) }}</span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge badge-{{ $card->is_active ? 'success' : 'secondary' }}">
                            {{ $card->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>{{ $card->sort_order }}</td>
                    <td>
                        <a href="{{ route('admin.info-cards.edit', $card) }}" class="btn btn-sm btn-info">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.info-cards.destroy', $card) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this info card?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">No info cards found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($infoCards->hasPages())
    <div class="card-footer">
        {{ $infoCards->links('pagination::bootstrap-4') }}
    </div>
    @endif
</div>

<div class="card card-outline card-info">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-lightbulb mr-2"></i>Available Pages</h3>
    </div>
    <div class="card-body">
        <p class="text-muted mb-2">Info cards can be assigned to the following pages:</p>
        <div class="row">
            <div class="col-md-3">
                <span class="badge badge-info">home</span> - Homepage
            </div>
            <div class="col-md-3">
                <span class="badge badge-info">lesson-packages</span> - Lesson Packages
            </div>
            <div class="col-md-3">
                <span class="badge badge-info">book-online</span> - Online Booking
            </div>
            <div class="col-md-3">
                <span class="badge badge-info">p1-assessments</span> - P1 Assessments
            </div>
        </div>
    </div>
</div>
@stop
