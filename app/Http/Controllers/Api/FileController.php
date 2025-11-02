<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class FileController extends Controller
{
   
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:4048', // max 2MB
        ]);

        $path = $request->file('file')->store('uploads', 'public');

        return response()->json([
            'message' => 'File uploaded successfully',
            'path' => $path,
            'url' => Storage::url($path),
        ]);
    }

    // 2️ List all files in 'uploads'
    public function listFiles()
    {
        $files = Storage::disk('public')->files('uploads');
        return response()->json($files);
    }

    // 3️ Download a file
    public function download($filename)
    {
        if (!Storage::disk('public')->exists('uploads/' . $filename)) {
            return response()->json(['error' => 'File not found'], 404);
        }

        return Storage::disk('public')->download('uploads/' . $filename);
    }

    // 4️⃣ Temporary URL (S3 or signed URL)
    public function temporaryUrl($filename)
    {
        if (!Storage::disk('public')->exists('uploads/' . $filename)) {
            return response()->json(['error' => 'File not found'], 404);
        }

        $url = Storage::disk('public')->temporaryUrl('uploads/' . $filename);

        return response()->json(['temporary_url' => $url]);
    }

    // 5️ Move a file
    public function moveFile($filename)
    {
        $oldPath = 'uploads/' . $filename;
        $newPath = 'archives/' . $filename;

        if (!Storage::disk('public')->exists($oldPath)) {
            return response()->json(['error' => 'File not found'], 404);
        }

        Storage::disk('public')->move($oldPath, $newPath);

        return response()->json(['message' => 'File moved', 'new_path' => $newPath]);
    }

    // 6️ Copy a file
    public function copyFile($filename)
    {
        $source = 'uploads/' . $filename;
        $destination = 'uploads/copy-' . $filename;

        if (!Storage::disk('public')->exists($source)) {
            return response()->json(['error' => 'File not found'], 404);
        }

        Storage::disk('public')->copy($source, $destination);

        return response()->json(['message' => 'File copied', 'copy_path' => $destination]);
    }

    // 7️ Delete a file
    public function deleteFile($filename)
    {
        $path = 'uploads/' . $filename;

        if (!Storage::disk('public')->exists($path)) {
            return response()->json(['error' => 'File not found'], 404);
        }

        Storage::disk('public')->delete($path);

        return response()->json(['message' => 'File deleted']);
    }
}
