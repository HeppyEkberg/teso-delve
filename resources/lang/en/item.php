<?php
return [

    'type' => [

        \App\Enum\ItemType::BLACKSMITHING_MATERIAL => ':name is used when crafting blacksmithing weapons and armor.',
        \App\Enum\ItemType::BLACKSMITHING_BOOSTER => ':name is used to improve the quality of weapons and heavy armor',
        \App\Enum\ItemType::BLACKSMITHING_RAW_MATERIAL => ':name is a raw material used in blacksmithing. Before you can use it you have to refine it at a crafting bench.',

        \App\Enum\ItemType::CLOTHIER_BOOSTER => ':name is used to improve the quality of light and medium armor',
        \App\Enum\ItemType::CLOTHIER_MATERIAL => ':name is used when crafting clothing armor.',
        \App\Enum\ItemType::CLOTHIER_RAW_MATERIAL =>  ':name is a raw material used in clothing. Before you can use it you have to refine it at a crafting bench.',

    ],

];