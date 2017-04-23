<?php namespace HeppyKarlsson\EsoImport\Import\Jobs\Inventory;

use App\Model\ImportGroup;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InventoryJob
{

    public function DoneCheck() {
        $importGroup = ImportGroup::where('guid', $this->importGroup_guid)->first();
        $job_ids = json_decode($importGroup->job_ids);

        if(!is_array($job_ids)) {
            return true;
        }

        $count = DB::table('jobs')->whereIn('id', $job_ids)->count();

        if($count == 1) {
            $job = new Finalize($this->importGroup_guid, $this->user_id, $importGroup->created_at);
            $job->onQueue('inventory');
            dispatch($job);
        }
    }
}
