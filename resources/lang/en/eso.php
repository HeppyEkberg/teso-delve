<?php

return [
    'classes' => [
        6 => ['name' => 'Templar'],
        2 => ['name' => 'Sorcerer'],
        3 => ['name' => 'Nightblade'],
        4 => ['name' => 'Warden'],
        1 => ['name' => 'Dragonknight'],
    ],
    'races' => [
        10 => ['name' => 'Imperial'],
        9 => ['name' => 'Khajit'],
        6 => ['name' => 'Argonian'],
        5 => ['name' => 'Nord'],
        1 => ['name' => 'Breton'],
        3 => ['name' => 'Orc'],
        8 => ['name' => 'Wood elf'],
        2 => ['name' => 'Redguard'],
        7 => ['name' => 'High elf'],
        4 => ['name' => 'Dunmer'],
    ],
    'pledgeChest' => [
        \App\Enum\PledgeChest::MAJ_AL_RAGATH => 'Maj-al Ragath',
        \App\Enum\PledgeChest::GLIRION_THE_REDBEARD => 'Glirion the Redbeard',
        \App\Enum\PledgeChest::URGALARG_CHIEF_BANE => 'Urgalarg Chief-bane'
    ],
    'dungeonType' => [
        1 => 'Group dungeon',
        2 => 'Public dungeon',
        3 => 'Delve',
        4 => 'Trial',
        5 => 'Arena',
    ]
];
