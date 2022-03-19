<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserItem extends Model
{
    use HasFactory;
    protected $table = 'user_items';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function user()
    {
        $this->belongsTo(User::class, 'user_id');
    }

    public function item()
    {
        $this->belongsTo(Item::class, 'item_id');
    }
}
