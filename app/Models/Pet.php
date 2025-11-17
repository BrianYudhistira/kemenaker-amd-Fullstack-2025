<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pet extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'type',
        'age',
        'weight',
        'owner_id',
    ];

    protected $casts = [
        'birthdate' => 'date',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class);
    }

    public function checkup(): HasOne
    {
        return $this->hasOne(Checkup::class);
    }
}
