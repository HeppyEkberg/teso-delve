<?php namespace App\Repository;

use App\Enum\ItemStyleChapter;
use App\Enum\ItemTrait;
use App\Model\CraftingTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class GithubRepository
{

    const FILE_PATH = 'app/github.json';

    public function info() {
        try {
            $info = Cache::remember('github_addon_version', config('addon.github.cache-time'), function() {
                $opts = config('addon.github.opts');
                $context = stream_context_create($opts);

                $result = file_get_contents(config('addon.github.repo-url'), null, $context);
                $result = json_decode($result);

                $data = [
                    'version' => $result->tag_name,
                    'zipball' => $result->zipball_url,
                ];

                file_put_contents(storage_path(self::FILE_PATH), json_encode($data));

                return $data;
            });
        }
        catch(\Exception $e) {
            //TODO: Send mail to someone?

            $info = file_get_contents(storage_path(self::FILE_PATH));
            $info = (array) json_decode($info);
        }

        return $info;
    }

}