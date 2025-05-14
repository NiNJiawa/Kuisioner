@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="alert alert-success text-center">
        <h4 class="alert-heading">🎉 Jawaban Berhasil Dikirim!</h4>
        <p class="mb-0">Terima kasih telah mengisi kuisioner. Berikut adalah hasil evaluasi berdasarkan jawaban Anda:</p>
    </div>

    <div class="row justify-content-center mt-4">
        @forelse ($results as $result)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body text-center">
                        <h5 class="card-title text-primary">{{ $result->passion->name }}</h5>
                        <p class="card-text mb-2">Raw Score: <strong>{{ $result->raw_score }}</strong></p>
                        <p class="card-text mb-0">Scale Score: 
                            <span class="badge bg-info text-dark">{{ $result->scale_score }}</span>
                        </p>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <p class="text-muted">Belum ada hasil yang tersedia.</p>
            </div>
        @endforelse
    </div>


</div>
@endsection
