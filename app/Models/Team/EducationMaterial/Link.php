<?php

namespace App\Models\Team\EducationMaterial;

use Cohensive\Embed\Facades\Embed;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $table = 'team_education_material_link';
    protected $guarded = ['id'];
}
