<?php namespace HeppyKarlsson\EsoImport\Import\Jobs\Inventory;

use App\Model\ImportGroup;
use App\Model\ImportRow;
use App\User;
use HeppyKarlsson\EsoImport\Import\ItemStyle;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ItemStyles extends InventoryJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $user_id;
    protected $importGroup_guid;
    protected $row_guids;

    public function __construct($user_id, $importGroup_guid, $row_guids)
    {
        $this->user_id = $user_id;
        $this->importGroup_guid = $importGroup_guid;
        $this->row_guids = $row_guids;
    }

    public function handle()
    {
        $importRows = ImportRow::whereIn('guid', $this->row_guids)->get();

        $user = User::find($this->user_id);
        $itemStyleImport = new ItemStyle();
        $itemStyles = \App\Model\ItemStyle::all();

        foreach($importRows as $importRow) {
            $itemStyleImport->process($importRow->row, $user, $itemStyles);

        }

        ImportGroup::where('guid', $this->importGroup_guid)->increment('itemStyles', $importRows->count());
        ImportRow::whereIn('guid', $this->row_guids)->delete();
        $this->DoneCheck();
        return true;
    }

}
