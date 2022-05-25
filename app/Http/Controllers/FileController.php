<?php

namespace App\Http\Controllers;

use FFMpeg\FFMpeg;
use FFMpeg\FFProbe;
use FFMpeg\Format\Audio\Mp3;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
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

    public function showConvertForm(Media $file)
    {
        return inertia('files/convert', compact('file'));
    }

    public function convert(Request $request, Media $file)
    {
        $format = new Mp3();
        $ext = 'mp3';

        switch ($request->preset) {
            case 'mp3-320kbps':
                $format->setAudioKiloBitrate('320');
                break;
            case 'mp3-256kbps':
                $format->setAudioKiloBitrate('256');
                break;
            case 'mp3-192kbps':
                $format->setAudioKiloBitrate('192');
                break;
            default:
                return back()
                    ->withInput()
                    ->withErrors(['preset' => ['Invalid preset']]);
        }

        $outputFilePath = storage_path('app/temp/' . $file->file_name . '.' . $ext);

        $ffmpeg = FFmpeg::create([
            'ffmpeg.binaries' => config('services.ffmpeg.ffmpeg_path'),
            'ffprobe.binaries' => config('services.ffmpeg.ffprobe_path'),
        ]);

        $og_file = $ffmpeg->open($file->getPath());
        File::exists($outputFilePath) ? File::delete($outputFilePath) : null;
        $og_file->filters()->resample('44100');

        try {
            $og_file->save($format, $outputFilePath);
        } catch (\Throwable $th) {
            return back()
                ->withInput()
                ->withErrors(['preset' => ['FFmpeg error: ' . $th->getMessage()]]);
        }

        $song = $file->model;

        $media = $song
            ->addMediaFromDisk('temp/' . $file->file_name . '.' . $ext)
            ->withCustomProperties(['source' => 'converted', 'og_file_id' => $file->id])
            ->toMediaCollection('medias');

        $probe = FFProbe::create([
            'ffmpeg.binaries' => config('services.ffmpeg.ffmpeg_path'),
            'ffprobe.binaries' => config('services.ffmpeg.ffprobe_path'),
        ])
            ->streams($media->getPath())
            ->audios()
            ->first();

        foreach ([
            'codec_name',
            'sample_rate',
            'channels',
            'duration',
            'bit_rate',
            'bits_per_raw_sample',
            'bits_per_sample',
        ] as $property) {
            $media->setCustomProperty($property, $probe->get($property));
        }

        $media->save();

        return redirect()->route('songs.show', $song);
    }
}
