<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Patient extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'no_rm',
        'nik',
        'name',
        'date_of_birth',
        'gender',
        'address',
        'phone',
        'blood_type',
        'emergency_contact_name',
        'emergency_contact_phone',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    /**
     * Generate unique No RM (Medical Record Number)
     * Format: RM-YYYYMMDD-XXXX
     */
    public static function generateNoRM(): string
    {
        $date = date('Ymd');
        $prefix = "RM-{$date}-";
        
        // Get last patient with same date prefix
        $lastPatient = self::where('no_rm', 'like', $prefix . '%')
            ->orderBy('no_rm', 'desc')
            ->first();

        if ($lastPatient) {
            // Extract sequence number and increment
            $lastSequence = intval(substr($lastPatient->no_rm, -4));
            $newSequence = $lastSequence + 1;
        } else {
            $newSequence = 1;
        }

        return $prefix . str_pad($newSequence, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Get patient age
     */
    public function getAgeAttribute(): int
    {
        return $this->date_of_birth->age;
    }

    /**
     * Relationship: Patient has many registrations
     */
    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }
}
