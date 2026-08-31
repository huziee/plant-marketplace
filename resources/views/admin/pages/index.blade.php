@extends('layouts.admin')

@section('title', 'Page & Policy CMS Management - Plantaric Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800"><i class="fa-solid fa-file-contract text-success me-2"></i>Pages & Policy CMS</h1>
        <p class="text-muted small mb-0">Manage trust, legal, company policies, and custom informational pages.</p>
    </div>
    <a href="{{ route('admin.pages.create') }}" class="btn btn-success fw-bold" style="border-radius:12px;background:var(--green-900)">
        <i class="fa-solid fa-plus me-1"></i> Add Custom Page
    </a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Page Title</th>
                        <th>URL Slug</th>
                        <th>Type</th>
                        <th>Footer Nav</th>
                        <th>Status</th>
                        <th>Last Updated</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pages as $page)
                        <tr>
                            <td class="ps-4 font-weight-bold">
                                {{ $page->title }}
                                @if($page->is_system)
                                    <span class="badge bg-success-subtle text-success border border-success ms-1" style="font-size:10px">Core System Page</span>
                                @endif
                            </td>
                            <td><code>/{{ $page->slug }}</code></td>
                            <td>
                                @if($page->is_system)
                                    <span class="badge bg-primary-subtle text-primary">System Trust/Legal</span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary">Custom Page</span>
                                @endif
                            </td>
                            <td>
                                @if($page->show_in_footer)
                                    <span class="badge bg-success"><i class="fa-solid fa-check me-1"></i> Shown</span>
                                @else
                                    <span class="badge bg-light text-muted">Hidden</span>
                                @endif
                            </td>
                            <td>
                                @if($page->status === 'published')
                                    <span class="badge bg-success">Published</span>
                                @else
                                    <span class="badge bg-secondary">Draft</span>
                                @endif
                            </td>
                            <td class="small text-muted">{{ $page->updated_at->format('M d, Y H:i') }}</td>
                            <td class="text-end pe-4">
                                <a href="{{ url('/' . $page->slug) }}" target="_blank" class="btn btn-sm btn-outline-secondary me-1" title="View Public Page">
                                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                </a>
                                <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-sm btn-outline-primary me-1" title="Edit Page Content">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                @if(!$page->is_system)
                                    <form action="{{ route('admin.pages.destroy', $page) }}" method="POST" class="d-inline ajax-delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" title="Delete Page"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                @else
                                    <button class="btn btn-sm btn-outline-secondary" disabled title="Essential System Page Protected"><i class="fa-solid fa-lock"></i></button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">No CMS pages found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
