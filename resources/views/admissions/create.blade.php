@extends('layouts.app')

@section('title', 'Pendaftaran Pasien Baru - SIM Klinik')

@section('content')
<div class="py-6 md:py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Pendaftaran Pasien Baru</h2>
            <p class="mt-1 text-sm text-gray-500">Lengkapi formulir untuk mendaftarkan pasien</p>
        </div>

        <!-- Alert Messages -->
        @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 p-4 rounded-lg">
            <p class="text-green-800 text-sm">{{ session('success') }}</p>
        </div>
        @endif

        @if(session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 p-4 rounded-lg">
            <p class="text-red-800 text-sm">{{ session('error') }}</p>
        </div>
        @endif

        @if($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 p-4 rounded-lg">
            <p class="font-medium text-red-800 text-sm mb-2">Terdapat kesalahan:</p>
            <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Form -->
        <form action="{{ route('admissions.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Card: Data Pasien -->
            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                <div class="bg-blue-50 px-6 py-4 border-b border-gray-200">
                    <h3 class="text-base font-semibold text-gray-900">Data Pasien</h3>
                </div>
                <div class="px-6 py-6 space-y-6">
                    <!-- NIK -->
                    <div>
                        <label for="nik" class="block text-sm font-medium text-gray-700 mb-2">
                            NIK <span class="text-red-500">*</span>
                        </label>
                        <div class="flex gap-3">
                            <input type="text" 
                                   name="nik" 
                                   id="nik" 
                                   maxlength="16"
                                   value="{{ old('nik') }}"
                                   class="flex-1 rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 px-4 py-2.5" 
                                   placeholder="Masukkan 16 digit NIK"
                                   required>
                            <button type="button" 
                                    id="checkNikBtn"
                                    class="px-5 py-2.5 bg-gray-600 text-white text-sm rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 whitespace-nowrap">
                                Cek NIK
                            </button>
                        </div>
                        <p class="mt-2 text-xs text-gray-500">Sistem akan mengecek apakah pasien sudah terdaftar</p>
                        <div id="patientInfo" class="mt-3 hidden"></div>
                    </div>

                    <!-- Name & Date of Birth -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="name" 
                                   id="name"
                                   value="{{ old('name') }}"
                                   class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 px-4 py-2.5" 
                                   placeholder="Nama sesuai KTP"
                                   required>
                        </div>
                        <div>
                            <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Lahir <span class="text-red-500">*</span>
                            </label>
                            <input type="date" 
                                   name="date_of_birth" 
                                   id="date_of_birth"
                                   value="{{ old('date_of_birth') }}"
                                   class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 px-4 py-2.5"
                                   required>
                        </div>
                    </div>

                    <!-- Gender & Blood Type -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">
                                Jenis Kelamin <span class="text-red-500">*</span>
                            </label>
                            <select name="gender" 
                                    id="gender"
                                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 px-4 py-2.5"
                                    required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        <div>
                            <label for="blood_type" class="block text-sm font-medium text-gray-700 mb-2">
                                Golongan Darah
                            </label>
                            <select name="blood_type" 
                                    id="blood_type"
                                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 px-4 py-2.5">
                                <option value="">Pilih Golongan Darah</option>
                                <option value="A" {{ old('blood_type') == 'A' ? 'selected' : '' }}>A</option>
                                <option value="B" {{ old('blood_type') == 'B' ? 'selected' : '' }}>B</option>
                                <option value="AB" {{ old('blood_type') == 'AB' ? 'selected' : '' }}>AB</option>
                                <option value="O" {{ old('blood_type') == 'O' ? 'selected' : '' }}>O</option>
                            </select>
                        </div>
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                            No. Telepon
                        </label>
                        <input type="tel" 
                               name="phone" 
                               id="phone"
                               value="{{ old('phone') }}"
                               class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 px-4 py-2.5" 
                               placeholder="Contoh: 08123456789">
                    </div>

                    <!-- Address -->
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                            Alamat Lengkap <span class="text-red-500">*</span>
                        </label>
                        <textarea name="address" 
                                  id="address" 
                                  rows="3"
                                  class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 px-4 py-2.5" 
                                  placeholder="Jalan, RT/RW, Kelurahan, Kecamatan, Kota"
                                  required>{{ old('address') }}</textarea>
                    </div>

                    <!-- Emergency Contact -->
                    <div class="border-t border-gray-200 pt-6">
                        <h4 class="text-sm font-semibold text-gray-900 mb-4">Kontak Darurat</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label for="emergency_contact_name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Kontak Darurat
                                </label>
                                <input type="text" 
                                       name="emergency_contact_name" 
                                       id="emergency_contact_name"
                                       value="{{ old('emergency_contact_name') }}"
                                       class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 px-4 py-2.5" 
                                       placeholder="Nama keluarga/kerabat">
                            </div>
                            <div>
                                <label for="emergency_contact_phone" class="block text-sm font-medium text-gray-700 mb-2">
                                    No. Telepon Darurat
                                </label>
                                <input type="tel" 
                                       name="emergency_contact_phone" 
                                       id="emergency_contact_phone"
                                       value="{{ old('emergency_contact_phone') }}"
                                       class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 px-4 py-2.5" 
                                       placeholder="Contoh: 08123456789">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card: Data Pendaftaran -->
            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                <div class="bg-green-50 px-6 py-4 border-b border-gray-200">
                    <h3 class="text-base font-semibold text-gray-900">Data Pendaftaran</h3>
                </div>
                <div class="px-6 py-6 space-y-6">
                    <!-- Registration Type -->
                    <div>
                        <label for="registration_type" class="block text-sm font-medium text-gray-700 mb-2">
                            Tipe Pendaftaran <span class="text-red-500">*</span>
                        </label>
                        <select name="registration_type" 
                                id="registration_type"
                                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 px-4 py-2.5"
                                required>
                            <option value="RAWAT_JALAN" {{ old('registration_type') == 'RAWAT_JALAN' ? 'selected' : '' }}>Rawat Jalan</option>
                            <option value="RAWAT_INAP" {{ old('registration_type') == 'RAWAT_INAP' ? 'selected' : '' }}>Rawat Inap</option>
                            <option value="IGD" {{ old('registration_type') == 'IGD' ? 'selected' : '' }}>IGD (Instalasi Gawat Darurat)</option>
                        </select>
                    </div>

                    <!-- Polyclinic & Doctor -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="polyclinic_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Poli/Klinik Tujuan <span class="text-red-500">*</span>
                            </label>
                            <select name="polyclinic_id" 
                                    id="polyclinic_id"
                                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 px-4 py-2.5"
                                    required>
                                <option value="">Pilih Poli</option>
                                @foreach($polyclinics as $polyclinic)
                                <option value="{{ $polyclinic->id }}" {{ old('polyclinic_id') == $polyclinic->id ? 'selected' : '' }}>
                                    {{ $polyclinic->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="doctor_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Dokter <span class="text-red-500">*</span>
                            </label>
                            <select name="doctor_id" 
                                    id="doctor_id"
                                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 px-4 py-2.5"
                                    required>
                                <option value="">Pilih poli terlebih dahulu</option>
                                @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id }}" 
                                        data-polyclinic="{{ $doctor->polyclinic_id }}"
                                        {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                    {{ $doctor->name }} - {{ $doctor->specialization }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div>
                        <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-2">
                            Metode Pembayaran <span class="text-red-500">*</span>
                        </label>
                        <select name="payment_method" 
                                id="payment_method"
                                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 px-4 py-2.5"
                                required>
                            <option value="UMUM" {{ old('payment_method') == 'UMUM' ? 'selected' : '' }}>Umum (Bayar Tunai)</option>
                            <option value="BPJS" {{ old('payment_method') == 'BPJS' ? 'selected' : '' }}>BPJS Kesehatan</option>
                            <option value="ASURANSI" {{ old('payment_method') == 'ASURANSI' ? 'selected' : '' }}>Asuransi Swasta</option>
                        </select>
                    </div>

                    <!-- Insurance Number -->
                    <div id="insurance_number_field" class="hidden">
                        <label for="insurance_number" class="block text-sm font-medium text-gray-700 mb-2">
                            Nomor BPJS/Asuransi <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="insurance_number" 
                               id="insurance_number"
                               value="{{ old('insurance_number') }}"
                               class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 px-4 py-2.5" 
                               placeholder="Masukkan nomor kartu BPJS/Asuransi">
                    </div>

                    <!-- Complaint -->
                    <div>
                        <label for="complaint" class="block text-sm font-medium text-gray-700 mb-2">
                            Keluhan Pasien
                        </label>
                        <textarea name="complaint" 
                                  id="complaint" 
                                  rows="3"
                                  class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 px-4 py-2.5" 
                                  placeholder="Deskripsikan keluhan pasien (opsional)">{{ old('complaint') }}</textarea>
                    </div>

                    <!-- Notes -->
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                            Catatan Tambahan
                        </label>
                        <textarea name="notes" 
                                  id="notes" 
                                  rows="2"
                                  class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 px-4 py-2.5" 
                                  placeholder="Catatan khusus (opsional)">{{ old('notes') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex flex-col sm:flex-row justify-end gap-3 pt-6">
                <a href="{{ route('admissions.index') }}" 
                   class="inline-flex items-center justify-center px-5 py-2.5 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-colors">
                    Batal
                </a>
                <button type="submit" 
                        class="inline-flex items-center justify-center px-6 py-2.5 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition-colors">
                    Daftar Pasien
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter doctors by polyclinic
    const polyclinicSelect = document.getElementById('polyclinic_id');
    const doctorSelect = document.getElementById('doctor_id');
    const allDoctorOptions = Array.from(doctorSelect.options);

    polyclinicSelect.addEventListener('change', function() {
        const selectedPolyclinic = this.value;
        
        // Clear current options
        doctorSelect.innerHTML = '<option value="">Pilih Dokter</option>';
        
        if (selectedPolyclinic) {
            // Filter and add matching doctors
            allDoctorOptions.forEach(option => {
                if (option.dataset.polyclinic === selectedPolyclinic) {
                    doctorSelect.appendChild(option.cloneNode(true));
                }
            });
        }
    });

    // Toggle insurance number field
    const paymentMethodSelect = document.getElementById('payment_method');
    const insuranceNumberField = document.getElementById('insurance_number_field');
    const insuranceNumberInput = document.getElementById('insurance_number');

    paymentMethodSelect.addEventListener('change', function() {
        if (this.value === 'BPJS' || this.value === 'ASURANSI') {
            insuranceNumberField.classList.remove('hidden');
            insuranceNumberInput.required = true;
        } else {
            insuranceNumberField.classList.add('hidden');
            insuranceNumberInput.required = false;
            insuranceNumberInput.value = '';
        }
    });

    // Check NIK for existing patient
    const checkNikBtn = document.getElementById('checkNikBtn');
    const nikInput = document.getElementById('nik');
    const patientInfoDiv = document.getElementById('patientInfo');

    checkNikBtn.addEventListener('click', function() {
        const nik = nikInput.value;
        
        if (nik.length !== 16) {
            alert('NIK harus 16 digit');
            return;
        }

        // AJAX request to check patient
        fetch('/admissions/api/check-patient', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ nik: nik })
        })
        .then(response => response.json())
        .then(data => {
            if (data.exists) {
                // Fill form with existing patient data
                document.getElementById('name').value = data.patient.name;
                document.getElementById('date_of_birth').value = data.patient.date_of_birth;
                document.getElementById('gender').value = data.patient.gender;
                document.getElementById('address').value = data.patient.address;
                document.getElementById('phone').value = data.patient.phone || '';
                document.getElementById('blood_type').value = data.patient.blood_type || '';
                
                // Disable patient data fields
                ['name', 'date_of_birth', 'gender', 'address'].forEach(id => {
                    document.getElementById(id).readOnly = true;
                    document.getElementById(id).classList.add('bg-gray-100');
                });

                patientInfoDiv.innerHTML = `
                    <div class="p-3 bg-blue-50 border border-blue-200 rounded-md">
                        <p class="text-sm text-blue-800">
                            ✓ Pasien ditemukan - No. RM: <strong>${data.patient.no_rm}</strong>
                        </p>
                    </div>
                `;
                patientInfoDiv.classList.remove('hidden');
            } else {
                patientInfoDiv.innerHTML = `
                    <div class="p-3 bg-yellow-50 border border-yellow-200 rounded-md">
                        <p class="text-sm text-yellow-800">
                            ⓘ Pasien baru - Silakan lengkapi data
                        </p>
                    </div>
                `;
                patientInfoDiv.classList.remove('hidden');
                
                // Enable all fields for new patient
                ['name', 'date_of_birth', 'gender', 'address'].forEach(id => {
                    document.getElementById(id).readOnly = false;
                    document.getElementById(id).classList.remove('bg-gray-100');
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mengecek NIK');
        });
    });

    // Trigger payment method change on load if needed
    if (paymentMethodSelect.value === 'BPJS' || paymentMethodSelect.value === 'ASURANSI') {
        paymentMethodSelect.dispatchEvent(new Event('change'));
    }

    // Trigger polyclinic change on load if needed
    if (polyclinicSelect.value) {
        polyclinicSelect.dispatchEvent(new Event('change'));
    }
});
</script>
@endpush
@endsection
