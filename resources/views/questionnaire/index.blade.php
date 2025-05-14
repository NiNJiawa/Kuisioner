@extends('layouts.app')

@section('content')
    <style>
        :root {
            --primary: #6a11cb;
            --primary-dark: #2575fc;
            --success: #00c896;
            --danger: #ff4d4f;
            --light-bg: #f1f3f5;
        }

        .questionnaire-wrapper {
            max-width: 750px;
            margin: 3rem auto;
            text-align: center;
        }

        .question-card {
            background: #ffffff;
            border-radius: 1rem;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            padding: 2rem;
            margin-bottom: 2rem;
            display: none;
        }

        .question-card.active {
            display: block;
            animation: fadeIn 0.3s ease-in-out;
        }

        .form-check-input[type="radio"] {
            width: 2.2rem;
            height: 2.2rem;
            margin: 0.5rem;
            border: 2px solid #ccc;
            transition: 0.3s ease;
            cursor: pointer;
        }

        .form-check-input[type="radio"]:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .option-label {
            font-size: 0.9rem;
            display: block;
            margin-top: 0.3rem;
        }

        .instruction-box {
            background: var(--light-bg);
            border-left: 5px solid var(--primary);
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 2rem;
            text-align: left;
        }

        .btn-nav {
            margin-top: 2rem;
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
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
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .nav-buttons button.active {
            background: linear-gradient(to right, var(--primary), var(--primary-dark));
            color: white;
        }

        .nav-buttons button.answered {
            background-color: var(--success);
            color: white;
        }

        .nav-buttons button:hover {
            background-color: var(--primary-dark);
            color: white;
        }

        .btn-submit {
            background: linear-gradient(to right, var(--primary), var(--primary-dark));
            border: none;
            padding: 0.8rem 1rem;
            color: #fff;
            font-size: 1.1rem;
            border-radius: 0.6rem;
            width: 100%;
            transition: 0.3s ease;
        }

        .btn-submit:hover {
            opacity: 0.9;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 999;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background-color: #fff;
            padding: 2rem;
            border-radius: 1rem;
            width: 400px;
            max-width: 90%;
            text-align: center;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            animation: slideIn 0.3s ease;
        }

        .modal-header {
            font-weight: bold;
            font-size: 1.3rem;
            margin-bottom: 1rem;
            color: var(--danger);
        }

        .modal-footer {
            margin-top: 1.5rem;
        }

        .modal-button {
            background-color: var(--danger);
            color: white;
            padding: 0.6rem 1.5rem;
            border: none;
            border-radius: 0.5rem;
            cursor: pointer;
            font-size: 1rem;
            transition: 0.3s;
        }

        .modal-button:hover {
            opacity: 0.85;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideIn {
            from {
                transform: scale(0.95);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }
    </style>

    <div class="questionnaire-wrapper">
        <h2 class="fw-bold mb-4"><span class="text-primary">Passion Domain Inventory</span></h2>

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

    <script>
        const cards = document.querySelectorAll('.question-card');
        const nextButtons = document.querySelectorAll('.next-button');
        const prevButtons = document.querySelectorAll('.prev-button');
        const jumpButtons = document.querySelectorAll('.jump-btn');
        const radios = document.querySelectorAll('input[type="radio"]');
        const modal = document.getElementById('modal');
        const closeModalButton = document.getElementById('closeModal');
        const unansweredElement = document.getElementById('unanswered');
        let currentIndex = 0;

        function showCard(index) {
            cards.forEach((card) => card.classList.remove('active'));
            cards[index].classList.add('active');

            jumpButtons.forEach((btn, i) => {
                btn.classList.remove('active');
                if (i === index) {
                    btn.classList.add('active');
                }
            });

            currentIndex = index;
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        function markAnswered(questionIndex) {
            const btn = document.querySelector(`.jump-btn[data-index='${questionIndex}']`);
            if (btn && !btn.classList.contains('answered')) {
                btn.classList.add('answered');
            }
        }

        nextButtons.forEach((btn, idx) => {
            btn.addEventListener('click', () => showCard(idx + 1));
        });

        prevButtons.forEach((btn, idx) => {
            btn.addEventListener('click', () => showCard(idx));
        });

        jumpButtons.forEach((btn) => {
            btn.addEventListener('click', () => showCard(parseInt(btn.getAttribute('data-index'))));
        });

        radios.forEach((radio) => {
            radio.addEventListener('change', () => {
                const parentCard = radio.closest('.question-card');
                const index = parseInt(parentCard.id.split('-')[1]);
                markAnswered(index);
            });
        });

        const form = document.getElementById('questionnaireForm');
        form.addEventListener('submit', function(event) {
            const unansweredQuestions = [];
            cards.forEach((card, index) => {
                const radios = card.querySelectorAll('input[type="radio"]');
                const isAnswered = Array.from(radios).some(r => r.checked);
                if (!isAnswered) {
                    unansweredQuestions.push(index + 1);
                }
            });

            if (unansweredQuestions.length > 0) {
                event.preventDefault();
                unansweredElement.textContent = 'Nomor soal yang belum dijawab: ' + unansweredQuestions.join(', ');
                modal.style.display = 'flex';
            }
        });

        closeModalButton.addEventListener('click', () => {
            modal.style.display = 'none';
        });

        showCard(0);
    </script>
@endsection
