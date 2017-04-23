<?php namespace App\Http\Controllers;

use App\Model\Dungeon;
use App\Model\DungeonSet;
use App\Model\ImportGroup;
use App\Model\Role\Permission;
use App\Model\Role\PermissionRole;
use App\Model\Role\Role;
use App\Model\Set;
use App\Model\SetBonus;
use App\Model\UserSetFavourite;
use App\Repository\GithubRepository;
use HeppyKarlsson\EsoImport\EsoImport;
use HeppyKarlsson\MMImport\ImportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImportController
{

    public function import(EsoImport $esoImport) {

        $path = storage_path('TesoDelve.lua');
        $return = $esoImport->import($path);
//        $return = $esoImport->jobImport($path);
        return 'works';
    }

    public function mastermerchant() {

        $files = scandir(storage_path('app/mm-data'));

        $mmService = new ImportService();
        foreach($files as $file) {
            if(stripos($file, '.lua') === false) {
                continue;
            }

            $mmService->import(storage_path('app/mm-data/'.$file));
        }

    }

    public function export() {
        $sets = Set::all();
        $setBonuses = SetBonus::all();
        $userFavourites = UserSetFavourite::all();
        $dungeons = Dungeon::all();
        $dungeonSets = DungeonSet::all();
        $roles = Role::all();
        $permissions = Permission::all();
        $permissionRole = PermissionRole::all();

        file_put_contents(storage_path('dump/sets.json'), $sets->toJson());
        file_put_contents(storage_path('dump/setBonuses.json'), $setBonuses->toJson());
        file_put_contents(storage_path('dump/userFavourites.json'), $userFavourites->toJson());
        file_put_contents(storage_path('dump/dungeons.json'), $dungeons->toJson());
        file_put_contents(storage_path('dump/dungeonSets.json'), $dungeonSets->toJson());
        file_put_contents(storage_path('dump/roles.json'), $roles->toJson());
        file_put_contents(storage_path('dump/permissions.json'), $permissions->toJson());
        file_put_contents(storage_path('dump/permissionRole.json'), $permissionRole->toJson());

        return 'success';
    }

    public function upload(Request $request, EsoImport $esoImport) {
        $files = $request->files->all();
        $user = Auth::user();

        foreach($files as $file) {
            /** @var $file UploadedFile */
            $fileName = $file->getClientOriginalName();

            if($fileName == 'TesoDelve.lua') {
                File::copy($file->getRealPath(), storage_path('dumps/dump_' . Auth::id() . ".lua"));
                return $esoImport->import($file->getRealPath());
            }

            if(substr($fileName, 0, 2) == "MM" and stripos($fileName, 'Data.lua') !== false and $user->hasPermission('upload-mm')) {
                $newFile = storage_path('app/mm-data/' . Auth::id() . "-" . $fileName);
                File::copy($file->getRealPath(), $newFile);

                $mmService = new ImportService();
                $mmService->import($newFile);
                return 'MM uploaded';
            }
        }

        abort(404);
    }

    public function index() {

        $githubRepository = new GithubRepository();
        $addonInfo = $githubRepository->info();

        $importGroup = ImportGroup::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->first();

        return view('import.index', compact('addonInfo', 'importGroup'));
    }

}