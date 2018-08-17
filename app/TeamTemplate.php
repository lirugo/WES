<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamTemplate extends Model
{
    protected $table = 'teams_templates';

    protected $guarded = ['id'];

    /**
     * Relationship to discipline list
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function disciplines(){
        return $this->hasMany(TeamTemplateDiscipline::class, 'template_id', 'id');
    }
}
