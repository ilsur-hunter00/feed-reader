<?php

namespace Tests\Feature;

use App\Models\Feed;
use JetBrains\PhpStorm\NoReturn;
use Tests\TestCase;
use Throwable;

class GetFeedsTest extends TestCase
{
    protected Feed $feed;

    protected function setUp(): void
    {
        parent::setUp();

        $this->feed = Feed::factory()->create();
    }

    /**
     * Get feeds test
     *
     * @return void
     * @throws Throwable
     */
    #[NoReturn] public function test_get_feeds()
    {
        $response = $this->get('/api/feeds');

        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'type' => 'feeds',
                        'id' => $this->feed->id,
                        'attributes' => [
                            'name' => $this->feed->name,
                            'description' => $this->feed->description,
                            'publication_date' => $this->feed->publication_date,
                            'author' => $this->feed->author,
                            'image' => $this->feed->image
                        ]
                    ]
                ]
            ]);
    }

    /**
     * Get feeds with params test
     *
     * @return void
     * @throws Throwable
     */
    #[NoReturn] public function test_get_feeds_with_params()
    {
        $feed2 = Feed::factory()->create([
            'publication_date' => date("Y-m-d H:i:s", strtotime("yesterday"))
        ]);

        $response = $this->get('/api/feeds?sort_by=publication_date');

        $response
            ->assertStatus(200)
            ->assertSeeInOrder([$this->feed->publication_date, $feed2->publication_date]);

        $per_page = 10;
        $page = 2;

        $response = $this->get('/api/feeds?per_page='.$per_page.'&page='.$page);
        $response
            ->assertStatus(200)
            ->assertJson([
                'meta' => [
                    'pagination' => [
                        'per_page' => $per_page,
                        'current_page' => $page
                    ]
                ]
            ]);
    }
}
