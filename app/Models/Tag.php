<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name'];

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class);
    }

    public function tagTranslations(): HasMany
    {
        return $this->hasMany(TagTranslation::class);
    }

    public function tagTranslation(): HasOne
    {
        return $this->hasOne(TagTranslation::class)
            ->whereHas('language', function (Builder $q) {
                $q->where('locale', app()->getLocale());
            });
    }
}
