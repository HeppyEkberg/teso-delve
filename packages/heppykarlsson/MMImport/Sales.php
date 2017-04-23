<?php namespace HeppyKarlsson\MMImport;

use App\Model\ItemSale;
use App\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;

class Sales implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    private $sales;
    private $user_id;

    public function __construct($sales, $user_id)
    {
        $this->sales = $sales;
        $this->user_id = $user_id;
    }

    public function handle()
    {
        $inserts = [];
        $guids = [];

        $user = User::find($this->user_id);
        $guilds = $user->guilds->keyBy('name');

        foreach ($this->sales as $sale) {
            set_time_limit(10);

            $itemKey = explode(':', $sale['item_key']);
            $query = \App\Model\Item::where('itemLink', 'LIKE', '|H0:item:'.$sale['link_id'].":%:".$itemKey[4]."|h|h")
                ->where('level', $itemKey[0])
                ->where('championLevel', $itemKey[1] * 10)
                ->where('quality', $itemKey[2])
                ->where('trait', $itemKey[3])
                ->where('lang', App::getLocale());

            $item = $query->first();

            if(is_null($item)) {
                continue;
            }

            $sold_at = $sold_at = Carbon::createFromTimestamp($sale['timestamp']);
            $itemSale = new ItemSale();
            $itemSale->item_id = $item->id;
            $itemSale->price = $sale['price'];
            $itemSale->price_ea = $sale['price'] / $sale['quant'];
            $itemSale->external_id = $sale['id'];
            $itemSale->link_id = $sale['link_id'];

            $itemSale->level = $itemKey[0];
            $itemSale->championLevel = $itemKey[1] * 10;
            $itemSale->quality = $itemKey[2];
            $itemSale->trait = $itemKey[3];
            $itemSale->itemLink_last = $itemKey[4];


            $itemSale->quantity = $sale['quant'];
            $itemSale->sold_at = $sold_at;
            $itemSale->week = $sold_at->year . "" . substr('0'.$sold_at->weekOfYear, -2);
            $itemSale->buyer = $sale['buyer'];
            $itemSale->item_key = $sale['item_key'];
            $itemSale->seller = $sale['seller'];
            $itemSale->itemLink = $sale['itemLink'];
            $itemSale->isKiosk = $sale['wasKiosk'];

            $itemSale->created_at = Carbon::now();
            $itemSale->updated_at = Carbon::now();

            $itemSale->guild_id = null;
            if($guilds->has($sale['guild'])) {
                $guild = $guilds->get($sale['guild']);
                $itemSale->guild_id = $guild->id;
            }

            $itemSale->guid();

            $guids[] = $itemSale->guid;
            $inserts[$itemSale->guid] = $itemSale->getAttributes();
        }

        $used_guids = ItemSale::whereIn('guid', $guids)->select('guid')->get();

        $used_guids = $used_guids->keyBy('guid')->toArray();

        $inserts = array_diff_key($inserts, $used_guids);

        if(count($inserts) == 0) {
            return true;
        }

        ItemSale::insert($inserts);

        return true;
    }

}