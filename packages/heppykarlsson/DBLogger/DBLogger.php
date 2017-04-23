<?php namespace HeppyKarlsson\DBLogger;

use HeppyKarlsson\DBLogger\Exception\Exception;
use HeppyKarlsson\DBLogger\Model\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class DBLogger {

    public function save(\Throwable $exception) {

        if($exception instanceof \HeppyKarlsson\DBLogger\Exception\Exception) {
            return false;
        }

            $request = request();
        $log = new Log();

        try {
            $log->error = $exception->getMessage();
            $log->route = Route::currentRouteName();
            $log->url = $request->path();
            $log->session = session()->getId();
            $log->method = $request->method();
            $log->user_id = Auth::id();
            $log->referer = $request->header('referer');
            $log->file = $exception->getFile();
            $log->row = $exception->getLine();
            $log->severity = method_exists($exception, 'getSeverity') ? $exception->getSeverity() : null;
            $log->code = intval($exception->getCode());
            $log->exception = get_class($exception);

            $traces = $exception->getTrace();
            foreach($traces as &$trace) {
                unset($trace['args']);
            }

            $log->trace = json_encode($traces);

            $log->save();
        }
        catch(\Throwable $e) {
            throw new Exception($e->getMessage());
        }

        return true;
    }

}