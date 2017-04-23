<?php namespace HeppyKarlsson\EsoImport;

use App\Model\AbilityCharacter;
use App\Model\ItemStyle;
use App\Model\SkillLine;
use App\Model\UserItem;
use App\User;
use Carbon\Carbon;
use HeppyKarlsson\DBLogger\Facade\DBLogger;
use HeppyKarlsson\EsoImport\Exception\DumpValidation;
use HeppyKarlsson\EsoImport\Import\Ability;
use HeppyKarlsson\EsoImport\Import\Character;
use HeppyKarlsson\EsoImport\Import\Guild;
use HeppyKarlsson\EsoImport\Import\Jobs\Inventory\Initialize;
use Illuminate\Support\Facades\Auth;

class EsoImport
{
    /** @var User */
    private $user = null;
    private $itemStyles = null;

    public function import($file_path) {
        set_time_limit(120);
        ini_set('memory_limit','24M');

        $updateStart = Carbon::now();

        $this->itemStyles = ItemStyle::all();

        $user = Auth::user();
        $this->user = $user;
        $user->dumpUploaded_at = Carbon::now();
        $user->save();

        $user->load('characters.meta');

        try {

            File::eachRow($file_path, function($line) use ($user) {
                try {
                    $this->checkFile($line);

                    $this->setUserLang($line);
                    if(strpos($line, 'CHARACTER:') !== false) {
                        $characterImport = new Import\Character();
                        $characterImport->process($line, $user);
                        return true;
                    }

                    if(Guild::check($line)) {
                        $guildImport = new Guild();
                        $guildImport->process($line, $user);
                        return true;
                    }
                }
                catch(\Throwable $e) {
                    // Log and move on to next line
                    DBLogger::save($e);
                }

            });

            $user->load('characters');
            $user->load('characters.craftingTraits');
            $user->load('characters.meta');
            $user->load('characters.itemStyles');
//            $user->load('guilds.members');
//            $user->load('userItems');
            $user->load('meta');
//            $this->userItems = $user->userItems->groupBy('characterId');

            $skills = SkillLine::all();

            File::eachRow($file_path, function($line) use($user, $skills) {
                try {

                    if (strpos($line, 'ITEMSTYLE:') !== false) {
                        $itemStyleImport = new Import\ItemStyle();
                        $itemStyleImport->process($line, $user, $this->itemStyles);
                        return true;
                    }

//                if(GuildMember::check($line)) {
//                    $member = new GuildMember();
//                    $member->process($line, $user, $this->guilds);
//                    return true;
//                }

                    if (Ability::check($line)) {
                        $ability = new Ability();
                        $ability->process($line, $user, $skills);
                        return true;
                    }

                    if (strpos($line, 'SMITHING:') !== false) {
                        $smithingImport = new Import\Smithing();
                        $smithingImport->process($line, $user);
                        return true;
                    }

                    if (strpos($line, 'ITEM:') !== false) {
                        $itemImport = new Import\Item();
                        $itemImport->process($line, $user, $this->itemStyles);
                        return true;
                    }
                }
                catch (\Throwable $e) {
                    DBLogger::save($e);
                }
            });

            UserItem::where('userId', $user->id)->where('updated_at', '<', $updateStart)
                ->delete();

            AbilityCharacter::whereIn('character_id', $user->characters->pluck('id')->toArray())
                ->where('updated_at', '<', $updateStart)
                ->delete();

        } catch(DumpValidation $e) {
            return response()->json(['upload' => 'error', 'error' => $e->getMessage()], 400);
        }

        return response()->json(['upload' => 'success']);
    }

    public function jobImport($file_path) {
        $user = Auth::user();
        $characters = 0;

        File::eachRow($file_path, function($line) use ($user, &$characters) {

            if(Character::check($line)) {
                $this->checkFile($line);

                $character = new Character();
                $character->process($line, $user);
                $characters++;
                return true;
            }

            if(Guild::check($line)) {
                $guild = new Guild();
                $guild->process($line, $user);
                return true;
            }

            return true;
        });

        $job = new Initialize($file_path, $user, $characters);
        $job->onQueue('invinitialize');
        dispatch($job);

        return 'works';
    }

    public function checkFile($line) {
        if(stripos($line, 'local function loadTesoDelve(') !== false) {
            throw new DumpValidation('Import failed, it looks like you have accidently uploaded the TesoDelve file from Addons folder instead of SavedVariables');
        }
    }

    public function setUserLang($line) {
        $item_start = strpos($line, 'CHARACTER:');
        if($item_start === false) {
            return false;
        }

        $line = str_ireplace('",', '', $line);
        $line = substr($line, $item_start + 10);
        $properties = explode(';', $line);

        $lang = isset($properties[18]) ? trim(preg_replace('/\s\s+/', ' ', $properties[18])) : config('constants.default-language');
        if($this->user->lang != $lang) {
            $this->user->lang = $lang;
            $this->user->save();
        }
    }

}
