<?php

namespace App\Console\Commands;

use App\Models\ProductReview;
use Goutte\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class ScapeProductReviews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scape:productreview';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $url = 'https://www.thegioididong.com';
        $product = DB::table('products')->get();
        // print($brand);
        foreach ($product as $p) {
            $client = new Client();
            $crawler = $client->request('GET', $url.$p->product_link.'/danh-gia');
            $crawler->filter('ul.comment-list li')->each(
                function ($node) use($p){ try {
                    $product_id = $p->id;
                    $comment = $node->filter('div.cmt-content')->filter('p.cmt-txt')->text();  
                    $review = new ProductReview();
                    $review->product_id = $product_id;
                    $review->comment = $comment;
                    $review->star = 4;
                    $review->save();
                } catch (InvalidArgumentException $e) {
                }}
            );
        }
    }
}
