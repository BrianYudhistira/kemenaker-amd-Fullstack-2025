@extends('layouts.dashboard')

@section('title', 'Pets')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h1 class="h4 mb-0">Pets</h1>
        <button class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#addPetModal">
            + Add New Pet
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

    @if ($pets->isEmpty())
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <p class="text-muted mb-0">No pets found.</p>
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
                                <th class="py-3">Pet Code</th>
                                <th class="py-3">Pet Name</th>
                                <th class="py-3">Type</th>
                                <th class="py-3">Weight</th>
                                <th class="py-3">Age</th>
                                <th class="py-3">Owner</th>
                                <th class="py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pets as $index => $pet)
                                <tr>
                                    <td class="px-4">{{ $index + 1 }}</td>
                                    <td class="fw-semibold">{{ $pet->code }}</td>
                                    <td class="fw-semibold">{{ $pet->name }}</td>
                                    <td>{{ $pet->type }}</td>
                                    <td>{{ $pet->weight }} Kg</td>
                                    <td>{{ $pet->age }} Years</td>
                                    <td>{{ $pet->owner->name ?? '-' }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editPetModal{{ $pet->id }}">Edit</button>
                                        <form action="/pets/delete/{{ $pet->id }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this pet?');">
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
    
    <!-- Modal Add Pet -->
    <div class="modal fade" id="addPetModal" tabindex="-1" aria-labelledby="addPetModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="addPetModalLabel">Add New Pet</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/pets/add" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="ownerSelect" class="form-label">Select Owner</label>
                            <select class="form-select" id="ownerSelect" name="owner_id" required>
                                <option value="" selected disabled>Choose an owner...</option>
                                @if($owners->isEmpty())
                                    <option disabled>No owners available</option>
                                @else
                                    @foreach($owners as $owner)
                                        <option value="{{ $owner->id }}">{{ $owner->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="petInput" class="form-label">Pet Information</label>
                            <textarea class="form-control" id="petInput" name="pet_input" rows="3" placeholder="Format: NAMA_HEWAN JENIS USIA BERAT&#10;Contoh: Milo Kucing 2Th 4.5kg" required></textarea>
                            <small class="text-muted">Format: NAMA_HEWAN JENIS USIA BERAT (dipisah spasi)</small>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-dark">Add Pet</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Pet -->
    @foreach ($pets as $pet)
    <div class="modal fade" id="editPetModal{{ $pet->id }}" tabindex="-1" aria-labelledby="editPetModalLabel{{ $pet->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="editPetModalLabel{{ $pet->id }}">Edit Pet</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/pets/edit/{{ $pet->id }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editOwnerSelect{{ $pet->id }}" class="form-label">Select Owner</label>
                            <select class="form-select" id="editOwnerSelect{{ $pet->id }}" name="owner_id" required>
                                @foreach($owners as $owner)
                                    <option value="{{ $owner->id }}" {{ $pet->owner_id == $owner->id ? 'selected' : '' }}>{{ $owner->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editPetName{{ $pet->id }}" class="form-label">Pet Name</label>
                            <input type="text" class="form-control" id="editPetName{{ $pet->id }}" name="name" value="{{ $pet->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="editPetType{{ $pet->id }}" class="form-label">Type</label>
                            <input type="text" class="form-control" id="editPetType{{ $pet->id }}" name="type" value="{{ $pet->type }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="editPetAge{{ $pet->id }}" class="form-label">Age</label>
                            <input type="number" class="form-control" id="editPetAge{{ $pet->id }}" name="age" value="{{ $pet->age }}">
                        </div>
                        <div class="mb-3">
                            <label for="editPetWeight{{ $pet->id }}" class="form-label">Weight (kg)</label>
                            <input type="number" step="0.1" class="form-control" id="editPetWeight{{ $pet->id }}" name="weight" value="{{ $pet->weight }}">
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-dark">Update Pet</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
@endsection