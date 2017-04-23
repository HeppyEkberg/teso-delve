<?php namespace HeppyKarlsson\EsoImport\Import\Jobs\Inventory;

use App\Model\ImportGroup;
use App\Model\ImportRow;
use App\Model\UserItem;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Jobs\DatabaseJob;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class Finalize implements ShouldQueue
{
    use InteractsWithQueue,
        Queueable,
        SerializesModels;

    protected $importGroup_guid;
    protected $user_id;
    protected $startTime;

    public $tries = 10;

    public function __construct($importGroup_guid, $user_id, $startTime)
    {
        $this->user_id = $user_id;
        $this->importGroup_guid = $importGroup_guid;
        $this->startTime = $startTime;
    }

    public function handle()
    {

        $count = ImportRow::where('import_group_guid', $this->importGroup_guid)->count();
        if($count > 0 and !empty($this->job->getJobId())) {

            $release = $this->release(10);

            DB::table('jobs')
                ->where('id', $this->job->getJobId())
                ->update(['attempts' => 0]);

            return $release;
        }

        UserItem::where('userId', $this->user_id)
            ->where('updated_at', '<', $this->startTime)
            ->delete();


        ImportGroup::where('guid', $this->importGroup_guid)
            ->update(['isDone' => 1]);

        return true;
    }

}
