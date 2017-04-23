<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Character;
use App\Model\Item;
use App\Model\ItemSale;
use App\Model\Job;
use App\User;
use Carbon\Carbon;
use HeppyKarlsson\DBLogger\Model\Log;
use Illuminate\Support\Facades\Auth;
use Rap2hpoutre\LaravelLogViewer\LaravelLogViewer;

class AdminController extends Controller
{
    const SEEN_AT_DAYS = 1;


    public function index() {
        $seenAt = Carbon::now()->subDays(self::SEEN_AT_DAYS);

        $data = [
            'total_users' => User::count(),
            'new_users' => User::where('created_at', '>=', $seenAt)->count(),
            'users_activity' => User::where('seen_at', '>=', $seenAt)->count(),
            'dumps_activity' => User::where('dumpUploaded_at', '>=', $seenAt)->count(),

            'total_characters' => Character::count(),
            'new_characters' => Character::where('created_at', '>=', $seenAt)->count(),

            'total_sales' => ItemSale::count(),
            'sales_activity' => ItemSale::where('created_at', '>=', $seenAt)->count(),
            'itemsCount' => Item::where('created_at', '>=', $seenAt)->count(),
        ];


        $jobs = Job::all();


        $users = User::orderBy('seen_at', 'desc')
            ->where('id', '!=', Auth::id())
            ->take(20)
            ->get();

        $dumpUsers = User::orderBy('dumpUploaded_at', 'desc')
            ->whereNotNull('dumpUploaded_at')
            ->with('characters')
            ->where('id', '!=', Auth::id())
            ->take(20)
            ->get();

        $user = Auth::user();
        /** @var $user User */

        $last_logs_watched = $user->getMeta('admin_logs_last');
        $last_logs_watched = is_null($last_logs_watched) ? $last_logs_watched : Carbon::parse($last_logs_watched);

        $user->setMeta('admin_logs_last', Carbon::now());

        $logs = Log::take(20)->orderBy('created_at', 'desc')->get();

        return view('admin.index', compact('data', 'jobs', 'users', 'logs', 'last_logs_watched', 'dumpUsers'));
    }

    public function generateError() {
        $now = null;
        $now->format('Y-m-d');
    }

}
