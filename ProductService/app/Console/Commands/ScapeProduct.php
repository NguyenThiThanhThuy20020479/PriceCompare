<?php

namespace App\Console\Commands;

use App\Models\Product;
use Goutte\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class ScapeProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scape:product';

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
        $url = 'https://www.thegioididong.com/';
        $brand = DB::table('brands')->get();
        // print($brand);
        foreach ($brand as $b) {
            $client = new Client();
            $crawler = $client->request('GET', $url.$b->brand_link);
            $crawler->filter('ul.listproduct li')->each(
                function ($node){ try {
                    $link = $node->filter('a')->attr('href');
                    $name = $node->filter('a')->filter('h3')->text();
                    $current_price = $node->filter('a')->filter('div.box-p')->filter('p.price-old')->text();
                    $sale_price = $node->filter('a')->filter('strong.price')->text();
                    $image = $node->filter('a')->filter('div.item-img')->filter('img')->attr('src');
                    $product = new Product();
                    $product->product_name = $name;
                    $product->product_link = $link;
                    $product->current_price = $current_price;
                    $product->sale_price = $sale_price;
                    $product->product_image = $image ?? '';
                    if (!Product::where('product_link', $link)->first()) {
                        $product->save();
                    }
                } catch (InvalidArgumentException $e) {
                }}
            );
        }
    }
}
