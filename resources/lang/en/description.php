<?php

return [
    'set' => [
        \App\Enum\SetType::MONSTER => ':name monster set, helm found in :dungeon (veteran) and shoulders in :pledgeChest chest',
        \App\Enum\SetType::CRAFTED => ':name set craftable in :zones and needs :traits traits researched',
        \App\Enum\SetType::DUNGEON => ':name set found in :dungeons',
        \App\Enum\SetType::ZONE => ':name set found in :zones',
        'bonusLast' => ':bonusNumber pieces set bonus: :description',
    ]
];