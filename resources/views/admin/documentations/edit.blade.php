
@extends('layouts.app')

@section('title', 'Edit Dokumentasi')

@section('content')
<div class="container">

    <div class="card shadow">
        <div class="card-header bg-warning">
            <h4 class="mb-0">Edit Dokumentasi</h4>
        </div>

        <div class="card-body">

            @if($errors->any())
                <div class="alert alert-danger">
                    <strong>Periksa kembali data:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('documentations.update', $documentation) }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <h5 class="text-success mb-3">Informasi Dokumentasi</h5>

                <div class="mb-3">
                    <label class="form-label">Pilih Kegiatan</label>
                    <select name="activity_id" class="form-select" required>
                        @foreach($activities as $activity)
                            <option value="{{ $activity->id }}"
                                {{ old('activity_id', $documentation->activity_id) == $activity->id ? 'selected' : '' }}>
                                {{ $activity->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Preview Foto</label>
                    <br>
                    <img id="preview"
                         src="{{ asset('uploads/documentations/'.$documentation->photo) }}"
                         style="max-width:300px; max-height:220px; object-fit:cover;"
                         class="img-thumbnail">
                </div>

                <div class="mb-3">
                    <label class="form-label">Ganti Foto</label>
                    <input type="file"
                           id="photo"
                           name="photo"
                           class="form-control"
                           accept=".jpg,.jpeg,.png">
                    <small class="text-muted">Format JPG, JPEG, PNG. Maksimal 2 MB.</small>
                </div>

                <div class="mb-3">
                    <label class="form-label">Caption</label>
                    <textarea name="caption"
                              rows="4"
                              class="form-control"
                              placeholder="Masukkan caption dokumentasi...">{{ old('caption', $documentation->caption) }}</textarea>
                </div>

                <div class="form-check mb-4">
                    <input class="form-check-input"
                           type="checkbox"
                           name="is_cover"
                           value="1"
                           id="cover"
                           {{ old('is_cover', $documentation->is_cover) ? 'checked' : '' }}>

                    <label class="form-check-label" for="cover">
                        Jadikan sebagai Cover
                    </label>
                </div>

                <hr>

                <h5 class="text-success mb-3">Link Publikasi</h5>

                @if($documentation->links->count() > 0)
                    <div class="alert alert-light border">
                        <strong>Link yang sudah tersimpan:</strong>

                        @foreach($documentation->links as $link)
                            <div class="border rounded p-3 mt-2">
                                <div>
                                    <strong>{{ $link->title }}</strong>
                                </div>
                                <div class="text-muted small">
                                    Platform: {{ $link->platform }}
                                </div>
                                <a href="{{ $link->url }}"
                                   target="_blank"
                                   rel="noopener noreferrer">
                                    {{ $link->url }}
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-secondary">
                        Belum ada link publikasi yang terhubung langsung
                        dengan dokumentasi ini.
                    </div>
                @endif

                <p class="text-muted">
                    Isi bagian berikut jika ingin menambahkan link publikasi baru.
                    Kolom ini boleh dikosongkan.
                </p>

                <div class="mb-3">
                    <label class="form-label">Judul Publikasi Baru</label>
                    <input type="text"
                           name="link_title"
                           class="form-control"
                           value="{{ old('link_title') }}"
                           maxlength="200"
                           placeholder="Contoh: Dokumentasi Kegiatan di Instagram">
                </div>

                <div class="mb-3">
                    <label class="form-label">Platform</label>
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
                    <label class="form-label">URL Publikasi Baru</label>
                    <input type="url"
                           name="url"
                           class="form-control"
                           value="{{ old('url') }}"
                           placeholder="https://contoh.com/publikasi">
                </div>

                <hr>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Update Dokumentasi
                </button>

                <a href="{{ route('documentations.index') }}"
                   class="btn btn-secondary">
                    Kembali
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
