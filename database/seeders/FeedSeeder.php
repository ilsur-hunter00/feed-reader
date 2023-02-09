<?php

namespace Database\Seeders;

use App\Models\Feed;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class FeedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $feed = Feed::create([
            'name' => 'New series released',
            'description' => 'New series released! It is really good!',
            'publication_date' => Carbon::now(),
            'author' => 'Michael Smith',
            'image' => env('APP_URL') . '/public/images/seriesPhoto.jpg'
        ]);

        $feed->save();
    }
}
