<?php

namespace App\Console\Commands;

use App\Models\ProductDetail;
use Goutte\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class ScapeProductDetail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scape:productdetail';

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
            $crawler = $client->request('GET', $url.$p->product_link);
            $crawler->filter('ul.parameter__list li')->each(
                function ($node) use($p){ try {
                    $product_id = $p->id;
                    $name = $node->filter('p.lileft')->text();
                    $value = "";
                    $node->filter('div.liright span')->each(function($n) use ($value){
                        $value = $value.$n->text().",";
                    });
                    $productdetail = new ProductDetail();
                    $productdetail->product_id = $product_id;
                    $productdetail->name = $name;
                    $productdetail->value = $value;
                    $productdetail->save();
                } catch (InvalidArgumentException $e) {
                }}
            );
        }
    }
}
