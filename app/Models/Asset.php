<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Asset extends Model
{
    protected $fillable = [
        'archive_item_id',
        'file_path',
        'original_filename',
        'mime_type',
        'extension',
        'size_bytes',
        'uploaded_at',
    ];

    protected $casts = [
        'uploaded_at' => 'datetime',
    ];

    public function archiveItem(): BelongsTo
    {
        return $this->belongsTo(ArchiveItem::class);
    }
}
