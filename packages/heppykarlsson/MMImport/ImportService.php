<?php namespace HeppyKarlsson\MMImport;

use App\Model\Item;
use App\Model\ItemSale;
use Carbon\Carbon;
use Illuminate\Database\QueryException;

class ImportService
{
    private $per_job = 1000;
    private $sales = [];

    public function import($file) {
        set_time_limit(30);
        $content = file_get_contents($file);
        $content = str_replace('["', '"', $content);
        $content = str_replace('"]', '"', $content);
        $content = str_replace('[', '"', $content);
        $content = str_replace(']', '"', $content);
        $content = str_replace(' =', ': ', $content);
        $content = trim(preg_replace('/\s\s+/', ' ', $content));
        $content = str_ireplace(', }', ' }', $content);
        $first_match = stripos($content, '{');
        $content = substr($content, $first_match);
        $json = json_decode($content, true);

        foreach($json['Default']['MasterMerchant']['$AccountWide']['SalesData'] as $link_id => $salesData) {
            $sales = [];
            foreach($salesData as $itemKey => $salesInfo) {

                foreach($salesInfo['sales'] as $sale) {
                    $sale = $sale + [
                            'link_id' => $link_id,
                            'item_key' => $itemKey,
                            'itemDesc' => $salesInfo['itemDesc'],
                        ];


                    $sales[] = $sale;
                }
            }

            $this->addSales($sales);
        }
    }
    public function importBAK($file) {
        set_time_limit(30);
        $content = file_get_contents($file);
        $content = str_replace('["', '"', $content);
        $content = str_replace('"]', '"', $content);
        $content = str_replace('[', '"', $content);
        $content = str_replace(']', '"', $content);
        $content = str_replace(' =', ': ', $content);
        $content = trim(preg_replace('/\s\s+/', ' ', $content));
        $content = str_ireplace(', }', ' }', $content);
        $first_match = stripos($content, '{');
        $content = substr($content, $first_match);
        $json = json_decode($content, true);

        foreach($json['Default']['MasterMerchant']['$AccountWide']['SalesData'] as $link_id => $salesData) {
            foreach($salesData as $itemKey => $salesInfo) {
                $itemKey = explode(':', $itemKey);
                $item = Item::where('itemLink', 'LIKE', '|H0:item:'.$link_id.":%")
                    ->where('itemLink', 'LIKE', '%:'.$itemKey[4].'|h|h')
                    ->where('level', $itemKey[0])
                    ->where('championLevel', $itemKey[1] * 10)
                    ->where('quality', $itemKey[2])
                    ->where('trait', $itemKey[3])
                    ->first();


                if(is_null($item)) {
                    continue;
                }

                $itemSales = ItemSale::select('guid')->where('item_id', $item->id)->get('guid');
                $itemSales = $itemSales->pluck('guid');

                foreach($salesInfo['sales'] as $sale) {
                    set_time_limit(10);
                    $itemSale = new ItemSale();
                    $itemSale->item_id = $item->id;
                    $itemSale->price = $sale['price'];
                    $itemSale->price_ea = $sale['price'] / $sale['quant'];
                    $itemSale->external_id = $sale['id'];
                    $itemSale->quantity = $sale['quant'];
                    $itemSale->sold_at = Carbon::createFromTimestamp($sale['timestamp']);
                    $itemSale->buyer = $sale['buyer'];
                    $itemSale->seller = $sale['seller'];
                    $itemSale->itemLink = $sale['itemLink'];
                    $itemSale->isKiosk = $sale['wasKiosk'];

                    if($itemSales->contains($itemSale->guid())) {
                        continue;
                    }

                    try {
                        $itemSale->save();
                    }
                    catch(QueryException $e) {
                        if($e->errorInfo[1] != 1062) {
                            throw $e;
                        }
                    }
                }
            }
        }
    }
    public function addSales($sales) {

        $this->sales = array_merge($this->sales, $sales);

        if(count($this->sales) > $this->per_job) {
            $job = new Sales($this->sales);
            dispatch($job);
            $this->sales = [];
        }

    }

}