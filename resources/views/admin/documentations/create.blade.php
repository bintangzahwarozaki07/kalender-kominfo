
@extends('layouts.app')

@section('title', 'Tambah Dokumentasi')

@section('content')
<div class="container">

    <div class="card shadow">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0">Tambah Dokumentasi</h4>
        </div>

        <div class="card-body">

            @if($errors->any())
                <div class="alert alert-danger">
                    <strong>Periksa kembali data yang dimasukkan:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('documentations.store') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                <h5 class="text-success mb-3">Informasi Dokumentasi</h5>

                <div class="mb-3">
                    <label class="form-label">Pilih Kegiatan</label>
                    <select name="activity_id" class="form-select" required>
                        <option value="">-- Pilih Kegiatan --</option>
                        @foreach($activities as $activity)
                            <option value="{{ $activity->id }}"
                                {{ old('activity_id') == $activity->id ? 'selected' : '' }}>
                                {{ $activity->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Upload Foto</label>
                    <input type="file"
                           id="photo"
                           name="photo"
                           class="form-control"
                           accept=".jpg,.jpeg,.png"
                           required>
                    <small class="text-muted">Format JPG, JPEG, atau PNG. Maksimal 2 MB.</small>
                </div>

                <div class="mb-3 text-center">
                    <img id="preview"
                         src="https://placehold.co/300x200?text=Preview+Foto"
                         class="img-thumbnail shadow-sm"
                         style="max-width:300px; max-height:200px; object-fit:cover;">
                </div>

                <div class="mb-3">
                    <label class="form-label">Caption</label>
                    <textarea name="caption"
                              rows="4"
                              class="form-control"
                              placeholder="Masukkan caption dokumentasi...">{{ old('caption') }}</textarea>
                </div>

                <div class="form-check mb-4">
                    <input class="form-check-input"
                           type="checkbox"
                           name="is_cover"
                           value="1"
                           id="cover"
                           {{ old('is_cover') ? 'checked' : '' }}>

                    <label class="form-check-label" for="cover">
                        Jadikan sebagai Cover
                    </label>
                </div>

                <hr>

                <h5 class="text-success mb-2">Link Publikasi</h5>
                <p class="text-muted">
                    Bagian ini bersifat opsional. Isi jika dokumentasi sudah dipublikasikan
                    melalui media sosial atau website.
                </p>

                <div class="mb-3">
                    <label class="form-label">Judul Publikasi</label>
                    <input type="text"
                           name="link_title"
                           class="form-control"
                           value="{{ old('link_title') }}"
                           maxlength="200"
                           placeholder="Contoh: Dokumentasi Kegiatan di Instagram">
                </div>

                <div class="mb-3">
                    <label class="form-label">Platform Publikasi</label>
                    <select name="platform" class="form-select">
                        <option value="">-- Pilih Platform --</option>
                        @foreach([
                            'Website',
                            'Instagram',
                            'Facebook',
                            'YouTube',
                            'TikTok',
                            'Google Drive',
                            'Lainnya'
                        ] as $platform)
                            <option value="{{ $platform }}"
                                {{ old('platform') == $platform ? 'selected' : '' }}>
                                {{ $platform }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label">URL Publikasi</label>
                    <input type="url"
                           name="url"
                           class="form-control"
                           value="{{ old('url') }}"
                           placeholder="https://contoh.com/publikasi">
                    <small class="text-muted">
                        Masukkan alamat lengkap publikasi yang dapat dibuka.
                    </small>
                </div>

                <hr>

                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save"></i> Simpan Dokumentasi
                </button>

                <a href="{{ route('documentations.index') }}"
                   class="btn btn-secondary">
                    Batal
                </a>

            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('photo').addEventListener('change', function(e) {
    const file = e.target.files[0];

    if (file) {
        document.getElementById('preview').src = URL.createObjectURL(file);
    }
});
</script>
@endsection
