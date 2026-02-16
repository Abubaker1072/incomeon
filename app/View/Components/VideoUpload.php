<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class VideoUpload extends Component
{
    public $videoThumbnailId;
    public $localVideoId;

   
    /**
     * Create a new component instance.
     */
     public function __construct($videoThumbnailId = null, $localVideoId = null)
    {
        $this->videoThumbnailId = $videoThumbnailId;
        $this->localVideoId = $localVideoId;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.video-upload');
    }
}
