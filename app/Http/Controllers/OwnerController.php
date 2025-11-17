<?php

namespace App\Http\Controllers;

use App\Models\Owner;

class OwnerController extends Controller
{
    //
    public function index()
    {
        $owners = Owner::all();
        return view('dashboard.owner.owner', compact('owners'));
    }
    public function store()
    {
        $name = request('owner_name');
        $email = request('owner_email');
        $phone = request('owner_phone');
        $address = request('owner_address');
        $phone_verified = request('phone_verified', true);

        Owner::create([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'address' => $address,
            'phone_verified' => $phone_verified,
        ]);

        return redirect()->route('owners.index');
    }

    public function update($id)
    {
        $owner = Owner::findOrFail($id);

        $owner->update([
            'name' => request('owner_name'),
            'email' => request('owner_email'),
            'phone' => request('owner_phone'),
            'phone_verified' => request('phone_verified'),
            'address' => request('owner_address'),
        ]);

        return redirect()->route('owners.index')->with('success', 'Owner updated successfully');
    }

    public function destroy($id)
    {
        $owner = Owner::findOrFail($id);
        $owner->delete();

        return redirect()->route('owners.index')->with('success', 'Owner deleted successfully');
    }
}