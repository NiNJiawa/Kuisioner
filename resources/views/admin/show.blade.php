@extends('layouts.admin')

@section('content')
<div class="container">
    <h2 class="mb-4">Hasil untuk: {{ $user->name }}</h2>

    <ul class="nav nav-tabs mb-4" id="adminTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="raw-tab" data-bs-toggle="tab" data-bs-target="#raw" type="button" role="tab">Raw Score</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="scale-tab" data-bs-toggle="tab" data-bs-target="#scale" type="button" role="tab">Output 1 (Scale Score)</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="cluster-tab" data-bs-toggle="tab" data-bs-target="#cluster" type="button" role="tab">Klaster Profesi</button>
        </li>
    </ul>

    <div class="tab-content" id="adminTabContent">
        <div class="tab-pane fade show active" id="raw" role="tabpanel">
            {{-- Chart dan Tabel Raw Score masuk di sini --}}
            @include('admin.partials.raw_score', ['user' => $user])
        </div>

        <div class="tab-pane fade" id="scale" role="tabpanel">
            <h4>Scale Score</h4>
            <p>(Akan diisi nanti dengan tabel dan chart scale score)</p>
        </div>

        <div class="tab-pane fade" id="cluster" role="tabpanel">
            @include('admin.partials.klaster_profesi', ['user' => $user])
        </div>
    </div> {{-- Tutup div tab-content --}}
</div>
@endsection
