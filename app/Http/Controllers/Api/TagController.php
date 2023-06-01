<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Tag\TagRepository;
use App\Http\Resources\TagResource;
use App\Http\Requests\Tag\UpdateTagRequest;
use App\Http\Requests\Tag\CreateTagRequest;
use Illuminate\Http\Request;

class TagController extends Controller
{

    private $tagRepository;

    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function index()
    {
        return TagResource::collection($this->tagRepository->list());
    }

    public function store(CreateTagRequest $request)
    {

        $tag = $this->tagRepository->create($request->all());
        return new TagResource($tag->load('tagTranslation', 'posts'));
    }

    public function show(Request $request)
    {
        $tag = $this->tagRepository->findById($request->tag);
        return new TagResource($tag->load('tagTranslation', 'posts'));
    }

    public function update(UpdateTagRequest $request)
    {

        $tag = $this->tagRepository->update($request->tag, $request->all());
        return new TagResource($tag->load('tagTranslation', 'posts'));
    }

    public function destroy(Request $request)
    {
        return $this->tagRepository->deleteById($request->tag);
    }

    public function attach(Request $request)
    {
        $tag = $this->tagRepository->attach($request->tag, $request->post);
        return new TagResource($tag->load('tagTranslation', 'posts'));
    }

    public function detach(Request $request)
    {
        $tag = $this->tagRepository->detach($request->tag, $request->post);
        return new TagResource($tag->load('tagTranslation', 'posts'));
    }

}
