<?php namespace App\Services;

use App\Model\Ability;

class AbilityService
{

    public function create($data, $skillLine) {
        $ability = new Ability();

        $name = $data[7];
        if(stripos($name, '^') !== false) {
            $name = explode('^', $data[7]);
            $name = $name[0];
        }

        $ability->index = $data[6];
        $ability->name = $name;
        $ability->image = $data[8];
        $ability->lang = $data[31];
        $ability->skill_line_id = $skillLine->id;
        $ability->isPassive = $data[10] == 'true';
        $ability->description = $data[19];
        $ability->isUltimate = $data[11] == 'true';

        $skillpoints = explode('-', $data[30]);
        $ability->maxSkillpoints = (is_array($skillpoints) and count($skillpoints) > 1) ? $skillpoints[1] : 1;

        $ability->baseName = empty($data[15]) ? $ability->name : $data[15];
        $ability->morph = intval($data[16]);

        $castInfo = explode('-', $data[20]);
        $ability->isChanneled = $castInfo[0] == 'true';
        $ability->castTime = $castInfo[1];
        $ability->channelTime = $castInfo[2];
        $ability->externalName = $data[7];

        $ability->target = $data[21];

        $range = explode('-', $data[22]);
        $ability->minRange = $range[0];
        $ability->maxRange = $range[1];

        $ability->radius = $data[23];
        $ability->angle = $data[24];
        $ability->duration = $data[25];

        $cost = explode('-', $data[26]);
        $ability->cost = $cost[0];
        $ability->powertypeEnum = $cost[1];

        $roles = explode('-', $data[27]);
        $ability->isTank = $roles[0] == 'true';
        $ability->isHealer = $roles[1] == 'true';
        $ability->isDPS = $roles[2] == 'true';

        $ability->checkParent();
        $ability->save();

        return $ability;
    }

}