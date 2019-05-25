<?php

namespace App\Models\Team\EducationMaterial;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'team_education_material_category';
    protected $guarded = ['id'];

    public function materials(){
        return $this->hasMany(EducationMaterial::class, 'category_id', 'id')
            ->where('team_id', $this->team_id)
            ->where('discipline_id', $this->discipline_id)
            ->orderBy('name');
    }

    public function getMaterials(){
        $materials = $this->materials()->where('public_date', '<=', Carbon::now());

        if(Auth()->user()->hasRole('student'))
            $materials = $materials->where('type', 'public')->get();
        else
            $materials = $materials->get();

        return $materials;
    }

    public function getAllMaterials(){
        return $this->materials()->get();
    }
}
