<?php

namespace App\Models\Team\EducationMaterial;

use Cohensive\Embed\Facades\Embed;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $table = 'team_education_material_video';
    protected $guarded = ['id'];

    public function getVideoHtmlAttribute()
    {
        $embed = Embed::make($this->link)->parseUrl();

        if (!$embed)
            return '';

        $embed->setAttribute(['width' => 400]);
        return $embed->getHtml();
    }
}
