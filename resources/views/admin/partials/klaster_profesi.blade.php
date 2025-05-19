@extends('layouts.admin')

@php
    $klasters = [
        [
            'nama' => 'Visionary Strategists',
            'deskripsi' =>
                'Pemikir perencanaan jangka panjang, penganalisis yang mendalam, dan perancang solusi inovatif berbasis pola dan data.',
            'kode' => ['IF', 'MI'],
            'rumus' => 'x 0.35',
        ],
        [
            'nama' => 'Human Connectors',
            'deskripsi' =>
                'Pembangun hubungan antar manusia, kepedulian, dan menjalankan peran sosial atau pengembangan orang lain.',
            'kode' => ['MI', 'SE'],
            'rumus' => 'x 0.35',
        ],
        [
            'nama' => 'Purposeful Believers',
            'deskripsi' => 'Pengembang kesadaran nilai, integritas, dan misi hidup yang bermakna di masyarakat.',
            'kode' => ['MI', 'SD'],
            'rumus' => 'x 0.35',
        ],
        [
            'nama' => 'Creative Crafters',
            'deskripsi' =>
                'Seniman modern yang menyatukan ekspresi personal dan pesan sosial dalam karya visual, verbal, atau performatif.',
            'kode' => ['CC', 'SA'],
            'rumus' => 'x 0.35',
        ],
        [
            'nama' => 'Impact Architects',
            'deskripsi' => 'Pembangun sistem/program/organisasi berdampak luas yang efisien dan berkelanjutan.',
            'kode' => ['MI', 'PD'],
            'rumus' => 'x 0.35',
        ],
        [
            'nama' => 'Organized Executors',
            'deskripsi' => 'Pengelola detail, sistem, dan timeline agar rencana berjalan stabil dan konsisten.',
            'kode' => ['SB'],
            'rumus' => 'x 0.35',
        ],
        [
            'nama' => 'Empowerment Catalysts',
            'deskripsi' => 'Penggerak perubahan sosial, dan pembangkit semangat serta aksi kolektif di masyarakat.',
            'kode' => ['SE'],
            'rumus' => 'x 0.35',
        ],
        [
            'nama' => 'Adaptive Innovators',
            'deskripsi' => 'Pencari solusi baru dari konteks yang terus berubah, baik di bidang teknologi atau sosial.',
            'kode' => ['IF', 'SE'],
            'rumus' => 'x 0.35',
        ],
        [
            'nama' => 'Analytical Builders',
            'deskripsi' => 'Penganalisis data dan informasi untuk menyusun sistem atau kebijakan yang berdampak luas.',
            'kode' => ['PL', 'SC'],
            'rumus' => 'x 0.35',
        ],
        [
            'nama' => 'Learning Guides',
            'deskripsi' => 'Pembimbing yang berorientasi pada pertumbuhan individu melalui proses belajar.',
            'kode' => ['EL', 'EG'],
            'rumus' => 'x 0.35',
        ],
        [
            'nama' => 'Visionary Architects',
            'deskripsi' => 'Perancang masa depan yang imajinatif dan strategis.',
            'kode' => ['SC', 'IF'],
            'rumus' => 'x 0.35',
        ],
        [
            'nama' => 'Empathic Connectors',
            'deskripsi' => 'Pembangun relasi di bidang pelayanan dan penyembuhan.',
            'kode' => ['SE', 'HL'],
            'rumus' => 'x 0.35',
        ],
        [
            'nama' => 'Strategic Organizers',
            'deskripsi' => 'Penterjemah visi besar ke rencana konkret, lalu mengeksekusinya dengan presisi tinggi.',
            'kode' => ['PL', 'SB'],
            'rumus' => 'x 0.35',
        ],
        [
            'nama' => 'Impactful Storytellers',
            'deskripsi' => 'Inspirator lewat narasi, visual, dan media.',
            'kode' => ['CC', 'SA'],
            'rumus' => 'x 0.35',
        ],
        [
            'nama' => 'Cultural Curators',
            'deskripsi' => 'Perawat nilai, tradisi, dan ekspresi budaya yang relevan.',
            'kode' => ['HC', 'EL'],
            'rumus' => 'x 0.35',
        ],
        [
            'nama' => 'Digital Strategists',
            'deskripsi' => 'Pemikir digital yang menggabungkan data, algoritma, dan kreativitas.',
            'kode' => ['IF', 'MI'],
            'rumus' => 'x 0.35',
        ],
        [
            'nama' => 'Purpose-Driven Builders',
            'deskripsi' => 'Pencipta solusi nyata yang berdampak sosial positif.',
            'kode' => ['MI', 'SP'],
            'rumus' => 'x 0.35',
        ],
        [
            'nama' => 'Insightful Analysts',
            'deskripsi' => 'Pengamat tajam yang menyampaikan insight strategis.',
            'kode' => ['IX', 'PK'],
            'rumus' => 'x 0.35',
        ],
        [
            'nama' => 'Network Catalysts',
            'deskripsi' => 'Ahli jejaring dan kolaborasi lintas bidang.',
            'kode' => ['CT', 'IX'],
            'rumus' => 'x 0.35',
        ],
        [
            'nama' => 'Adaptive Trailblazers',
            'deskripsi' => 'Inovator yang menciptakan jalan baru di tengah ketidakpastian.',
            'kode' => ['IX', 'XL'],
            'rumus' => 'x 0.35',
        ],
    ];

    // Ambil hasil user berdasarkan passion code, indexed by kode passion
    $userResults = \App\Models\Result::with('passion')
        ->where('user_id', $user->id)
        ->get()
        ->keyBy(fn($r) => $r->passion->code);

    // Siapkan array untuk chart
    $chartLabels = [];
    $chartData = [];

    // Hitung nilai tiap klaster sesuai rumus bobot dan data raw_score
    foreach ($klasters as $klaster) {
        $total = 0;
        foreach ($klaster['kode'] as $kode) {
            $score = $userResults[$kode]->raw_score ?? 0;
            $total += str_contains($klaster['rumus'], '0.35') ? $score * 0.35 : $score;
        }
        $chartLabels[] = $klaster['nama'];
        $chartData[] = round($total, 2);
    }
@endphp

<div class="klaster-profesi-section">
    <h5 class="mb-3">Visualisasi Klaster Profesi (Chart)</h5>
    <canvas id="klasterChart" height="120" class="mb-4"></canvas>

    <h5>Detail Perhitungan Klaster Profesi</h5>
    <table class="table table-bordered table-striped table-sm">
        <thead class="table-light">
            <tr>
                <th>Klaster Profesi</th>
                <th>Domain Passion (Kode)</th>
                <th>Nilai</th>
            </tr>
        </thead>
        <tbody>
            @foreach($klasters as $klaster)
            @php
                $total = 0;
                foreach ($klaster['kode'] as $kode) {
                    $score = $userResults[$kode]->raw_score ?? 0;
                    $total += str_contains($klaster['rumus'], '0.35') ? $score * 0.35 : $score;
                }
            @endphp
            <tr>
                <td><strong>{{ $klaster['nama'] }}</strong><br><small>{{ $klaster['deskripsi'] }}</small></td>
                <td>{{ implode(' + ', $klaster['kode']) }}</td>
                <td class="text-center">{{ number_format($total, 2) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('klasterChart').getContext('2d');
        const klasterChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [{
                    label: 'Nilai',
                    data: {!! json_encode($chartData) !!},
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true
                    },
                    tooltip: {
                        enabled: true
                    }
                }
            }
        });
    </script>
@endpush
