@php
    use App\Models\QuestionResponse;
    $passions = \App\Models\Passion::with('questions')->get();

    $chartLabels = [];
    $chartData = [];

    // Persiapkan data chart dulu
    foreach ($passions as $passion) {
        $total = 0;
        foreach ($passion->questions as $question) {
            $response = QuestionResponse::with('option')
                ->where('user_id', $user->id)
                ->where('question_id', $question->id)
                ->first();
            $score = $response->option->score ?? 0;
            $total += is_numeric($score) ? $score : 0;
        }
        $chartLabels[] = $passion->name;
        $chartData[] = $total;
    }

    // Hitung max questions untuk tabel header
    $maxQuestions = $passions->max(fn($p) => $p->questions->count());
@endphp

<h4>Raw Score per Passion (Chart)</h4>
<canvas id="rawScoreChart" height="120" class="mb-4"></canvas>

<h4>Raw Score Detail (Tabel)</h4>
<table class="table table-bordered table-sm">
    <thead class="table-light">
        <tr>
            <th>Passion</th>
            @for ($i = 1; $i <= $maxQuestions; $i++)
                <th>Q{{ $i }}</th>
            @endfor
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($passions as $passion)
            <tr>
                <td>{{ $passion->name }}</td>
                @php
                    $total = 0;
                    $questions = $passion->questions;
                @endphp
                @foreach ($questions as $question)
                    @php
                        $response = QuestionResponse::with('option')
                            ->where('user_id', $user->id)
                            ->where('question_id', $question->id)
                            ->first();
                        $score = $response->option->score ?? '-';
                        $total += is_numeric($score) ? $score : 0;
                    @endphp
                    <td>{{ is_numeric($score) ? $score : '-' }}</td>
                @endforeach

                @for ($i = $questions->count(); $i < $maxQuestions; $i++)
                    <td>-</td>
                @endfor
                <td><strong>{{ $total }}</strong></td>
            </tr>
        @endforeach
    </tbody>
</table>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const rawCtx = document.getElementById('rawScoreChart').getContext('2d');

    const rawScoreChart = new Chart(rawCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [{
                label: 'Total',
                data: {!! json_encode($chartData) !!},
                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
                borderRadius: 4
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
</script>
@endpush
