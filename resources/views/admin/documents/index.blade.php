@extends('adminlte::page')

@section('title', 'Documents')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Downloadable Documents</h1>
        <a href="{{ route('admin.documents.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Upload Document
        </a>
    </div>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <span class="text-muted">Manage PDF and document downloads for the website</span>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th style="width: 40px;"></th>
                    <th>Title</th>
                    <th>File</th>
                    <th>Category</th>
                    <th>Size</th>
                    <th>Downloads</th>
                    <th>Status</th>
                    <th style="width: 120px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($documents as $document)
                <tr>
                    <td class="text-center">
                        @if($document->file_type === 'pdf')
                            <i class="fas fa-file-pdf fa-lg text-danger"></i>
                        @elseif(in_array($document->file_type, ['doc', 'docx']))
                            <i class="fas fa-file-word fa-lg text-primary"></i>
                        @else
                            <i class="fas fa-file fa-lg text-secondary"></i>
                        @endif
                    </td>
                    <td>
                        <strong>{{ $document->title }}</strong>
                        @if($document->description)
                            <br>
                            <small class="text-muted">{{ Str::limit($document->description, 50) }}</small>
                        @endif
                    </td>
                    <td>
                        <code>{{ $document->file_name }}</code>
                    </td>
                    <td>
                        @if($document->category)
                            <span class="badge badge-info">{{ ucfirst($document->category) }}</span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>{{ $document->formatted_size }}</td>
                    <td>
                        <span class="badge badge-secondary">
                            <i class="fas fa-download mr-1"></i>{{ $document->download_count ?? 0 }}
                        </span>
                    </td>
                    <td>
                        <span class="badge badge-{{ $document->is_active ? 'success' : 'secondary' }}">
                            {{ $document->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ asset('storage/' . $document->file_path) }}" class="btn btn-sm btn-outline-primary" target="_blank" title="Download">
                            <i class="fas fa-download"></i>
                        </a>
                        <a href="{{ route('admin.documents.edit', $document) }}" class="btn btn-sm btn-info" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.documents.destroy', $document) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this document?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted">No documents found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($documents->hasPages())
    <div class="card-footer">
        {{ $documents->links('pagination::bootstrap-4') }}
    </div>
    @endif
</div>

<div class="card card-outline card-info">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-info-circle mr-2"></i>Document Info</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h6>Supported File Types:</h6>
                <span class="badge badge-danger mr-1"><i class="fas fa-file-pdf mr-1"></i>PDF</span>
                <span class="badge badge-primary mr-1"><i class="fas fa-file-word mr-1"></i>DOC</span>
                <span class="badge badge-primary mr-1"><i class="fas fa-file-word mr-1"></i>DOCX</span>
            </div>
            <div class="col-md-6">
                <h6>Common Categories:</h6>
                <span class="badge badge-info mr-1">assessment</span>
                <span class="badge badge-info mr-1">forms</span>
                <span class="badge badge-info mr-1">guides</span>
                <span class="badge badge-info mr-1">terms</span>
            </div>
        </div>
    </div>
</div>
@stop
