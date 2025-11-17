@extends('layouts.dashboard')

@section('title', 'Checkups')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-4">
            <h1 class="h4 mb-0">Pets</h1>
            <button class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#addCheckupModal">
                + Add New Checkups
            </button>
        </div>

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($checkups->isEmpty())
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-5">
                    <p class="text-muted mb-0">No checkups found.</p>
                </div>
            </div>
        @else
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="px-4 py-3">#</th>
                                    <th class="py-3">Pet Name</th>
                                    <th class="py-3">Checkup Date</th>
                                    <th class="py-3">Notes</th>
                                    <th class="py-3">Treatment</th>
                                    <th class="py-3">Treatment Type</th>
                                    <th class="py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($checkups as $index => $checkup)
                                    <tr>
                                        <td class="px-4">{{ $index + 1 }}</td>
                                        <td class="fw-semibold">{{ $checkup->pet->name ?? '-' }}</td>
                                        <td>{{ $checkup->checkup_date->format('d M Y') }}</td>
                                        <td>{{ $checkup->notes ?? '-' }}</td>
                                        <td>{{ $checkup->treatment ? 'Yes' : 'No' }}</td>
                                        <td>{{ $checkup->treatment->treatment_type ?? '-' }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#viewCheckupModal{{ $checkup->id }}">View</button>
                                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editCheckupModal{{ $checkup->id }}">Edit</button>
                                            <form action="/checkups/delete/{{ $checkup->id }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this checkup?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        <!-- Modal Add Checkup -->
        <div class="modal fade" id="addCheckupModal" tabindex="-1" aria-labelledby="addCheckupModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <h5 class="modal-title" id="addCheckupModalLabel">Add New Checkup</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="/checkups/add" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="petSelect" class="form-label">Select Pet</label>
                                <select class="form-select" id="petSelect" name="pet_id" required>
                                    <option value="" selected disabled>Choose a pet...</option>
                                    @if($pets->isEmpty())
                                        <option disabled>No pets available</option>
                                    @else
                                        @foreach($pets as $pet)
                                            <option value="{{ $pet->id }}">{{ $pet->name }} ({{ $pet->type }})</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="checkupDate" class="form-label">Checkup Date</label>
                                <input type="date" class="form-control" id="checkupDate" name="checkup_date" required>
                            </div>
                            <div class="mb-3">
                                <label for="checkupNotes" class="form-label">Notes</label>
                                <textarea class="form-control" id="checkupNotes" name="notes" rows="3" placeholder="Enter checkup notes..."></textarea>
                            </div>
                            <hr>
                            <h6 class="mb-3">Treatment (Optional)</h6>
                            <div class="mb-3">
                                <label for="treatmentType" class="form-label">Treatment Type</label>
                                <input type="text" class="form-control" id="treatmentType" name="treatment_type" placeholder="e.g., Vaccination, Medicine">
                            </div>
                            <div class="mb-3">
                                <label for="treatmentDescription" class="form-label">Treatment Description</label>
                                <textarea class="form-control" id="treatmentDescription" name="treatment_description" rows="2" placeholder="Enter treatment details..."></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="treatmentDate" class="form-label">Treatment Date</label>
                                <input type="date" class="form-control" id="treatmentDate" name="treatment_date">
                            </div>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-dark">Add Checkup</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal View Checkup Details -->
        @foreach ($checkups as $checkup)
        <div class="modal fade" id="viewCheckupModal{{ $checkup->id }}" tabindex="-1" aria-labelledby="viewCheckupModalLabel{{ $checkup->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <h5 class="modal-title" id="viewCheckupModalLabel{{ $checkup->id }}">Checkup Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <h6 class="text-muted mb-2">Pet Information</h6>
                                <p class="mb-1"><strong>Pet Name:</strong> {{ $checkup->pet->name ?? '-' }}</p>
                                <p class="mb-1"><strong>Pet Type:</strong> {{ $checkup->pet->type ?? '-' }}</p>
                                <p class="mb-1"><strong>Pet Code:</strong> <code>{{ $checkup->pet->code ?? '-' }}</code></p>
                                <p class="mb-1"><strong>Owner:</strong> {{ $checkup->pet->owner->name ?? '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-muted mb-2">Checkup Information</h6>
                                <p class="mb-1"><strong>Checkup Date:</strong> {{ $checkup->checkup_date->format('d M Y') }}</p>
                                <p class="mb-1"><strong>Created:</strong> {{ $checkup->created_at->format('d M Y H:i') }}</p>
                                <p class="mb-1"><strong>Notes:</strong></p>
                                <p class="bg-light p-2 rounded">{{ $checkup->notes ?? 'No notes' }}</p>
                            </div>
                        </div>
                        <hr>
                        <h6 class="text-muted mb-3">Treatment Information</h6>
                        @if($checkup->treatment)
                            <div class="card border">
                                <div class="card-body">
                                    <p class="mb-2"><strong>Treatment Type:</strong> {{ $checkup->treatment->treatment_type }}</p>
                                    <p class="mb-2"><strong>Treatment Date:</strong> {{ $checkup->treatment->treatment_date ? $checkup->treatment->treatment_date->format('d M Y') : '-' }}</p>
                                    <p class="mb-2"><strong>Description:</strong></p>
                                    <p class="bg-light p-2 rounded mb-0">{{ $checkup->treatment->description ?? 'No description' }}</p>
                                </div>
                            </div>
                        @else
                            <p class="text-muted">No treatment recorded for this checkup.</p>
                        @endif
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        <!-- Modal Add Checkup -->
        @foreach ($checkups as $checkup)
        <div class="modal fade" id="editCheckupModal{{ $checkup->id }}" tabindex="-1" aria-labelledby="editCheckupModalLabel{{ $checkup->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <h5 class="modal-title" id="editCheckupModalLabel{{ $checkup->id }}">Edit Checkup</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="/checkups/edit/{{ $checkup->id }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="editPetSelect{{ $checkup->id }}" class="form-label">Select Pet</label>
                                <select class="form-select" id="editPetSelect{{ $checkup->id }}" name="pet_id" required>
                                    @foreach($pets as $pet)
                                        <option value="{{ $pet->id }}" {{ $checkup->pet_id == $pet->id ? 'selected' : '' }}>{{ $pet->name }} ({{ $pet->type }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="editCheckupDate{{ $checkup->id }}" class="form-label">Checkup Date</label>
                                <input type="date" class="form-control" id="editCheckupDate{{ $checkup->id }}" name="checkup_date" value="{{ $checkup->checkup_date->format('Y-m-d') }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="editCheckupNotes{{ $checkup->id }}" class="form-label">Notes</label>
                                <textarea class="form-control" id="editCheckupNotes{{ $checkup->id }}" name="notes" rows="3">{{ $checkup->notes }}</textarea>
                            </div>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-dark">Update Checkup</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
@endsection