<?php namespace App\Http\Controllers;

use Carbon\Carbon;
use DBLogger;

class EsouiController
{

    public function image($image) {

        $dir = 'esoui/art/icons';
        $subPath = $dir.'/'. str_ireplace('.dds', '.png', $image);

        if(!file_exists(storage_path($subPath))) {
            try {
                $url = 'http://esoicons.uesp.net/' . $subPath;
                $imageData = file_get_contents($url);
                if(!is_dir(storage_path($dir))) {
                    mkdir($dir);
                }

                file_put_contents(storage_path($subPath), $imageData);
            }
            catch(\ErrorException $e) {
                DBLogger::save($e);
                header('Content-Type: image/png');
                $content = file_get_contents(public_path('gfx/ON-icon-Question_Mark.png'));
                echo $content;
                die();
            }
        }

        $expiration = Carbon::now()->addDays(7);
        header('Pragma: public');
        header("Cache-Control: max-age=" . Carbon::now()->diffInSeconds($expiration));
        header('Expires: '. $expiration->toRfc1123String());
        header('Content-Type: image/png');
        $content = file_get_contents(storage_path($subPath));
        echo $content;

        die();
    }

}