<?php

namespace App\Console\Commands;

use App\Models\Feed;
use App\Models\ParserLog;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use Illuminate\Console\Command;

class FeedParser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parser:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Running feed parser';

    /**
     * Execute the console command.
     *
     * @return void
     * @throws GuzzleException
     */
    public function handle()
    {
        $client = new Client();
        $timeBeforeRequest = microtime(true);
        $request = new Request(
            'GET',
            'http://static.feed.rbc.ru/rbc/logical/footer/news.rss'
        );
        $response = $client->send($request);
        $timeAfterRequest = microtime(true);
        $request_time = $timeAfterRequest - $timeBeforeRequest;
        (new ParserLog())->create([
            'request_method' => $request->getMethod(),
            'request_url' => $request->getUri()->getPath(),
            'response_code' => $response->getStatusCode(),
            'response_body' => $response->getBody()->getContents(),
            'request_time' => $request_time
        ]);
        $feed = $response->getBody()->__toString();

        $feeds = simplexml_load_string($feed);

        foreach ($feeds->channel->item as $feed) {
            (new Feed())->create([
                'name' => (string) $feed->title,
                'description' => (string) $feed->description,
                'publication_date' => (string) $feed->pubDate,
                'author' => (string) $feed->author ?? null,
                'image' => (string) $feed->enclosure['url'] ?? null,
            ]);
        }
    }
}
