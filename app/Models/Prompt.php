<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prompt extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_id',
        'title',
        'content',
        'icon',
        'order'
    ];

    /**
     * Get the tabs for the prompt.
     */
    public function tabs()
    {
        return $this->belongsToMany(Tab::class, 'tab_prompt', 'prompt_id', 'tab_id');
    }

    /**
     * Get the user that owns the prompt.
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }

    /**
     * Get the responses for the prompt.
     */
    public function responses()
    {
        return $this->hasMany(Response::class);
    }
}
