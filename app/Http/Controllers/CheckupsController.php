<?php

namespace App\Http\Controllers;

use App\Models\Checkup;
use App\Models\Pet;
use App\Models\Treatment;

class CheckupsController extends Controller
{
    public function index()
    {
        $checkups = Checkup::with(['pet', 'treatment'])->get();
        $pets = Pet::all();
        return view('dashboard.checkups.checkups', compact('checkups', 'pets'));
    }

    public function store()
    {
        $checkup = Checkup::create([
            'pet_id' => request('pet_id'),
            'checkup_date' => request('checkup_date'),
            'notes' => request('notes'),
        ]);

        if (request('treatment_type')) {
            Treatment::create([
                'checkup_id' => $checkup->id,
                'treatment_type' => request('treatment_type'),
                'description' => request('treatment_description'),
                'treatment_date' => request('treatment_date') ?? request('checkup_date'),
            ]);
        }

        return redirect()->route('checkups.index')->with('success', 'Checkup added successfully');
    }

    public function update($id)
    {
        $checkup = Checkup::findOrFail($id);

        $checkup->update([
            'pet_id' => request('pet_id'),
            'checkup_date' => request('checkup_date'),
            'notes' => request('notes'),
        ]);

        return redirect()->route('checkups.index')->with('success', 'Checkup updated successfully');
    }

    public function destroy($id)
    {
        $checkup = Checkup::findOrFail($id);
        $checkup->delete(); 

        return redirect()->route('checkups.index')->with('success', 'Checkup deleted successfully');
    }
}