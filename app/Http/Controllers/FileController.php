<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class FileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function storeChunk(Request $request)
    {
        $append_to_file = storage_path('app/temp/' . $request->handle);
        [, $data] = explode(';base64,', $request->file_data);
        $data = base64_decode($data);
        file_put_contents($append_to_file, $data, FILE_APPEND);

        return response()->json(['success' => true]);
    }

    public function destroy(Request $request, Media $file)
    {
        $file->delete();

        return back();
    }
}
