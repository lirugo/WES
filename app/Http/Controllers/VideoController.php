<?php

namespace App\Http\Controllers;

use App\Utils\VideoStream;
use Auth;
use Response;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    public function streamVideo() {
        $fileName = 'test.mp4';
        $path = storage_path('app/public/'.$fileName);
        $stream = new VideoStream($path);
        $stream->start();
    }
}
