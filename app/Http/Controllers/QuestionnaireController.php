<?php

namespace App\Http\Controllers;

use App\Models\Option;
use App\Models\Passion;
use App\Models\Question;
use App\Models\QuestionResponse;
use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionnaireController extends Controller
{
    public function index()
    {
        $questions = Question::with('passions')->get();
        $options = Option::all();
        return view('questionnaire.index', compact('questions', 'options'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        foreach ($request->input('responses') as $question_id => $option_id) {
            QuestionResponse::updateOrCreate(
                ['user_id' => $user->id, 'question_id' => $question_id],
                ['option_id' => $option_id]
            );
        }

        $this->calculateScores($user->id);

        return redirect()->route('questionnaire.result')->with('success', 'Jawaban berhasil disimpan.'); return redirect()->back()->with('submitted', true);
    }

    public function result()
    {
        $results = Result::with('passion')->where('user_id', Auth::id())->get();
        return view('questionnaire.result', compact('results'));
    }

    private function calculateScores($userId)
    {
        $passions = Passion::with('questions')->get();

        foreach ($passions as $passion) {
            $questionIds = $passion->questions->pluck('id')->toArray();

            $responses = QuestionResponse::where('user_id', $userId)
                ->whereIn('question_id', $questionIds)
                ->with('option')
                ->get();

            $rawScore = $responses->sum(function ($response) {
                return $response->option->score ?? 0;
            });

            $scaleScore = round(($rawScore / (count($questionIds) * 3)) * 6 + 1);

            Result::updateOrCreate(
                ['user_id' => $userId, 'passion_id' => $passion->id],
                ['raw_score' => $rawScore, 'scale_score' => $scaleScore]
            );
        }
    }
}
