<?php

namespace App\Http\Repositories\Tag;

use App\Http\Repositories\BaseRepositoryInterface;
use App\Http\Repositories\SyncRepositoryInterface;
use App\Models\Tag;
use App\Models\Language;
use App\Models\TagTranslation;

class TagRepository implements BaseRepositoryInterface, SyncRepositoryInterface
{
    protected $tag;

    public function __construct(Tag $tag)
    {
        $this->tag = $tag;
    }

    public function list(array $params = null)
    {
        return $this->tag::query()->with(['tagTranslation', 'posts'])->paginate();
    }

    function findById(string $id): Tag|null
    {
        return $this->tag::findOrFail($id);
    }

    function create(array $attributes): Tag|null
    {

        $tagTranslation = (new TagTranslation())
            ->fill($attributes)
            ->language()
            ->associate(Language::where('locale', app()->getLocale())->firstOrFail());

        $tag = $this->tag->create($attributes);

        $tag->tagTranslation()->save($tagTranslation);

        return $tag->refresh();
    }

    function update(string $id, array $attributes): Tag|null
    {

        $tag = $this->tag::findOrFail($id);
        $tag->fill($attributes);
        $tag->save();

        $tagTranslation = $tag->tagTranslation()->firstOrNew();
        $tagTranslation->fill($attributes);
        $tagTranslation->language()->associate(Language::where('locale', app()->getLocale())->firstOrFail());
        $tagTranslation->tag()->associate($tag);
        $tagTranslation->save();

        return $tag->refresh();
    }

    function deleteById(string $id): Bool
    {
        return $this->tag::findOrFail($id)->delete();
    }

    function attach(string $tagId, string $postId): Tag
    {

        $tag = $this->tag::findOrFail($tagId);
        $tag->posts()->syncWithoutDetaching([$postId]);
        return $tag->refresh();
    }

    function detach(string $tagId, string $postId): Tag|null
    {
        $tag = $this->tag::findOrFail($tagId);
        $tag->posts()->detach($postId);
        return $tag->refresh();
    }
}
