<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory,SoftDeletes;

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function postTranslations(): HasMany
    {
        return $this->hasMany(PostTranslation::class);
    }

    public function postTranslation(): HasOne
    {
        return $this->hasOne(PostTranslation::class)
            ->whereHas('language', function (Builder $q) {
                $q->where('locale', app()->getLocale());
            });
    }



}
