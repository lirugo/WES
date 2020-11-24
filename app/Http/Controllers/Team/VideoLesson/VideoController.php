<?php

namespace App\Http\Controllers\Team\VideoLesson;

use App\Http\Controllers\Controller;
use App\Utils\VideoStream;
use Auth;
use Response;

class VideoController extends Controller
{
    public function streamVideo($fileName) {
        $path = storage_path('app/public/'.$fileName);
        $stream = new VideoStream($path);
        $stream->start();
    }
}
