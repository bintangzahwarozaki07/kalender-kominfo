
@extends('layouts.pemohon')

@section('title', 'Buat Pengajuan Kegiatan')

@section('content')

<div class="page-heading">
    <div class="eyebrow">Layanan pemohon</div>
    <h1 class="page-title">Formulir Pengajuan Kegiatan</h1>
    <p class="page-description">
        Lengkapi informasi kegiatan dengan benar. Pengajuan akan diperiksa
        oleh Administrator Kominfo Kabupaten Ngawi.
    </p>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <strong><i class="bi bi-exclamation-circle"></i> Pengajuan belum dapat disimpan.</strong>
        <ul style="margin:8px 0 0;padding-left:20px">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="panel">
    <h2 class="panel-heading">Informasi Kegiatan</h2>
    <p class="panel-description">
        Isi seluruh kolom bertanda bintang (*) karena wajib diisi.
    </p>

    <form action="{{ route('pemohon.submissions.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="title" class="form-label">
                Nama Kegiatan <span class="required">*</span>
            </label>
            <input
                type="text"
                id="title"
                name="title"
                class="form-control"
                value="{{ old('title') }}"
                placeholder="Contoh: Rapat Koordinasi Publikasi"
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
                    Kategori Kegiatan <span class="required">*</span>
                </label>
                <select id="category_id" name="category_id" class="form-control" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                    @foreach ($institutions as $institution)
                        <option value="{{ $institution->id }}"
                            {{ old('institution_id') == $institution->id ? 'selected' : '' }}>
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
                value="{{ old('activity_date') }}"
                required
            >
            @error('activity_date')
                <div class="field-error">{{ $message }}</div>
            @enderror
        </div>

        <div style="background:#f3f8f5;border:1px solid #e0ebe3;border-radius:12px;padding:17px;margin-bottom:20px">
            <div style="font-size:12px;font-weight:800;color:#315b43;margin-bottom:5px">
                <i class="bi bi-clock"></i> Waktu Pelaksanaan
            </div>
            <p class="form-hint" style="margin:0 0 14px">
                Masukkan waktu dengan format 24 jam, misalnya 08:00 sampai 10:00.
            </p>

            <div class="form-grid">
                <div class="form-group" style="margin-bottom:0">
                    <label for="start_time" class="form-label">Waktu Mulai</label>
                    <input
                        type="text"
                        id="start_time"
                        name="start_time"
                        class="form-control"
                        value="{{ old('start_time') }}"
                        placeholder="08:00"
                        inputmode="numeric"
                        maxlength="5"
                        pattern="([01][0-9]|2[0-3]):[0-5][0-9]"
                        title="Masukkan waktu dalam format 24 jam, contoh 08:00"
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
                        value="{{ old('end_time') }}"
                        placeholder="10:00"
                        inputmode="numeric"
                        maxlength="5"
                        pattern="([01][0-9]|2[0-3]):[0-5][0-9]"
                        title="Masukkan waktu dalam format 24 jam, contoh 10:00"
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
                value="{{ old('location') }}"
                placeholder="Masukkan lokasi kegiatan"
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
                value="{{ old('person_in_charge') }}"
                placeholder="Nama penanggung jawab kegiatan"
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
                placeholder="Tuliskan informasi atau penjelasan kegiatan..."
            >{{ old('description') }}</textarea>
            @error('description')
                <div class="field-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="alert alert-warning">
            <i class="bi bi-info-circle"></i>
            <strong>Informasi:</strong>
            Setelah dikirim, pengajuan akan berstatus Menunggu sampai diperiksa
            oleh Administrator. Kegiatan belum masuk kalender resmi sebelum disetujui.
        </div>

        <div class="inline-actions">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-send"></i> Kirim Pengajuan
            </button>

            <a href="{{ route('pemohon.submissions.index') }}" class="btn btn-secondary">
                <i class="bi bi-clipboard-check"></i> Riwayat Pengajuan
            </a>

            <a href="{{ route('pemohon.dashboard') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </form>
</div>

@endsection
