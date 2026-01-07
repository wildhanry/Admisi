@extends('layouts.app')

@section('title', 'Detail Registrasi - SIM Klinik')

@section('content')
<div class="py-6 md:py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Success Message -->
        @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 p-4 rounded-lg">
            <p class="text-green-800 text-sm">{{ session('success') }}</p>
        </div>
        @endif

        <!-- Header -->
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Detail Registrasi</h2>
                <p class="mt-1 text-sm text-gray-500">Informasi lengkap pendaftaran pasien</p>
            </div>
            <a href="{{ route('admissions.index') }}" 
               class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors font-medium">
                Kembali
            </a>
        </div>

        <!-- Registration Info Card -->
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden mb-6">
            <div class="bg-blue-50 px-6 py-5 border-b border-gray-200">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">{{ $registration->registration_number }}</h3>
                        <p class="text-gray-600 text-sm mt-1">Nomor Antrian: <span class="font-semibold">{{ $registration->queue_number }}</span></p>
                    </div>
                    <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium
                        @if($registration->status == 'MENUNGGU') bg-yellow-100 text-yellow-700
                        @elseif($registration->status == 'DIPERIKSA') bg-blue-100 text-blue-700
                        @elseif($registration->status == 'SELESAI') bg-green-100 text-green-700
                        @else bg-red-100 text-red-700
                        @endif">
                        {{ $registration->status }}
                    </span>
                </div>
            </div>
            
            <div class="px-6 py-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-sm font-semibold text-gray-500 uppercase mb-3">Informasi Pendaftaran</h4>
                        <dl class="space-y-2">
                            <div>
                                <dt class="text-sm text-gray-600">Tanggal Pendaftaran</dt>
                                <dd class="text-sm font-medium text-gray-900">{{ $registration->registration_date->format('d M Y') }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm text-gray-600">Waktu Pendaftaran</dt>
                                <dd class="text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($registration->registration_time)->format('H:i') }} WIB</dd>
                            </div>
                            <div>
                                <dt class="text-sm text-gray-600">Tipe Pendaftaran</dt>
                                <dd class="text-sm font-medium text-gray-900">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                        {{ str_replace('_', ' ', $registration->registration_type) }}
                                    </span>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm text-gray-600">Metode Pembayaran</dt>
                                <dd class="text-sm font-medium text-gray-900">{{ $registration->payment_method }}</dd>
                            </div>
                            @if($registration->insurance_number)
                            <div>
                                <dt class="text-sm text-gray-600">Nomor {{ $registration->payment_method }}</dt>
                                <dd class="text-sm font-medium text-gray-900">{{ $registration->insurance_number }}</dd>
                            </div>
                            @endif
                        </dl>
                    </div>

                    <div>
                        <h4 class="text-sm font-semibold text-gray-500 uppercase mb-3">Layanan</h4>
                        <dl class="space-y-2">
                            <div>
                                <dt class="text-sm text-gray-600">Poli/Klinik</dt>
                                <dd class="text-sm font-medium text-gray-900">{{ $registration->polyclinic->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm text-gray-600">Dokter</dt>
                                <dd class="text-sm font-medium text-gray-900">{{ $registration->doctor->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm text-gray-600">Spesialisasi</dt>
                                <dd class="text-sm font-medium text-gray-900">{{ $registration->doctor->specialization }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                @if($registration->complaint)
                <div class="mt-6 pt-6 border-t">
                    <h4 class="text-sm font-semibold text-gray-500 uppercase mb-2">Keluhan Pasien</h4>
                    <p class="text-sm text-gray-700">{{ $registration->complaint }}</p>
                </div>
                @endif

                @if($registration->notes)
                <div class="mt-4">
                    <h4 class="text-sm font-semibold text-gray-500 uppercase mb-2">Catatan</h4>
                    <p class="text-sm text-gray-700">{{ $registration->notes }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Patient Info Card -->
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            <div class="bg-green-50 px-6 py-4 border-b border-gray-200">
                <h3 class="text-base font-semibold text-gray-900">Data Pasien</h3>
            </div>
            
            <div class="px-6 py-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <dl class="space-y-2">
                            <div>
                                <dt class="text-sm text-gray-600">No. Rekam Medis</dt>
                                <dd class="text-sm font-bold text-blue-600">{{ $registration->patient->no_rm }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm text-gray-600">NIK</dt>
                                <dd class="text-sm font-medium text-gray-900">{{ $registration->patient->nik }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm text-gray-600">Nama Lengkap</dt>
                                <dd class="text-sm font-medium text-gray-900">{{ $registration->patient->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm text-gray-600">Jenis Kelamin</dt>
                                <dd class="text-sm font-medium text-gray-900">{{ $registration->patient->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</dd>
                            </div>
                        </dl>
                    </div>

                    <div>
                        <dl class="space-y-2">
                            <div>
                                <dt class="text-sm text-gray-600">Tanggal Lahir</dt>
                                <dd class="text-sm font-medium text-gray-900">{{ $registration->patient->date_of_birth->format('d M Y') }} ({{ $registration->patient->age }} tahun)</dd>
                            </div>
                            @if($registration->patient->blood_type)
                            <div>
                                <dt class="text-sm text-gray-600">Golongan Darah</dt>
                                <dd class="text-sm font-medium text-gray-900">{{ $registration->patient->blood_type }}</dd>
                            </div>
                            @endif
                            <div>
                                <dt class="text-sm text-gray-600">No. Telepon</dt>
                                <dd class="text-sm font-medium text-gray-900">{{ $registration->patient->phone ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm text-gray-600">Alamat</dt>
                                <dd class="text-sm font-medium text-gray-900">{{ $registration->patient->address }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Update Status Form -->
        <div class="mt-6 bg-white rounded-lg border border-gray-200 overflow-hidden">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <h3 class="text-base font-semibold text-gray-900">Update Status</h3>
            </div>
            <div class="px-6 py-5">
                <form action="{{ route('admissions.updateStatus', $registration) }}" method="POST" class="flex flex-col md:flex-row gap-4">
                    @csrf
                    @method('PATCH')
                    
                    <div class="flex-1">
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                            Status Pendaftaran
                        </label>
                        <select name="status" 
                                id="status"
                                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            <option value="MENUNGGU" {{ $registration->status == 'MENUNGGU' ? 'selected' : '' }}>Menunggu</option>
                            <option value="DIPERIKSA" {{ $registration->status == 'DIPERIKSA' ? 'selected' : '' }}>Sedang Diperiksa</option>
                            <option value="SELESAI" {{ $registration->status == 'SELESAI' ? 'selected' : '' }}>Selesai</option>
                            <option value="BATAL" {{ $registration->status == 'BATAL' ? 'selected' : '' }}>Batal</option>
                        </select>
                    </div>
                    
                    <div class="flex items-end">
                        <button type="submit" 
                                class="w-full md:w-auto px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                            Update Status
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
