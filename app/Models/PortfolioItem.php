<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PortfolioItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'thumbnail',
        'featured_image',
        'gallery',
        'category',
        'client',
        'completion_date',
        'project_url',
        'technologies',
        'is_featured',
        'order',
        'meta_data',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'gallery' => 'array',
        'technologies' => 'array',
        'meta_data' => 'array',
        'completion_date' => 'date',
        'is_featured' => 'boolean',
        'order' => 'integer',
    ];
}
