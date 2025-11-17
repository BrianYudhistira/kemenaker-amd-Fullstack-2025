<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\Owner;

class PetsController extends Controller
{
    //
    public function index()
    {
        $pets = Pet::all();
        $owners = Owner::where('phone_verified', true)->get();
        return view('dashboard.pets.pets', compact('pets', 'owners'));
    }

    public function store()
    {
        $inputpets = request('pet_input');
        $lines = explode("\n", trim($inputpets));
        $ownerId = request('owner_id');
        
        $owner = Owner::find($ownerId);

        if (!$owner) {
            return redirect()->back()->with('error', 'Owner not found. Please select a valid owner.');
        }
        elseif (!$owner->phone_verified) {
            return redirect()->back()->with('error', 'Owner phone number is not verified. Cannot add pets for this owner.');
        }

        foreach ($lines as $line) {
            $line = preg_replace('/\s+/', ' ', trim($line));
            $parts = explode(' ', $line);
            
            if (count($parts) >= 4) {
                $name = strtoupper($parts[0]);
                $type = strtoupper($parts[1]);
                
                $existingPet = Pet::where('owner_id', $owner->id)
                    ->where('name', $name)
                    ->where('type', $type)
                    ->first();
                
                if ($existingPet) {
                    return redirect()->back()->with('error', "Hewan dengan nama '{$name}' dan jenis '{$type}' sudah terdaftar untuk owner ini.");
                }
                
                $ageRaw = $parts[2];
                $weight = $parts[3];
                $age = preg_replace('/[^0-9]/', '', $ageRaw);
                
                $weight = preg_replace('/[^0-9.,]/', '', $weight);
                $weight = str_replace(',', '.', $weight);

                $hhmm = now()->format('Hi');
                
                $xxxx = str_pad($owner->id, 4, '0', STR_PAD_LEFT);
                
                $petCount = Pet::where('owner_id', $owner->id)->count() + 1;
                $yyyy = str_pad($petCount, 4, '0', STR_PAD_LEFT);
                
                $code = $hhmm . $xxxx . $yyyy;
                
                Pet::create([
                    'code' => $code,
                    'name' => $name,
                    'type' => $type,
                    'age' => $age,
                    'weight' => $weight,
                    'owner_id' => $owner->id,
                ]);
            }
        }

        return redirect()->route('pets.index')->with('success', 'Pet added successfully');
    }

    public function update($id)
    {
        $pet = Pet::findOrFail($id);

        // Keep the existing code, only update other fields
        $pet->update([
            'name' => request('name'),
            'type' => request('type'),
            'age' => request('age'),
            'weight' => request('weight'),
            'owner_id' => request('owner_id'),
        ]);

        return redirect()->route('pets.index')->with('success', 'Pet updated successfully');
    }

    public function destroy($id)
    {
        $pet = Pet::findOrFail($id);
        $pet->delete();

        return redirect()->route('pets.index')->with('success', 'Pet deleted successfully');
    }
}