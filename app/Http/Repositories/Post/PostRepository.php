<?php

namespace App\Http\Repositories\Post;

use App\Http\Repositories\BaseRepositoryInterface;
use App\Http\Repositories\SyncRepositoryInterface;
use App\Models\Post;
use App\Models\Language;
use App\Models\PostTranslation;

class PostRepository implements BaseRepositoryInterface, SyncRepositoryInterface
{
    protected $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function list(array $params = null)
    {
        return $this->post::query()
            ->orderByDesc('id')
            ->with(['postTranslation', 'tags'])
            ->paginate();
    }

    function findById(string $id): Post|null
    {
        return $this->post::findOrFail($id);
    }

    function create(array $attributes): Post|null
    {
        $postTranslation = (new PostTranslation($attributes))
            ->language()
            ->associate(Language::where('locale', app()->getLocale())->firstOrFail());

        $post = $this->post->create();
        $post->postTranslation()->save($postTranslation);

        return $post->refresh();
    }

    function update(string $id, array $attributes): Post|null
    {
        $post = $this->post::findOrFail($id);

        $postTranslation = $post
            ->postTranslation()
            ->firstOrNew()
            ->fill($attributes)
            ->language()
            ->associate(Language::where('locale', app()->getLocale())->firstOrFail())
            ->post()
            ->associate($post);

        $postTranslation->save();

        return $post->refresh();
    }

    function deleteById(string $id): Bool
    {
        return $this->post::findOrFail($id)->delete();
    }

    function attach(string $postId, string $tagId): Post|null
    {
        $post = $this->post::findOrFail($postId);
        $post->tags()->syncWithoutDetaching([$tagId]);
        return $post->refresh();
    }

    function detach(string $postId, string $tagId): Post
    {
        $post = $this->post::findOrFail($postId);
        $post->tags()->detach($tagId);
        return $post->refresh();
    }
}
