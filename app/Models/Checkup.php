<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Checkup extends Model
{
    use HasFactory;

    protected $fillable = [
        'pet_id',
        'checkup_date',
        'notes',
    ];

    protected $casts = [
        'checkup_date' => 'date',
    ];

    /**
     * Relasi One-to-One: Checkup dimiliki oleh satu pet
     */
    public function pet(): BelongsTo
    {
        return $this->belongsTo(Pet::class);
    }

    /**
     * Relasi One-to-One: Satu checkup memiliki satu treatment
     */
    public function treatment(): HasOne
    {
        return $this->hasOne(Treatment::class);
    }
}
