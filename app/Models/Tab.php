<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tab extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu_id',
        'parent_id',
        'droppable',
        'order',
        'title',
        'icon',
        'has_child'
    ];

    /**
     * Get the menu that owns the tab.
     */
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id', 'id');
    }

    /**
     * Get the parent tab that owns the tab.
     */
    public function parent()
    {
        return $this->belongsTo(Tab::class, 'parent_id', 'id');
    }

    /**
     * Get the child tabs for the tab.
     */
    public function children()
    {
        return $this->hasMany(Tab::class, 'parent_id', 'id');
    }

    /**
     * Get the prompts for the tab.
     */
    public function prompts()
    {
        return $this->belongsToMany(Prompt::class, 'tab_prompt', 'tab_id', 'prompt_id');
    }

}
