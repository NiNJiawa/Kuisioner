@extends('layouts.app')

@section('content')
<style>
    .questionnaire-wrapper {
        max-width: 750px;
        margin: 3rem auto;
        text-align: center;
    }

    .question-card {
        background: #fff;
        border-radius: 1rem;
        box-shadow: 0 0 15px rgba(0,0,0,0.05);
        padding: 2rem;
        display: none;
    }

    .question-card.active {
        display: block;
    }

    .form-check-input[type="radio"] {
        width: 2.4rem;
        height: 2.4rem;
        margin: 0.5rem;
        border: 2px solid #ccc;
        transition: 0.3s ease;
    }

    .form-check-input[type="radio"]:checked {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }

    .option-label {
        font-size: 0.9rem;
        display: block;
        margin-top: 0.3rem;
    }

    .instruction-box {
        background: #f8f9fa;
        border-left: 5px solid #0d6efd;
        padding: 1rem;
        border-radius: 0.5rem;
        margin-bottom: 2rem;
        text-align: left;
    }

    .btn-nav {
        margin-top: 2rem;
        display: flex;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .nav-buttons {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-top: 2rem;
    }

    .nav-buttons button {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: none;
        background-color: #e0e0e0;
        font-weight: bold;
        color: #333;
        transition: 0.2s;
    }

    .nav-buttons button.active {
        background-color: #0d6efd;
        color: white;
    }

    .nav-buttons button:hover {
        background-color: #0b5ed7;
        color: white;
    }
</style>

<div class="questionnaire-wrapper">
    <h2 class="fw-bold mb-4"><span class="text-primary">Passion Domain Inventory</span></h2>

    <div class="instruction-box">
        <strong>Petunjuk:</strong> Bacalah setiap pernyataan dengan seksama dan pilih salah satu: <strong>TS</strong> (Tak Sesuai), <strong>SdS</strong> (Sedikit Sesuai), <strong>CS</strong> (Cukup Sesuai), <strong>SS</strong> (Sangat Sesuai).
    </div>

    <form action="{{ route('questionnaire.store') }}" method="POST" id="questionnaireForm">
        @csrf

        @foreach($questions as $index => $q)
            <div class="question-card {{ $index === 0 ? 'active' : '' }}" id="question-{{ $index }}">
                <h5 class="mb-4"><strong>{{ $index + 1 }}.</strong> {{ $q->statement }}</h5>

                <div class="d-flex justify-content-center flex-wrap gap-4">
                    @foreach($options as $a)
                        <div class="text-center">
                            <input class="form-check-input" type="radio"
                                   name="responses[{{ $q->id }}]"
                                   value="{{ $a->id }}"
                                   id="q{{ $q->id }}a{{ $a->id }}"
                                   required>
                            <label class="option-label" for="q{{ $q->id }}a{{ $a->id }}">{{ $a->label }}</label>
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
                        <button type="submit" class="btn btn-success">Kirim Jawaban</button>
                    @endif
                </div>

                <!-- 🔢 Navigasi nomor soal (diletakkan di bawah tiap card) -->
                <div class="nav-buttons">
                    @foreach($questions as $i => $btnQ)
                        <button type="button" class="jump-btn" data-index="{{ $i }}">{{ $i + 1 }}</button>
                    @endforeach
                </div>
            </div>
        @endforeach
    </form>
</div>

<script>
    const cards = document.querySelectorAll('.question-card');
    const nextButtons = document.querySelectorAll('.next-button');
    const prevButtons = document.querySelectorAll('.prev-button');
    const jumpButtons = document.querySelectorAll('.jump-btn');

    let currentIndex = 0;

    function showCard(index) {
        cards.forEach((card, i) => {
            card.classList.remove('active');
            const jumpBtns = card.querySelectorAll('.jump-btn');
            jumpBtns.forEach(btn => btn.classList.remove('active'));
        });

        cards[index].classList.add('active');
        const activeBtns = cards[index].querySelectorAll('.jump-btn');
        activeBtns.forEach(btn => {
            if (parseInt(btn.getAttribute('data-index')) === index) {
                btn.classList.add('active');
            }
        });

        currentIndex = index;
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    nextButtons.forEach((btn, idx) => {
        btn.addEventListener('click', () => {
            const radios = cards[idx].querySelectorAll('input[type="radio"]');
            const isChecked = Array.from(radios).some(r => r.checked);

            if (!isChecked) {
                alert('Silakan pilih salah satu jawaban terlebih dahulu!');
                return;
            }

            showCard(idx + 1);
        });
    });

    prevButtons.forEach((btn, idx) => {
        btn.addEventListener('click', () => {
            showCard(idx);
        });
    });

    jumpButtons.forEach((btn) => {
        btn.addEventListener('click', () => {
            showCard(parseInt(btn.getAttribute('data-index')));
        });
    });

    showCard(0); // default
</script>
@endsection
