<?php

namespace App\Console\Commands;

use App\Models\Brand;
use Goutte\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use App\Models\Category;

class ScapeBrand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scape:brand';

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
        $category = DB::table('categories')->get();
        foreach ($category as $cat) {
            $client = new Client();
            $crawler = $client->request('GET', $url.$cat->category_link);
            $crawler->filter('div .lst-quickfilter a')->each(
                function ($node) use ($cat){ try {
                    $link = $node->attr('data-href');
                    $brand = new Brand();
                    $brand->brand_name = $link;
                    $brand->brand_link = $link;
                    $brand->brand_image = $node->filter('img')->attr('src');
                    $brand->category_id = $cat->id;
                    if (!Brand::where('brand_link', $link)->first()) {
                        $brand->save();
                    }
                } catch (InvalidArgumentException $e) {
                }}
            );
        }
    }
}
