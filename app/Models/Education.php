<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasTranslations;

    protected $table = 'educations';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'is_current' => 'boolean',
            'title' => 'array',
            'summary' => 'array',
        ];
    }
}
