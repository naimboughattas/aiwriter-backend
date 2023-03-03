<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    use HasFactory;

    protected $fillable = [
        'prompt_id',
        'content'
    ];

    /**
     * Get the prompt that owns the response.
     */
    public function prompt()
    {
        return $this->belongsTo(Prompt::class, 'prompt_id', 'id');
    }
}
