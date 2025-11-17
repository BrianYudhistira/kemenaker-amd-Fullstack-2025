@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h1 class="h4 mb-0">Dashboard Overview</h1>
        <span class="badge bg-dark">{{ now()->format('d M Y, H:i') }}</span>
    </div>
    <div class="row g-3">
        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="card-title mb-2 text-muted">Total Owners</h6>
                    <p class="display-6 fw-semibold mb-0">{{ $totalOwners }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="card-title mb-2 text-muted">Total Pets</h6>
                    <p class="display-6 fw-semibold mb-0">{{ $totalPets }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="card-title mb-2 text-muted">Checkups</h6>
                    <p class="display-6 fw-semibold mb-0">{{ $totalCheckups }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="card-title mb-2 text-muted">Treatments</h6>
                    <p class="display-6 fw-semibold mb-0">{{ $totalTreatments }}</p>
                </div>
            </div>
        </div>
    </div>
    <hr class="my-4" />

    <div class="card border-0 shadow-sm mt-4">
        <div class="card-header bg-white border-bottom">
            <h6 class="mb-0">Aktivitas Terbaru</h6>
        </div>
        <div class="card-body">
            @if($recentActivities->isEmpty())
                <div class="text-center py-3">
                    <p class="text-muted mb-0">Belum ada aktivitas.</p>
                </div>
            @else
                <div class="list-group list-group-flush">
                    @foreach($recentActivities as $activity)
                        <div class="list-group-item border-0 px-0">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="d-flex gap-3">
                                    <span style="font-size: 1.5rem;">{{ $activity['icon'] }}</span>
                                    <div>
                                        <p class="mb-1">{{ $activity['message'] }}</p>
                                        <small class="text-muted">{{ $activity['time']->diffForHumans() }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection