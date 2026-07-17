@extends('layouts.app')

@section('title','Data Kegiatan')

@section('content')

<div class="card shadow">

    <div class="card-header bg-success text-white">

        <div class="d-flex justify-content-between align-items-center flex-wrap">

            <h4 class="mb-2 mb-md-0">

                <i class="bi bi-calendar-event"></i>

                Data Kegiatan

            </h4>

            <div>

                <a href="{{ route('activities.export.pdf') }}"
                   class="btn btn-danger">

                    <i class="bi bi-file-earmark-pdf"></i>

                    Export PDF

                </a>

                <a href="{{ route('activities.create') }}"
                   class="btn btn-light">

                    <i class="bi bi-plus-circle"></i>

                    Tambah Kegiatan

                </a>

            </div>

        </div>

    </div>

    <div class="card-body">

        @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            {{ session('success') }}

            <button class="btn-close"
                    data-bs-dismiss="alert"></button>

        </div>

        @endif

        <form action="{{ route('activities.index') }}"
              method="GET"
              class="mb-4">

            <div class="row">

                <div class="col-md-6">

                    <div class="input-group">

                        <input
                            type="text"
                            class="form-control"
                            name="search"
                            placeholder="Cari Judul, Lokasi, Kategori atau Instansi..."
                            value="{{ request('search') }}">

                        <button class="btn btn-primary">

                            <i class="bi bi-search"></i>

                            Cari

                        </button>

                        @if(request('search'))

                        <a href="{{ route('activities.index') }}"
                           class="btn btn-secondary">

                            Reset

                        </a>

                        @endif

                    </div>

                </div>

            </div>

        </form>

        <div class="table-responsive">

            <table class="table table-bordered table-hover align-middle">

                <thead class="table-dark text-center">

                <tr>

                    <th width="60">No</th>

                    <th width="90">Thumbnail</th>

                    <th>Judul</th>

                    <th>Kategori</th>

                    <th>Instansi</th>

                    <th width="120">Tanggal</th>

                    <th width="130">Status</th>

                    <th width="170">Aksi</th>

                </tr>

                </thead>

                <tbody>

                @forelse($activities as $activity)

                <tr>

                    <td class="text-center">

                        {{ $activities->firstItem() + $loop->index }}

                    </td>

                    <td class="text-center">

                        @if($activity->thumbnail)

                            <img
                                src="{{ asset('uploads/activities/'.$activity->thumbnail) }}"
                                class="rounded shadow-sm"
                                style="width:70px;height:70px;object-fit:cover;">
                        @else

                            -

                        @endif

                    </td>

                    <td>

                        <strong>

                            {{ $activity->title }}

                        </strong>

                        <br>

                        <small class="text-muted">

                            {{ $activity->location }}

                        </small>

                    </td>

                    <td>

                        {{ $activity->category->name }}

                    </td>

                    <td>

                        {{ $activity->institution->name }}

                    </td>

                    <td class="text-center">

                        {{ \Carbon\Carbon::parse($activity->activity_date)->format('d-m-Y') }}

                    </td>

                    <td class="text-center">

                        @if($activity->status=='Draft')

                            <span class="badge bg-secondary">

                                Draft

                            </span>

                        @elseif($activity->status=='Terjadwal')

                            <span class="badge bg-warning text-dark">

                                Terjadwal

                            </span>

                        @elseif($activity->status=='Dipublikasikan')

                            <span class="badge bg-success">

                                Dipublikasikan

                            </span>

                        @else

                            <span class="badge bg-primary">

                                Selesai

                            </span>

                        @endif

                    </td>

                    <td class="text-center">

                        <a href="{{ route('activities.edit',$activity) }}"
                           class="btn btn-warning btn-sm"
                           title="Edit">


                            <i class="bi bi-pencil"></i>

                        </a>

                        <form
                            action="{{ route('activities.destroy',$activity) }}"
                            method="POST"
                            class="d-inline">

                            @csrf

                            @method('DELETE')

                            <button
                                type="submit"
                                class="btn btn-danger btn-sm delete-confirm">

                                <i class="bi bi-trash"></i>

                            </button>

                        </form>

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="8"
                        class="text-center">

                        Belum ada data kegiatan.

                    </td>

                </tr>

                @endforelse

                </tbody>

            </table>

        </div>

        <div class="d-flex justify-content-center mt-4">

            {{ $activities->links() }}

        </div>

    </div>

</div>

@endsection