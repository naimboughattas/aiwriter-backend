<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'title',
        'icon',
        'order'
    ];

    /**
     * Get own tabs.
     */
    public function tabs()
    {
        return $this->hasMany(Tab::class, 'menu_id', 'id');
    }

    /**
     * Get the user that owns the menu.
     */

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }
}
