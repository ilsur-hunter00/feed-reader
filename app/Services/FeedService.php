<?php

namespace App\Services;

use App\Models\Feed;

class FeedService
{
    public function indexData($params)
    {
        $sort_by = $params['sort_by'] ?? null;
        $feeds = Feed::query()
            ->when(isset($sort_by), function ($q) use ($sort_by) {
                $q->order_by($sort_by, 'desc');
            });

        return $feeds->paginate($params['per_page'] ?? config('defaults.pagination.per_page'));
    }
}
