<?php

namespace Knowfox\Http\Controllers;

use Illuminate\Http\Request;
use Knowfox\Models\Concept;
use Knowfox\Http\Resources\Concept as ConceptResource;
use Knowfox\Repositories\ConceptRepository;

class ApiController extends Controller
{
    protected $conceptRepository;

    public function __construct(Request $request, ConceptRepository $conceptRepository)
    {
        $this->setAuthMiddleware($request);
        $this->conceptRepository = $conceptRepository;
    }

    public function show(Concept $concept, Request $request)
    {
        $this->authorize('view', $concept);
        $concept->load('related', 'inverseRelated', 'tagged', 'shares');

        $children = $concept->children();
        if (!empty($this->config->sort)) {
            switch ($this->config->sort) {
                case 'alpha':
                    $children->orderBy('title', 'asc');
                    break;
                case 'created':
                    $children->orderBy('created_at', 'desc');
                    break;
                default:
                    $children->defaultOrder();
            }
        }

        if ($request->has('tag')) {
            $children->withAllTags([$request->input('tag')]);
        }

        if ($request->has('q')) {
            $search_term = $request->input('q');
            $this->conceptRepository->withFullTextSearchFragment($children, $search_term);
        }

        return response([
            'concept' => new ConceptResource($concept),
            'children' => ConceptResource::collection($children->paginate()),
            ])
            ->header('Access-Control-Allow-Origin', 'authorization');
    }
}
