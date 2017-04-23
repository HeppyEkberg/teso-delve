<?php

namespace App\Http\Controllers;

use App\Model\Character;
use App\Model\CharacterItemStyle;
use App\Model\DailyPledges;
use App\Model\Item;
use App\Model\ItemStyleChapter;
use App\Model\Set;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dailyPledges = DailyPledges::where('date', '>=', Carbon::now()->subDay())
            ->with('firstPledge.sets', 'secondPledge.sets', 'thirdPledge.sets')
            ->take(2)
            ->orderBy('date')
            ->get();

        $lang = App::getLocale();

        $information = Cache::remember('startpage-info-'.$lang, 60*2, function() use ($lang) {
            return [
                'items' => Item::where('lang', App::getLocale())->count(),
                'characters' => Character::count(),
                'sets' => Set::where('lang', $lang)->count(),
                'motifs' => CharacterItemStyle::where('isKnown', 1)->count(),
            ];
        });

        return view('home.index', compact('dailyPledges', 'information'));
    }
}
