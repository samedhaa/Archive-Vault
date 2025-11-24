<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ArchiveItem extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'category',
        'captured_at',
        'uploaded_at',
        'location',
    ];

    protected $casts = [
        'captured_at' => 'datetime',
        'uploaded_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function assets(): HasMany
    {
        return $this->hasMany(Asset::class);
    }
}
