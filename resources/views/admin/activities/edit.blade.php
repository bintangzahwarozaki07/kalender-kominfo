@extends('layouts.app')

@section('title', 'Edit Kegiatan')

@section('content')
<div class="container py-4">
    <div class="card shadow">
        <div class="card-header bg-warning text-dark">
            <h4 class="mb-0">Edit Kegiatan</h4>
        </div>

        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('activities.update', $activity) }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Kategori</label>
                    <select name="category_id" class="form-select" required>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id', $activity->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Instansi</label>
                    <select name="institution_id" class="form-select" required>
                        @foreach ($institutions as $institution)
                            <option value="{{ $institution->id }}"
                                {{ old('institution_id', $activity->institution_id) == $institution->id ? 'selected' : '' }}>
                                {{ $institution->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Judul Kegiatan</label>
                    <input type="text"
                           name="title"
                           class="form-control"
                           value="{{ old('title', $activity->title) }}"
                           required>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Tanggal Kegiatan</label>
                        <input type="date"
                               name="activity_date"
                               class="form-control"
                               value="{{ old('activity_date', $activity->activity_date ? \Illuminate\Support\Carbon::parse($activity->activity_date)->format('Y-m-d') : '') }}"
                               required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Jam Mulai</label>
                        <select name="start_time" class="form-select" required>
                            @for ($h = 0; $h < 24; $h++)
                                @for ($m = 0; $m < 60; $m += 30)
                                    @php
                                        $jam = sprintf('%02d:%02d', $h, $m);
                                        $jamTersimpan = old('start_time', $activity->start_time
                                            ? substr((string) $activity->start_time, 0, 5)
                                            : '');
                                    @endphp
                                    <option value="{{ $jam }}"
                                        {{ $jamTersimpan == $jam ? 'selected' : '' }}>
                                        {{ $jam }}
                                    </option>
                                @endfor
                            @endfor
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Jam Selesai</label>
                        <select name="end_time" class="form-select" required>
                            @for ($h = 0; $h < 24; $h++)
                                @for ($m = 0; $m < 60; $m += 30)
                                    @php
                                        $jam = sprintf('%02d:%02d', $h, $m);
                                        $jamTersimpan = old('end_time', $activity->end_time
                                            ? substr((string) $activity->end_time, 0, 5)
                                            : '');
                                    @endphp
                                    <option value="{{ $jam }}"
                                        {{ $jamTersimpan == $jam ? 'selected' : '' }}>
                                        {{ $jam }}
                                    </option>
                                @endfor
                            @endfor
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Lokasi</label>
                    <input type="text"
                           name="location"
                           class="form-control"
                           value="{{ old('location', $activity->location) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Penanggung Jawab</label>
                    <input type="text"
                           name="person_in_charge"
                           class="form-control"
                           value="{{ old('person_in_charge', $activity->person_in_charge) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Tanggal Publikasi</label>
                    <input type="date"
                           name="publish_date"
                           class="form-control"
                           value="{{ old('publish_date', $activity->publish_date ? \Illuminate\Support\Carbon::parse($activity->publish_date)->format('Y-m-d') : '') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Thumbnail Saat Ini</label>
                    <div>
                        @if ($activity->thumbnail)
                            <img id="preview"
                                 src="{{ asset('uploads/activities/' . $activity->thumbnail) }}"
                                 class="img-thumbnail shadow-sm mb-3"
                                 style="max-width:250px; border-radius:10px;">
                        @else
                            <img id="preview"
                                 src="https://placehold.co/250x180?text=No+Image"
                                 class="img-thumbnail shadow-sm mb-3"
                                 style="max-width:250px; border-radius:10px;">
                        @endif
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Ganti Thumbnail</label>
                    <input type="file"
                           id="thumbnail"
                           name="thumbnail"
                           class="form-control"
                           accept="image/*">
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description"
                              rows="4"
                              class="form-control">{{ old('description', $activity->description) }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                        @foreach (['Draft', 'Terjadwal', 'Dipublikasikan', 'Selesai'] as $status)
                            <option value="{{ $status }}"
                                {{ old('status', $activity->status) == $status ? 'selected' : '' }}>
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('activities.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('thumbnail').addEventListener('change', function (e) {
    const file = e.target.files[0];

    if (file) {
        document.getElementById('preview').src = URL.createObjectURL(file);
    }
});
</script>
@endsection
