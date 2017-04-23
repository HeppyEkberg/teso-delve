<?php namespace App\Http\Controllers;

use App\Model\Dungeon;
use App\Model\Item;
use App\Model\ItemStyle;
use App\Model\Set;
use App\Objects\Zones;
use HeppyKarlsson\Sitemap\Page;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Response;

class SitemapController
{

    public function sitemap() {

        $pages = Cache::remember('sitemap-xml', 60*12, function() {
           $pages = new Collection();

            $pages->add(Page::route('import.index'));
            $pages->add(Page::route('contribute'));
            $pages->add(Page::route('about'));

            $pages->add(new Page(route('set.index')));
            $pages->add(Page::route('set.monster'));
            $pages->add(Page::route('set.craftable'));

            $sets = Set::where('lang', config('constants.default-language'))->get();
            foreach($sets as $set) {
                $pages->add(new Page(route('set.show', [$set])));
            }

            $pages->add(Page::route('dungeons.groups.index'));
            $pages->add(Page::route('dungeons.delves.index'));
            $pages->add(Page::route('dungeons.public.index'));
            $pages->add(Page::route('dungeons.arenas.index'));
            $pages->add(Page::route('dungeons.trials.index'));

            $dungeons = Dungeon::all();
            foreach($dungeons as $dungeon) {
                $pages->add(Page::route('dungeon.show', [$dungeon]));
            }

            $zonesObject = new Zones();
            $zones = $zonesObject->getZones();

            foreach($zones as $zone) {
                $pages->add(Page::route('zone.show', [$zone['slug']]));
            }

            $pages->add(Page::route('item-styles.index'));

            $styles = ItemStyle::where('isHidden', 0)->get();
            foreach($styles as $style) {
                $pages->add(Page::route('item-styles.show', [$style]));
            }

            return $pages;
        });

        return Response::view('sitemap.show', compact('pages'))->header('Content-Type', 'text/xml');
   }

   public function items() {
       $pages = Cache::remember('items-sitemap-xml', 60*24, function() {
           $pages = new Collection();

           foreach(Item::all() as $item) {
               $pages->add(Page::route('item.show', [$item]));
           }

           return $pages;
       });

       return Response::view('sitemap.show', compact('pages'))->header('Content-Type', 'text/xml');
   }


}