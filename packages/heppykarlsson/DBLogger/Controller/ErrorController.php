<?php namespace HeppyKarlsson\DBLogger\Controller;

use App\Http\Controllers\Controller;
use HeppyKarlsson\DBLogger\Model\Log;
use HeppyKarlsson\EsoImport\File;
use DB;

class ErrorController extends Controller
{
    public function index() {

        $logs = Log::orderBy('created_at', 'desc')->paginate();

        return view('DBLogger::index', compact('logs'));
    }

    public function show(Log $log) {

        $lines = [];
        File::eachRow($log->file, function($line, $rowNumber) use ($log, &$lines) {

            if($rowNumber < ($log->row - 11)) {
                return false;
            }

            if($rowNumber > ($log->row + 11)) {
                return false;
            }

            if($rowNumber == $log->row) {
                $lines[] = '<div class="text-white bg-danger">'.$line.'</div>';
                return true;
            }

            $lines[] = htmlspecialchars($line);
        });

        return view('DBLogger::show', compact('log', 'lines'));
    }

    public function truncate() {
        DB::table('logs')->truncate();
        return redirect()->route('admin.errors.index');
    }

}