<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Milestone extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'order',
    ];

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
}
