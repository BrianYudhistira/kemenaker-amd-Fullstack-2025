@extends('layouts.dashboard')

@section('title', 'Owners')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h1 class="h4 mb-0">Owners</h1>
        <button class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#addOwnerModal">
            + Add New Owner
        </button>
    </div>
    
    @if ($owners->isEmpty())
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <p class="text-muted mb-0">No owners found.</p>
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
                                <th class="py-3">Owner Name</th>
                                <th class="py-3">Email</th>
                                <th class="py-3">Phone</th>
                                <th class="py-3">Phone Verified</th>
                                <th class="py-3">Address</th>
                                <th class="py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($owners as $index => $owner)
                                <tr>
                                    <td class="px-4">{{ $index + 1 }}</td>
                                    <td class="fw-semibold">{{ $owner->name }}</td>
                                    <td>{{ $owner->email }}</td>
                                    <td>{{ $owner->phone ?? '-' }}</td>
                                    <td>{{ $owner->phone_verified ? 'Yes' : 'No' }}</td>
                                    <td>{{ $owner->address ?? '-' }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editOwnerModal{{ $owner->id }}">Edit</button>
                                        <form action="/owner/delete/{{ $owner->id }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this owner?');">
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
    
    <!-- Modal Add Owner -->
    <div class="modal fade" id="addOwnerModal" tabindex="-1" aria-labelledby="addOwnerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="addOwnerModalLabel">Add New Owner</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/owner/add" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="ownerInput" class="form-label">Owner Name</label>
                            <input type="text" class="form-control" id="ownerInput" name="owner_name" placeholder="Enter owner's name" required>
                        </div>
                        <div class="mb-3">
                            <label for="ownerEmailInput" class="form-label">Email</label>
                            <input type="text" class="form-control" id="ownerEmailInput" name="owner_email" placeholder="Enter owner's email" required>
                        </div>
                        <div class="mb-3">
                            <label for="ownerPhoneInput" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="ownerPhoneInput" name="owner_phone" placeholder="Enter owner's phone number">
                        </div>
                        <div class="mb-3">
                            <label for="ownerAddressInput" class="form-label">Address</label>
                            <textarea class="form-control" rows="3" id="ownerAddressInput" name="owner_address" placeholder="Enter owner's address"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="phoneVerifiedSelect" class="form-label">Phone Verified</label>
                            <select class="form-select" id="phoneVerifiedSelect" name="phone_verified" required>
                                <option value="1" selected>Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-dark">Add Owner</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Owner -->
    @foreach ($owners as $owner)
    <div class="modal fade" id="editOwnerModal{{ $owner->id }}" tabindex="-1" aria-labelledby="editOwnerModalLabel{{ $owner->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="editOwnerModalLabel{{ $owner->id }}">Edit Owner</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/owner/edit/{{ $owner->id }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editOwnerName{{ $owner->id }}" class="form-label">Owner Name</label>
                            <input type="text" class="form-control" id="editOwnerName{{ $owner->id }}" name="owner_name" value="{{ $owner->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="editOwnerEmail{{ $owner->id }}" class="form-label">Email</label>
                            <input type="email" class="form-control" id="editOwnerEmail{{ $owner->id }}" name="owner_email" value="{{ $owner->email }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="editOwnerPhone{{ $owner->id }}" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="editOwnerPhone{{ $owner->id }}" name="owner_phone" value="{{ $owner->phone }}">
                        </div>
                        <div class="mb-3">
                            <label for="phoneVerifiedSelect" class="form-label">Phone Verified</label>
                            <select class="form-select" id="phoneVerifiedSelect" name="phone_verified" required>
                                <option value="1" {{ $owner->phone_verified ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ !$owner->phone_verified ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editOwnerAddress{{ $owner->id }}" class="form-label">Address</label>
                            <textarea class="form-control" rows="3" id="editOwnerAddress{{ $owner->id }}" name="owner_address">{{ $owner->address }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-dark">Update Owner</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
@endsection