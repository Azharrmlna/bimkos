<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'created_by',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    // Automatically generate slug from title
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($article) {
            if (empty($article->slug)) {
                $article->slug = Str::slug($article->title);
                
                // Ensure unique slug
                $count = 1;
                while (static::where('slug', $article->slug)->exists()) {
                    $article->slug = Str::slug($article->title) . '-' . $count;
                    $count++;
                }
            }
        });

        static::updating(function ($article) {
            if ($article->isDirty('title')) {
                $article->slug = Str::slug($article->title);
                
                $count = 1;
                while (static::where('slug', $article->slug)->where('id', '!=', $article->id)->exists()) {
                    $article->slug = Str::slug($article->title) . '-' . $count;
                    $count++;
                }
            }
        });
    }

    // Relationships
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}