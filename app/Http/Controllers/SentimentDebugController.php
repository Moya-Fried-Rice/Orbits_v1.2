<?php

namespace App\Http\Controllers;

use App\Livewire\ResultsSummary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SentimentDebugController extends Controller
{
    public function debug($uuid)
    {
        // Create a new ResultsSummary component without rendering it
        $component = new ResultsSummary($uuid);
        
        // Mount it to initialize data
        $component->mount($uuid);
        
        // Get the data we want to see
        $data = [
            'positiveCount' => $component->positiveCommentCount,
            'negativeCount' => $component->negativeCommentCount,
            'positiveComments' => $component->positiveCommentsForView,
            'negativeComments' => $component->negativeCommentsForView,
            'positiveAnalysis' => $component->positiveCommentAnalysis ?? [],
            'negativeAnalysis' => $component->negativeCommentAnalysis ?? [],
        ];
        
        // Return as JSON for easy debugging
        return response()->json($data);
    }
}
