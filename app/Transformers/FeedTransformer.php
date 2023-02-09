<?php

namespace App\Transformers;

use App\Models\Feed;
use League\Fractal\TransformerAbstract;

class FeedTransformer extends TransformerAbstract
{
    public function transform(Feed $feed)
    {
        return [
            'id' => $feed->id,
            'name' => $feed->name,
            'description' => $feed->description,
            'publication_date' => $feed->publication_date,
            'author' => $feed->author,
            'image' => $feed->image
        ];
    }
}
