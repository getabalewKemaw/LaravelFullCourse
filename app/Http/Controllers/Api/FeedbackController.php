<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class FeedbackController extends Controller
{
    private $feedbacks = [
        ['id' => 1, 'name' => 'Getabalew', 'message' => 'Laravel is amazing!'],
        ['id' => 2, 'name' => 'Sara', 'message' => 'Loving this API!'],
    ];

    // ✅ 1. JSON Response
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'feedbacks' => $this->feedbacks
        ], 200);
    }

    // ✅ 2. Create Feedback
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'message' => 'required|string'
        ]);

        // Imagine saving to DB...
        $data['id'] = count($this->feedbacks) + 1;
        $this->feedbacks[] = $data;

        return response()->json([
            'message' => 'Feedback stored successfully!',
            'data' => $data
        ], Response::HTTP_CREATED);
    }

    // ✅ 3. Show Feedback (with header + cookie)
    public function show($id)
    {
        $feedback = collect($this->feedbacks)->firstWhere('id', (int) $id);

        if (!$feedback) {
            return response()->json([
                'error' => 'Feedback not found'
            ], Response::HTTP_NOT_FOUND);
        }

        return response($feedback, 200)
            ->header('X-Feedback-Source', 'SmartFeedbackAPI')
            ->cookie('feedback_viewed', $id, 2);
    }

    // ✅ 4. Download Feedback File
    public function download($id)
    {
        // Try to get feedback
        $feedback = collect($this->feedbacks)->firstWhere('id', (int) $id);
        if (!$feedback) {
            return response()->json(['error' => 'Feedback not found'], 404);
        }

        // Create folder if it doesn’t exist
        $directory = storage_path('app/public');
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }

        // File path
        $filePath = $directory . "/feedback_{$id}.txt";

        // File content
        $content = "=== FEEDBACK #{$feedback['id']} ===\n"
            . "Name: {$feedback['name']}\n"
            . "Message: {$feedback['message']}\n\nThank you for your response!";

        // Save file
        file_put_contents($filePath, $content);

        // Return as downloadable file
        return response()->download($filePath, "feedback_{$id}.txt")->deleteFileAfterSend(false);
    }

    // ✅ 5. Stream Report File
    public function report()
    {
        // Generate dynamic report content
        $report = "=== FEEDBACK REPORT ===\n\n";
        foreach ($this->feedbacks as $f) {
            $report .= "{$f['id']}. {$f['name']} - {$f['message']}\n";
        }

        // Stream the response — no file needed
        return response()->streamDownload(function () use ($report) {
            echo $report;
        }, 'feedback_report.txt');
    }

    // ✅ 6. Redirect Example
    public function redirectDemo()
    {
        // Redirect to an external site
        return redirect()->away('https://laravel.com')->withHeaders([
            'X-Redirect-Reason' => 'Learning Laravel Responses'
        ]);
    }
}
