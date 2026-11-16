
@extends('layouts.pemohon')

@section('title', 'Perbaiki Pengajuan')

@section('content')

<div class="page-heading">
    <div class="eyebrow">Perbaikan pengajuan</div>
    <h1 class="page-title">Perbaiki Pengajuan Kegiatan</h1>
    <p class="page-description">
        Perbarui informasi kegiatan berdasarkan catatan dari Administrator.
        Periksa kembali seluruh data sebelum mengirim ulang.
    </p>
</div>

<div style="margin-bottom:18px">
    <a href="{{ route('pemohon.submissions.index') }}"
       style="color:#087f5b;text-decoration:none;font-size:12px;font-weight:700">
        <i class="bi bi-arrow-left"></i> Kembali ke Riwayat Pengajuan
    </a>
</div>

@if($submission->admin_note)
    <div class="alert alert-warning">
        <strong>
            <i class="bi bi-chat-left-text"></i>
            Catatan Administrator:
        </strong>
        <div style="margin-top:8px;line-height:1.7">
            {{ $submission->admin_note }}
        </div>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <strong><i class="bi bi-exclamation-circle"></i> Periksa kembali formulir:</strong>
        <ul style="margin:8px 0 0;padding-left:20px">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="panel">
    <h2 class="panel-heading">Perbarui Informasi Kegiatan</h2>
    <p class="panel-description">
        Data sebelumnya telah ditampilkan. Silakan ubah bagian yang perlu diperbaiki.
    </p>

    <form action="{{ route('pemohon.submissions.update', $submission->id) }}"
          method="POST">

        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title" class="form-label">
                Judul Kegiatan <span class="required">*</span>
            </label>
            <input
                type="text"
                id="title"
                name="title"
                class="form-control"
                value="{{ old('title', $submission->title) }}"
                maxlength="255"
                required
            >
            @error('title')
                <div class="field-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label for="category_id" class="form-label">
                    Kategori <span class="required">*</span>
                </label>
                <select id="category_id" name="category_id" class="form-control" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ (string) old('category_id', $submission->category_id) === (string) $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="field-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="institution_id" class="form-label">
                    Instansi <span class="required">*</span>
                </label>
                <select id="institution_id" name="institution_id" class="form-control" required>
                    <option value="">-- Pilih Instansi --</option>
                    @foreach($institutions as $institution)
                        <option value="{{ $institution->id }}"
                            {{ (string) old('institution_id', $submission->institution_id) === (string) $institution->id ? 'selected' : '' }}>
                            {{ $institution->name }}
                        </option>
                    @endforeach
                </select>
                @error('institution_id')
                    <div class="field-error">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="activity_date" class="form-label">
                Tanggal Kegiatan <span class="required">*</span>
            </label>
            <input
                type="date"
                id="activity_date"
                name="activity_date"
                class="form-control"
                value="{{ old('activity_date', $submission->activity_date ? $submission->activity_date->format('Y-m-d') : '') }}"
                required
            >
            @error('activity_date')
                <div class="field-error">{{ $message }}</div>
            @enderror
        </div>

        <div style="background:#f3f8f5;border:1px solid #e0ebe3;border-radius:12px;padding:17px;margin-bottom:20px">
            <div style="font-size:12px;font-weight:800;color:#315b43;margin-bottom:14px">
                <i class="bi bi-clock"></i> Waktu Pelaksanaan
            </div>

            <div class="form-grid">
                <div class="form-group" style="margin-bottom:0">
                    <label for="start_time" class="form-label">Waktu Mulai</label>
                    <input
                        type="text"
                        id="start_time"
                        name="start_time"
                        class="form-control"
                        value="{{ old('start_time', substr($submission->start_time ?? '', 0, 5)) }}"
                        placeholder="08:00"
                        inputmode="numeric"
                        maxlength="5"
                        pattern="([01][0-9]|2[0-3]):[0-5][0-9]"
                        title="Masukkan format 24 jam, contoh 08:00"
                    >
                    @error('start_time')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group" style="margin-bottom:0">
                    <label for="end_time" class="form-label">Waktu Selesai</label>
                    <input
                        type="text"
                        id="end_time"
                        name="end_time"
                        class="form-control"
                        value="{{ old('end_time', substr($submission->end_time ?? '', 0, 5)) }}"
                        placeholder="16:00"
                        inputmode="numeric"
                        maxlength="5"
                        pattern="([01][0-9]|2[0-3]):[0-5][0-9]"
                        title="Masukkan format 24 jam, contoh 16:00"
                    >
                    @error('end_time')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="location" class="form-label">Lokasi Kegiatan</label>
            <input
                type="text"
                id="location"
                name="location"
                class="form-control"
                value="{{ old('location', $submission->location) }}"
                maxlength="255"
            >
            @error('location')
                <div class="field-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="person_in_charge" class="form-label">Penanggung Jawab</label>
            <input
                type="text"
                id="person_in_charge"
                name="person_in_charge"
                class="form-control"
                value="{{ old('person_in_charge', $submission->person_in_charge) }}"
                maxlength="255"
            >
            @error('person_in_charge')
                <div class="field-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="description" class="form-label">Deskripsi Kegiatan</label>
            <textarea
                id="description"
                name="description"
                class="form-control"
                rows="5"
            >{{ old('description', $submission->description) }}</textarea>
            @error('description')
                <div class="field-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="alert alert-warning">
            <i class="bi bi-info-circle"></i>
            Pastikan seluruh perbaikan telah sesuai dengan catatan Administrator
            sebelum mengirim ulang pengajuan.
        </div>

        <div class="inline-actions">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-send"></i> Kirim Ulang Pengajuan
            </button>

            <a href="{{ route('pemohon.submissions.index') }}" class="btn btn-secondary">
                <i class="bi bi-x-circle"></i> Batal
            </a>
        </div>
    </form>
</div>

@endsection
