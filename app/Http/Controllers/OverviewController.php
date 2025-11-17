<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use App\Models\Pet;
use App\Models\Checkup;
use App\Models\Treatment;

class OverviewController extends Controller
{
    public function index()
    {
        $totalOwners = Owner::count();
        $totalPets = Pet::count();
        $totalCheckups = Checkup::count();
        $totalTreatments = Treatment::count();
        
        $recentPets = Pet::with('owner')->latest()->take(5)->get();
        
        $recentActivities = collect();
        
        $recentOwners = Owner::latest()->take(5)->get()->map(function($owner) {
            return [
                'type' => 'owner',
                'icon' => '👤',
                'message' => "Owner baru: {$owner->name}",
                'time' => $owner->created_at,
            ];
        });
        
        $recentPetsActivity = Pet::with('owner')->latest()->take(5)->get()->map(function($pet) {
            return [
                'type' => 'pet',
                'icon' => '🐾',
                'message' => "Hewan baru: {$pet->name} ({$pet->type}) - Owner: {$pet->owner->name}",
                'time' => $pet->created_at,
            ];
        });
        
        $recentCheckups = Checkup::with('pet')->latest()->take(5)->get()->map(function($checkup) {
            return [
                'type' => 'checkup',
                'icon' => '🩺',
                'message' => "Checkup: {$checkup->pet->name} - {$checkup->checkup_date->format('d M Y')}",
                'time' => $checkup->created_at,
            ];
        });
        
        $recentTreatmentsActivity = Treatment::with('checkup.pet')->latest()->take(5)->get()->map(function($treatment) {
            return [
                'type' => 'treatment',
                'icon' => '💊',
                'message' => "Treatment: {$treatment->checkup->pet->name} - {$treatment->treatment_type}",
                'time' => $treatment->created_at,
            ];
        });
        
        $recentActivities = $recentOwners
            ->merge($recentPetsActivity)
            ->merge($recentCheckups)
            ->merge($recentTreatmentsActivity)
            ->sortByDesc('time')
            ->take(5);
        
        return view('dashboard.overview.overview', compact(
            'totalOwners',
            'totalPets',
            'totalCheckups',
            'totalTreatments',
            'recentPets',
            'recentActivities'
        ));
    }
}