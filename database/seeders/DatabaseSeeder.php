<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Owner;
use App\Models\Pet;
use App\Models\Checkup;
use App\Models\Treatment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Users
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Create Owners
        $owner1 = Owner::create([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'phone' => '081234567890',
            'address' => 'Jl. Contoh No. 123, Jakarta',
            'phone_verified' => true,
        ]);

        $owner2 = Owner::create([
            'name' => 'Jane Smith',
            'email' => 'jane.smith@example.com',
            'phone' => '081234567891',
            'address' => 'Jl. Contoh No. 456, Bandung',
            'phone_verified' => true,
        ]);

        $owner3 = Owner::create([
            'name' => 'Bob Johnson',
            'email' => 'bob.johnson@example.com',
            'phone' => '081234567892',
            'address' => 'Jl. Contoh No. 789, Surabaya',
            'phone_verified' => true,
        ]);

        // Create Pets
        $pet1 = Pet::create([
            'code' => '1030' . str_pad($owner1->id, 4, '0', STR_PAD_LEFT) . '0001',
            'name' => 'Milo',
            'type' => 'Kucing',
            'age' => 2,
            'weight' => 4.5,
            'owner_id' => $owner1->id,
        ]);

        $pet2 = Pet::create([
            'code' => '1030' . str_pad($owner1->id, 4, '0', STR_PAD_LEFT) . '0002',
            'name' => 'Buddy',
            'type' => 'Anjing',
            'age' => 3,
            'weight' => 12.0,
            'owner_id' => $owner1->id,
        ]);

        $pet3 = Pet::create([
            'code' => '1031' . str_pad($owner2->id, 4, '0', STR_PAD_LEFT) . '0001',
            'name' => 'Whiskers',
            'type' => 'Kucing',
            'age' => 1,
            'weight' => 3.2,
            'owner_id' => $owner2->id,
        ]);

        $pet4 = Pet::create([
            'code' => '1032' . str_pad($owner3->id, 4, '0', STR_PAD_LEFT) . '0001',
            'name' => 'Max',
            'type' => 'Anjing',
            'age' => 5,
            'weight' => 25.5,
            'owner_id' => $owner3->id,
        ]);

        // Create Checkups
        $checkup1 = Checkup::create([
            'pet_id' => $pet1->id,
            'checkup_date' => now()->subDays(7),
            'notes' => 'Pemeriksaan rutin. Kondisi sehat.',
        ]);

        $checkup2 = Checkup::create([
            'pet_id' => $pet2->id,
            'checkup_date' => now()->subDays(14),
            'notes' => 'Vaksinasi rabies.',
        ]);

        $checkup3 = Checkup::create([
            'pet_id' => $pet3->id,
            'checkup_date' => now()->subDays(3),
            'notes' => 'Pemeriksaan kulit karena gatal.',
        ]);

        $checkup4 = Checkup::create([
            'pet_id' => $pet4->id,
            'checkup_date' => now()->subDays(30),
            'notes' => 'Pemeriksaan kesehatan umum.',
        ]);

        // Create Treatments
        Treatment::create([
            'checkup_id' => $checkup1->id,
            'treatment_type' => 'Vitamin',
            'description' => 'Pemberian vitamin untuk meningkatkan imunitas.',
            'treatment_date' => now()->subDays(7),
        ]);

        Treatment::create([
            'checkup_id' => $checkup2->id,
            'treatment_type' => 'Vaksinasi',
            'description' => 'Vaksin rabies dosis tahunan.',
            'treatment_date' => now()->subDays(14),
        ]);

        Treatment::create([
            'checkup_id' => $checkup3->id,
            'treatment_type' => 'Obat Kulit',
            'description' => 'Salep anti jamur untuk gatal-gatal.',
            'treatment_date' => now()->subDays(3),
        ]);

        Treatment::create([
            'checkup_id' => $checkup4->id,
            'treatment_type' => 'Pemeriksaan Darah',
            'description' => 'Tes darah lengkap untuk cek kesehatan.',
            'treatment_date' => now()->subDays(30),
        ]);
    }
}
