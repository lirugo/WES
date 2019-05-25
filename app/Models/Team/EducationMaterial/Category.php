<?php

namespace App\Models\Team\EducationMaterial;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'team_education_material_category';
    protected $guarded = ['id'];

    public function materials(){
        return $this->hasMany(EducationMaterial::class, 'category_id', 'id')
            ->where('team_id', $this->team_id)
            ->where('discipline_id', $this->discipline_id)
            ->orderBy('name')
            ->get();
    }
}
