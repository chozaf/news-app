<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Post\PostRepository;
use App\Http\Resources\PostResource;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Http\Requests\Post\CreatePostRequest;
use Illuminate\Http\Request;

class PostController extends Controller
{

    private $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function index()
    {
        return PostResource::collection($this->postRepository->list());
    }

    public function store(CreatePostRequest $request)
    {
        $post = $this->postRepository->create($request->all());
        return new PostResource($post->load('postTranslation', 'tags'));
    }

    public function show(Request $request)
    {
        $post = $this->postRepository->findById($request->post);
        return new PostResource($post->load('postTranslation', 'tags'));
    }

    public function update(UpdatePostRequest $request)
    {

       // dd($request->all());
        $post = $this->postRepository->update($request->post, $request->all());
        return new PostResource($post->load('postTranslation', 'tags'));
    }

    public function destroy(Request $request)
    {
        return $this->postRepository->deleteById($request->post);
    }

    public function attach(Request $request)
    {
        $post = $this->postRepository->attach($request->post, $request->tag);
        return new PostResource($post->load('postTranslation', 'tags'));
    }

    public function detach(Request $request)
    {
        $post = $this->postRepository->detach($request->post, $request->tag);
        return new PostResource($post->load('postTranslation', 'tags'));
    }
}
