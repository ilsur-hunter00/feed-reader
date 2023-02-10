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
     * @OA\Get(
     *    path="/feeds",
     *    tags={"Feeds"},
     *    summary="Get list of feeds",
     *    description="Returns list of feeds",
     *    @OA\Response(
     *        response=200,
     *        description="Successful operation"
     *    ),
     *    @OA\Response(
     *        response=422,
     *        description="Validation Error"
     *    )
     * )
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
