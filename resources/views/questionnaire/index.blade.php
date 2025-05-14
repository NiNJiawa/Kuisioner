@extends('layouts.app')

@section('content')
    <div class="questionnaire-wrapper">
        <h2 class="fw-bold mb-4 text-primary">Passion Domain</h2>

        <div class="instruction-box">
            <strong>Petunjuk:</strong> Bacalah setiap pernyataan dengan seksama dan pilih salah satu: <strong>TS</strong>
            (Tak Sesuai),
            <strong>SdS</strong> (Sedikit Sesuai), <strong>CS</strong> (Cukup Sesuai), <strong>SS</strong> (Sangat Sesuai).
        </div>

        <form action="{{ route('questionnaire.store') }}" method="POST" id="questionnaireForm">
            @csrf

            @foreach ($questions as $index => $q)
                <div class="question-card {{ $index === 0 ? 'active' : '' }}" id="question-{{ $index }}">
                    <h5 class="mb-4"><strong>{{ $index + 1 }}.</strong> {{ $q->statement }}</h5>

                    <div class="d-flex justify-content-center flex-wrap gap-4">
                        @foreach ($options as $a)
                            <div class="text-center">
                                <input class="form-check-input" type="radio" name="responses[{{ $q->id }}]"
                                    value="{{ $a->id }}" id="q{{ $q->id }}a{{ $a->id }}"
                                    {{ isset($savedResponses[$q->id]) && $savedResponses[$q->id] == $a->id ? 'checked' : '' }}>
                                <label class="option-label"
                                    for="q{{ $q->id }}a{{ $a->id }}">{{ $a->label }}</label>
                            </div>
                        @endforeach
                    </div>

                    <div class="btn-nav">
                        @if ($index > 0)
                            <button type="button" class="btn btn-outline-secondary prev-button">Kembali</button>
                        @else
                            <div></div>
                        @endif

                        @if ($index + 1 < count($questions))
                            <button type="button" class="btn btn-primary next-button">Selanjutnya</button>
                        @else
                            <div></div>
                        @endif
                    </div>
                </div>
            @endforeach

            <div class="btn-submit-wrapper">
                <button type="submit" class="btn btn-submit w-100">Kirim Jawaban</button>
            </div>
        </form>

        {{-- Tombol navigasi soal --}}
        <div class="nav-buttons">
            @foreach ($questions as $i => $btnQ)
                <button type="button" class="jump-btn {{ isset($savedResponses[$btnQ->id]) ? 'answered' : '' }}"
                    data-index="{{ $i }}">
                    {{ $i + 1 }}
                </button>
            @endforeach
        </div>
    </div>

    <!-- Modal -->
    <div id="modal" class="modal">
        <div class="modal-content">
            <h4 class="mb-3">Perhatian</h4>
            <p>Harap jawab semua soal terlebih dahulu sebelum mengirimkan.</p>
            <p id="unanswered" class="text-danger fw-bold"></p>
            <button class="modal-button mt-3" id="closeModal">Tutup</button>
        </div>
    </div>
@endsection
