<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetFeedsRequest;
use App\Services\FeedService;
use App\Transformers\FeedTransformer;
use Illuminate\Http\JsonResponse;
use JetBrains\PhpStorm\Pure;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Serializer\JsonApiSerializer;

class FeedController extends Controller
{
    protected FeedService $service;
    protected FeedTransformer $feedTransformer;

    #[Pure] public function __construct(FeedTransformer $feedTransformer)
    {
        $this->service = new FeedService();
        $this->feedTransformer = $feedTransformer;
    }

    /**
     * @param GetFeedsRequest $request
     * @return JsonResponse
     */
    public function index(GetFeedsRequest $request): JsonResponse
    {
        $feeds = $this->service->indexData($request->all());

        $data = fractal()
            ->collection($feeds)
            ->transformWith($this->feedTransformer)
            ->serializeWith(new JsonApiSerializer())
            ->paginateWith(new IlluminatePaginatorAdapter($feeds))
            ->withResourceName('feeds')
            ->toArray();

        return response()->json($data);
    }
}
