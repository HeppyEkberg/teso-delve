<?php namespace HeppyKarlsson\EsoImport\Import;

use App\Enum\SkilltypeEnum;
use App\Model\SkillLine;
use App\Services\AbilityService;
use Carbon\Carbon;

class Ability
{

    static public function check($line)
    {
        return strpos($line, 'ABILITY;--;') !== false;
    }

    public function process($line, $user, $skillLines) {

        $data = explode(';--;', $line);
        $character = $user->characters->where('externalId', $data[1])->first();

        if(is_null($character)) {
            return false;
        }

        $skillLine = $skillLines->where('externalName', $data[4])
            ->where('skilltypeEnum', $data[2])
            ->where('lang', $data[31])
            ->first();

        if(is_null($skillLine)) {
            $skillLine = new SkillLine();
            $skillLine->name = $data[4];
            $skillLine->externalName = $data[4];
            $skillLine->lang = $data[31];
            $skillLine->skilltypeEnum = $data[2];
            $skillLine->classEnum = $data[2] == SkilltypeEnum::CLASS_SKILL ? $character->classId : null;
            $skillLine->raceEnum = $data[2] == SkilltypeEnum::RACIAL ? $character->raceId : null;
            $skillLine->save();

            $skillLines->push($skillLine);
        }

        $ability = \App\Model\Ability::where('externalName', $data[7])
            ->where('lang', $data[31])
            ->first();

        if(is_null($ability)) {
            $abilityService = new AbilityService();
            $ability = $abilityService->create($data, $skillLine);
        }
        else {
            $ability->checkParent();
        }

        if($data[12] == 'true') {
            $characterAbility = $character->abilities->where('name', $data[7])->first();
            $skillpoints = explode('-', $data[30]);

            if($characterAbility) {
                $character->abilities()->updateExistingPivot($ability->id, [
                    'updated_at' => Carbon::now(),
                    'skillpoints' => $data[30] == "" ? 1 : $skillpoints[0],
                ]);
            }
            else {
                $character->abilities()->save($ability, [
                    'rank' => $data[5],
                    'skillpoints' => $data[30] == "" ? 1 : $skillpoints[0],
                    'progression' => intval($data[13]),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }

        }

    }
}
