<?php namespace App\Objects;

use App\Model\Item;
use App\Model\ItemSale;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PriceCompareWeek
{

    private $item;
    private $weekSales;
    private $prevWeekSales;

    private $comparison;

    public function __construct(Item $item)
    {
        $this->item = $item;

        $sales = Cache::remember('priceComparison_'.$item->id, 60, function() use ($item) {

            return ItemSale::where('item_id', $item->id)
                ->where('sold_at', '>=', Carbon::now()->subMonth())
                ->select(DB::raw('avg(price_ea) as price_avg, max(price_ea) as price_max, min(price_ea) as price_min, count(*) as hits, week'))
                ->groupBy('week')
                ->get()
                ->sortByDesc('week')
                ->keyBy('week');

        });

        $this->weekSales = $sales->shift();
        $this->prevWeekSales = $sales->shift();

        if(!is_null($this->weekSales) and !is_null($this->prevWeekSales)) {
            $this->comparison = (1 - ($this->prevWeekSales->price_avg / $this->weekSales->price_avg)) * 100;
        }
    }

    public function isValid() {
        if(is_null($this->weekSales) or is_null($this->prevWeekSales)) {
            return false;
        }

        return true;
    }

    public function average()
    {
        return $this->weekSales->price_avg;
    }

    public function hits() {
        return $this->weekSales->hits;
    }

    public function prevAverage() {
        return $this->prevWeekSales->price_avg;
    }

    public function prevHits() {
        return $this->prevWeekSales->hits;
    }

    public function comparison() {
        return $this->comparison;
    }

}

