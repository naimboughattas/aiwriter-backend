<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    protected $hidden = ['pivot'];

    /**
     * Get the user that owns the favorite.
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}