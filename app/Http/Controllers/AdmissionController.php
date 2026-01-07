<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Polyclinic;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AdmissionController extends Controller
{
    /**
     * Display admission dashboard/index
     */
    public function index()
    {
        $todayRegistrations = Registration::with(['patient', 'doctor', 'polyclinic'])
            ->today()
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $stats = [
            'today_total' => Registration::today()->count(),
            'waiting' => Registration::today()->byStatus('MENUNGGU')->count(),
            'in_progress' => Registration::today()->byStatus('DIPERIKSA')->count(),
            'completed' => Registration::today()->byStatus('SELESAI')->count(),
        ];

        return view('admissions.index', compact('todayRegistrations', 'stats'));
    }

    /**
     * Show form for new patient registration (Rawat Jalan)
     */
    public function create()
    {
        $polyclinics = Polyclinic::active()->get();
        $doctors = Doctor::active()->with('polyclinic')->get();

        return view('admissions.create', compact('polyclinics', 'doctors'));
    }

    /**
     * Store new registration
     * 
     * BUSINESS FLOW:
     * 1. Validate input data
     * 2. Check if patient exists by NIK
     * 3. If new patient: create patient record with auto-generated No RM
     * 4. Create registration with auto-generated registration number and queue number
     * 5. Return success response
     */
    public function store(Request $request)
    {
        // 1. VALIDASI INPUT
        $validator = Validator::make($request->all(), [
            // Patient Data
            'nik' => 'required|digits:16',
            'name' => 'required|string|max:100',
            'date_of_birth' => 'required|date|before:today',
            'gender' => ['required', Rule::in(['L', 'P'])],
            'address' => 'required|string',
            'phone' => 'nullable|string|max:15',
            'blood_type' => 'nullable|string|max:3',
            'emergency_contact_name' => 'nullable|string|max:100',
            'emergency_contact_phone' => 'nullable|string|max:15',
            
            // Registration Data
            'polyclinic_id' => 'required|exists:polyclinics,id',
            'doctor_id' => 'required|exists:doctors,id',
            'registration_type' => ['required', Rule::in(['RAWAT_JALAN', 'RAWAT_INAP', 'IGD'])],
            'payment_method' => ['required', Rule::in(['UMUM', 'BPJS', 'ASURANSI'])],
            'insurance_number' => 'required_if:payment_method,BPJS,ASURANSI|nullable|string|max:50',
            'complaint' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            // 2. CEK APAKAH PASIEN SUDAH ADA (BERDASARKAN NIK)
            $patient = Patient::where('nik', $request->nik)->first();

            // 3. JIKA PASIEN BARU, BUAT RECORD PATIENT
            if (!$patient) {
                $patient = Patient::create([
                    'no_rm' => Patient::generateNoRM(),
                    'nik' => $request->nik,
                    'name' => $request->name,
                    'date_of_birth' => $request->date_of_birth,
                    'gender' => $request->gender,
                    'address' => $request->address,
                    'phone' => $request->phone,
                    'blood_type' => $request->blood_type,
                    'emergency_contact_name' => $request->emergency_contact_name,
                    'emergency_contact_phone' => $request->emergency_contact_phone,
                ]);

                $message = 'Pasien baru berhasil didaftarkan dengan No. RM: ' . $patient->no_rm;
            } else {
                $message = 'Pasien lama ditemukan dengan No. RM: ' . $patient->no_rm;
            }

            // 4. BUAT REGISTRATION RECORD
            $registrationDate = now()->format('Y-m-d');
            $registrationTime = now()->format('H:i:s');

            $registration = Registration::create([
                'registration_number' => Registration::generateRegistrationNumber($request->registration_type),
                'queue_number' => Registration::generateQueueNumber($request->polyclinic_id, $registrationDate),
                'patient_id' => $patient->id,
                'doctor_id' => $request->doctor_id,
                'polyclinic_id' => $request->polyclinic_id,
                'registration_type' => $request->registration_type,
                'payment_method' => $request->payment_method,
                'insurance_number' => $request->insurance_number,
                'registration_date' => $registrationDate,
                'registration_time' => $registrationTime,
                'status' => 'MENUNGGU',
                'complaint' => $request->complaint,
                'notes' => $request->notes,
                'registered_by' => auth()->id(),
            ]);

            DB::commit();

            // 5. RETURN SUCCESS RESPONSE
            return redirect()
                ->route('admissions.show', $registration->id)
                ->with('success', $message . ' | Registrasi berhasil dengan No. Registrasi: ' . $registration->registration_number);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display registration detail
     */
    public function show(Registration $registration)
    {
        $registration->load(['patient', 'doctor', 'polyclinic', 'registeredBy']);
        
        return view('admissions.show', compact('registration'));
    }

    /**
     * Update registration status
     */
    public function updateStatus(Request $request, Registration $registration)
    {
        $request->validate([
            'status' => ['required', Rule::in(['MENUNGGU', 'DIPERIKSA', 'SELESAI', 'BATAL'])],
        ]);

        $registration->update([
            'status' => $request->status,
        ]);

        return redirect()->back()
            ->with('success', 'Status pendaftaran berhasil diupdate');
    }

    /**
     * Get doctors by polyclinic (AJAX endpoint)
     */
    public function getDoctorsByPolyclinic($polyclinicId)
    {
        $doctors = Doctor::active()
            ->where('polyclinic_id', $polyclinicId)
            ->get(['id', 'name', 'specialization']);

        return response()->json($doctors);
    }

    /**
     * Check patient by NIK (AJAX endpoint)
     */
    public function checkPatientByNIK(Request $request)
    {
        $patient = Patient::where('nik', $request->nik)->first();

        if ($patient) {
            return response()->json([
                'exists' => true,
                'patient' => $patient,
            ]);
        }

        return response()->json([
            'exists' => false,
        ]);
    }
}
