<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class FileController extends Controller
{
    public function store(Request $request)
    {
        // Validate the uploaded file
        $validatedData = $request->validate([
            'file' => 'required|file',
            'type' => 'required|in:' . implode(',', array_keys(config('file.types'))),
        ]);

        // Get the uploaded file
        $uploadedFile = $validatedData['file'];

        // Determine the file type
        $fileType = $validatedData['type'];

        // Retrieve the file configuration
        $fileConfig = config('file.types.' . $fileType);

        // Generate a unique file name
        $fileName = uniqid() . '_' . $uploadedFile->getClientOriginalName();

        // Determine the public storage path
        $storagePath = public_path($fileConfig['local_path']);

        // Move the file to the public storage directory
        $uploadedFile->move($storagePath, $fileName);

        // Create a new file record in the database
        $file = new File();
        $file->name = $uploadedFile->getClientOriginalName();
        $file->local_path = $fileConfig['local_path'] . '/' . $fileName;
        $file->type = $fileType;
        $file->save();

        // Return the response with the created file data
        return response()->json([
            'message' => 'File uploaded successfully',
            'data' => $file,
        ]);
    }
}
