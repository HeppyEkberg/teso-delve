<?php namespace HeppyKarlsson\EsoImport;

class File
{

    static public function eachRow($file, $function) {
        $file_opened = fopen($file, 'r');

        if($file_opened) {
            $line = null;
            $i = 1;
            while (!feof($file_opened))
            {
                call_user_func($function, fgets($file_opened), $i);
                $i++;
            }
            fclose($file_opened);
        }
        else {
            throw new \Exception('File couldnt be opened');
        }

    }

}
