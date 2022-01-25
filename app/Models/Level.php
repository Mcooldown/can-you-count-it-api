<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;
    protected $table = 'levels';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function scores()
    {
        return $this->hasMany(Score::class, 'level_id');
    }
}
