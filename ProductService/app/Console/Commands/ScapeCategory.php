<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Eccomerce;
use Goutte\Client;
use Illuminate\Console\Command;
use InvalidArgumentException;

class ScapeCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scape:category';

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
        // save ec information
        $EC = new Eccomerce();
        $EC->name = "Thế giới di động";
        $EC->link = $url;
        $EC->image = 'https://cdn.tgdd.vn/2023/12/campaign/Logo-tgdd-desk-265x56.png';
        $EC->save();

        $client = new Client();

        $crawler = $client->request('GET', $url);
        $crawler->filter('ul.main-menu li')->each(
            function ($node) { try {
                $link = $node->filter('a')->attr('href');
                $name = $node->filter('span')->text();
                $Category = new Category();
                $Category->category_name = $name;
                $Category->category_link = $link;
                $Category->ec_id = 1;
                $Category->save();
                print($name."\n");
            } catch (InvalidArgumentException $e) {
            }


            }
        );
        
    }
}
