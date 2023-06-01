<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Tag;

class TagTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['title'];

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }

    public function tag(): BelongsTo
    {
        return $this->belongsTo(Tag::class);
    }
}
