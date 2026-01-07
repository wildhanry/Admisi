<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Registration extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'registration_number',
        'queue_number',
        'patient_id',
        'doctor_id',
        'polyclinic_id',
        'registration_type',
        'payment_method',
        'insurance_number',
        'registration_date',
        'registration_time',
        'status',
        'complaint',
        'notes',
        'registered_by',
    ];

    protected $casts = [
        'registration_date' => 'date',
        'registration_time' => 'datetime:H:i',
    ];

    /**
     * Generate unique Registration Number
     * Format: REG/TYPE/YYYYMMDD/XXXX
     * Example: REG/RJ/20260107/0001
     */
    public static function generateRegistrationNumber(string $type): string
    {
        $typeCode = match($type) {
            'RAWAT_JALAN' => 'RJ',
            'RAWAT_INAP' => 'RI',
            'IGD' => 'IGD',
            default => 'RJ',
        };

        $date = date('Ymd');
        $prefix = "REG/{$typeCode}/{$date}/";
        
        // Get last registration with same prefix
        $lastRegistration = self::where('registration_number', 'like', $prefix . '%')
            ->orderBy('registration_number', 'desc')
            ->first();

        if ($lastRegistration) {
            $lastSequence = intval(substr($lastRegistration->registration_number, -4));
            $newSequence = $lastSequence + 1;
        } else {
            $newSequence = 1;
        }

        return $prefix . str_pad($newSequence, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Generate Queue Number per Polyclinic per Day
     * Format: A001, A002, B001, etc.
     */
    public static function generateQueueNumber(int $polyclinicId, string $date): string
    {
        // Get polyclinic code first letter as queue prefix
        $polyclinic = Polyclinic::find($polyclinicId);
        $prefix = strtoupper(substr($polyclinic->code, 0, 1));

        // Count today's registrations for this polyclinic
        $count = self::where('polyclinic_id', $polyclinicId)
            ->whereDate('registration_date', $date)
            ->count();

        $sequence = $count + 1;

        return $prefix . str_pad($sequence, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Relationship: Registration belongs to a patient
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Relationship: Registration belongs to a doctor
     */
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    /**
     * Relationship: Registration belongs to a polyclinic
     */
    public function polyclinic(): BelongsTo
    {
        return $this->belongsTo(Polyclinic::class);
    }

    /**
     * Relationship: Registration created by user (petugas)
     */
    public function registeredBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'registered_by');
    }

    /**
     * Scope: Get registrations by status
     */
    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope: Get registrations by type
     */
    public function scopeByType($query, string $type)
    {
        return $query->where('registration_type', $type);
    }

    /**
     * Scope: Get today's registrations
     */
    public function scopeToday($query)
    {
        return $query->whereDate('registration_date', today());
    }
}
