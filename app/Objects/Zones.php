<?php namespace App\Objects;

use App\Enum\Alliance;
use Illuminate\Database\Eloquent\Collection;

//TODO: Break this out to a it's own table. Not optimal having it in it's own php file.

class Zones
{
    private $zones = [
        /** Aldmeri Dominion **/
        1 => ['id' => 1, 'name' => 'Auridon', 'Alliance' => Alliance::ALDMERI_DOMINION, 'slug' => 'auridon'],
        2 => ['id' => 2, 'name' => 'Grahtwood', 'Alliance' => Alliance::ALDMERI_DOMINION, 'slug' => 'grahtwood'],
        3 => ['id' => 3, 'name' => 'Greenshade', 'Alliance' => Alliance::ALDMERI_DOMINION, 'slug' => 'greenshade'],
        4 => ['id' => 4, 'name' => 'Khenarthi\'s Roost', 'Alliance' => Alliance::ALDMERI_DOMINION, 'slug' => 'khenarthis-roost'],
        5 => ['id' => 5, 'name' => 'Malabal Tor', 'Alliance' => Alliance::ALDMERI_DOMINION, 'slug' => 'malabal-tor'],
        6 => ['id' => 6, 'name' => 'Reapers\'s March', 'Alliance' => Alliance::ALDMERI_DOMINION, 'slug' => 'reapers-march'],

        /** Daggerfall Covenant **/
        7 => ['id' => 7, 'name' => "Alik'r Desert", 'Alliance' => Alliance::DAGGERFALL_COVENANT, 'slug' => 'alikr-desert'],
        8 => ['id' => 8, 'name' => 'Bangkorai', 'Alliance' => Alliance::DAGGERFALL_COVENANT, 'image' => 'bangkorai.jpg', 'slug' => 'bangkorai'],
        9 => ['id' => 9, 'name' => 'Betnikh', 'Alliance' => Alliance::DAGGERFALL_COVENANT, 'slug' => 'bethnikh'],
        10 => ['id' => 10, 'name' => 'Glenumbra', 'Alliance' => Alliance::DAGGERFALL_COVENANT, 'slug' => 'glenumbra'],
        11 => ['id' => 11, 'name' => 'Rivenspire', 'Alliance' => Alliance::DAGGERFALL_COVENANT, 'slug' => 'rivenspire'],
        12 => ['id' => 12, 'name' => 'Stormhaven', 'Alliance' => Alliance::DAGGERFALL_COVENANT, 'slug' => 'stormhaven'],
        13 => ['id' => 13, 'name' => "Stros M'Kai", 'Alliance' => Alliance::DAGGERFALL_COVENANT, 'slug' => 'stros-mkai'],

        /** Ebonheart Pact **/
        14 => ['id' => 14, 'name' => "Bal Foyen", 'Alliance' => Alliance::EBONHEART_PACT, 'slug' => 'bal-foyen'],
        15 => ['id' => 15, 'name' => "Bleakrock Isle", 'Alliance' => Alliance::EBONHEART_PACT, 'slug' => 'bleakrock-isle'],
        16 => ['id' => 16, 'name' => "Deshaan", 'Alliance' => Alliance::EBONHEART_PACT, 'slug' => 'deshaan'],
        17 => ['id' => 17, 'name' => "Eastmarch", 'Alliance' => Alliance::EBONHEART_PACT, 'slug' => 'eastmarch'],
        18 => ['id' => 18, 'name' => "The Rift", 'Alliance' => Alliance::EBONHEART_PACT, 'slug' => 'the-rift'],
        19 => ['id' => 19, 'name' => "Shadowfen", 'Alliance' => Alliance::EBONHEART_PACT, 'slug' => 'shadowfen'],
        20 => ['id' => 20, 'name' => "Stonefalls", 'Alliance' => Alliance::EBONHEART_PACT, 'slug' => 'stonefalls'],

        /** Neutral **/
        21 => ['id' => 21, 'name' => "Coldharbour", 'Alliance' => Alliance::NEUTRAL, 'slug' => 'coldharbour'],
        22 => ['id' => 22, 'name' => "Craglorn", 'Alliance' => Alliance::NEUTRAL, 'slug' => 'craglorn'],
        23 => ['id' => 23, 'name' => "Cyrodiil", 'Alliance' => Alliance::NEUTRAL, 'slug' => 'cyrodiil'],
        24 => ['id' => 24, 'name' => "Gold Coast", 'Alliance' => Alliance::NEUTRAL, 'slug' => 'gold-coast'],
        25 => ['id' => 25, 'name' => "Hew's Bane", 'Alliance' => Alliance::NEUTRAL, 'slug' => 'hews-bane'],
        26 => ['id' => 26, 'name' => "Murkmire", 'Alliance' => Alliance::NEUTRAL, 'slug' => 'murkmire'],
        27 => ['id' => 27, 'name' => "Wrothgar", 'Alliance' => Alliance::NEUTRAL, 'slug' => 'wrothgar'],
        28 => ['id' => 28, 'name' => "Vvardenfell", 'Alliance' => Alliance::NEUTRAL, 'slug' => 'vvardenfell'],

    ];

    public function getZoneBySlug($slug) {
        $zones = new Collection($this->zones);
        return $zones->where('slug', $slug)->first();
    }

    public function getZone($zoneId) {
        if(!array_key_exists($zoneId, $this->zones)) {
            return false;
        }

        return $this->zones[$zoneId];
    }

    public function getZones() {
        return $this->zones;
    }

    public function getZonesByAlliance() {
        $zones = $this->getZones();

        $zonesByAlliance = [
            Alliance::ALDMERI_DOMINION => [],
            Alliance::EBONHEART_PACT => [],
            Alliance::DAGGERFALL_COVENANT => [],
            Alliance::NEUTRAL => [],
        ];
        foreach($zones as $key => $zone) {
            $zonesByAlliance[$zone['Alliance']][$key] = $zone;
        }

        return $zonesByAlliance;
    }

}

