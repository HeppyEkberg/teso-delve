<?php namespace HeppyKarlsson\EsoImport\Import;

use App\Enum\ItemStyleChapter;
use App\Model\CharacterItemStyle;
use App\Model\ItemStyle as ItemStyleModel;

class ItemStyle
{

    static public function check($line)
    {
        return strpos($line, 'ITEMSTYLE:') !== false;
    }

    public function process($line, $user, $itemStyles) {
        if(stripos($line, 'ITEMSTYLE:') === false) {
            return false;
        }

        $data = explode(';', $line);
        $externalId = intval($data[5]);
        $itemStyle = $itemStyles->where('externalId', $externalId)->first();

        if(is_null($itemStyle)) {
            $itemStyle = new ItemStyleModel();
            $itemStyle->externalId = $externalId;
            $itemStyle->name = ' ';
            $itemStyles->add($itemStyle);
        }

        $itemStyle->image = $data[4];
        $itemStyle->material = $data[3];
        $itemStyle->save();

        $character = $user->characters
            ->where('externalId', $data[1])
            ->first();

        if(is_null($character)) {
            return true;
        }

        $chapterKnown = explode('-', $data[7]);
        $chapters = ItemStyleChapter::order();

        foreach($chapterKnown as $key => $known) {
            if(stripos($known, 'true') !== false) {
                $characterItemStyle = $character->itemStyles
                    ->where('characterId', $character->id)
                    ->where('itemStyleId', $itemStyle->id)
                    ->where('itemStyleChapterEnum', $chapters[$key])
                    ->first();

                if(is_null($characterItemStyle)) {
                    $characterItemStyle = new CharacterItemStyle();
                    $characterItemStyle->characterId = $character->id;
                    $characterItemStyle->itemStyleId = $itemStyle->id;
                    $characterItemStyle->itemStyleChapterEnum = $chapters[$key];
                    $characterItemStyle->isKnown = 1;
                    $characterItemStyle->save();
                }
                else {
                    if($characterItemStyle->isKnown != 0) {
                        $characterItemStyle->isKnown = 1;
                        $characterItemStyle->save();
                    }
                }
            }
        }
    }
}
