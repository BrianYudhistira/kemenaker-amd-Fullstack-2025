<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Treatment extends Model
{
    use HasFactory;

    protected $fillable = [
        'checkup_id',
        'treatment_type',
        'description',
        'treatment_date',
    ];

    protected $casts = [
        'treatment_date' => 'date',
    ];

    public function checkup(): BelongsTo
    {
        return $this->belongsTo(Checkup::class);
    }
}
