<?php namespace HeppyKarlsson\EsoImport\Import\Jobs\Inventory;

use App\Enum\ImportType;
use App\Model\ImportGroup;
use App\Model\ImportRow;
use App\User;
use Carbon\Carbon;
use HeppyKarlsson\EsoImport\File;
use HeppyKarlsson\EsoImport\Import\Item;
use HeppyKarlsson\EsoImport\Import\ItemStyle;
use HeppyKarlsson\EsoImport\Import\Smithing;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class Initialize implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $file;
    protected $user_id;

    protected $items;
    protected $itemStyles;
    protected $smithing;
    protected $job_ids = [];

    protected $smithingCount = 0;
    protected $itemStylesCount = 0;
    protected $itemsCount = 0;
    protected $charactersCount = 0;

    /** @var ImportGroup  */
    private $importGroup = null;
    private $per_group = 500;

    public function __construct($file, $user, $characters)
    {
        $this->file = $file;
        $this->user_id = $user->id;
        $this->charactersCount = $characters;
    }

    public function handle()
    {
        $start = Carbon::now();

        $this->items = new Collection();
        $this->itemStyles = new Collection();
        $this->smithing = new Collection();

        $user = User::find($this->user_id);

        $importGroup = new ImportGroup();
        $importGroup->guid = bcrypt($this->file . Carbon::now() . $this->user_id . rand(0, 100000));
        $importGroup->user_id = $user->id;
        $importGroup->items = 0;
        $importGroup->characters = $this->charactersCount;
        $importGroup->smithing = 0;
        $importGroup->itemStyles = 0;
        $importGroup->file = $this->file;
        $importGroup->save();

        $this->importGroup = $importGroup;

        File::eachRow($this->file, function($line) use ($user, $importGroup) {

            if(Item::check($line)) {
                $this->addItem($line);
            }

            if(ItemStyle::check($line)) {
                $this->addItemStyle($line);
            }

            if(Smithing::check($line)) {
                $this->addSmithing($line);
            }

        });

        $this->pushItems();
        $this->pushItemStyles();
        $this->pushSmithing();

        $importGroup->job_ids = json_encode($this->job_ids);
        $importGroup->save();

        return true;
    }

    public function addSmithing($line) {

        $now = Carbon::now();

        $this->smithing->add([
            'guid' => sha1($this->file . $now . $this->user_id . $line),
            'user_id' => $this->user_id,
            'import_group_guid' => $this->importGroup->guid,
            'row' => trim($line),
            'type' => ImportType::SMITHING,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        if(count($this->smithing) >= $this->per_group) {
            $this->pushSmithing();
        }
    }

    public function addItem($line) {

        $now = Carbon::now();

        $this->items->add([
            'guid' => sha1($this->file . $now . $this->user_id . $line),
            'user_id' => $this->user_id,
            'import_group_guid' => $this->importGroup->guid,
            'row' => trim($line),
            'type' => ImportType::ITEM,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        if(count($this->items) >= $this->per_group) {
            $this->pushItems();
        }
    }

    public function addItemStyle($line) {

        $now = Carbon::now();

        $this->itemStyles->add([
            'guid' => sha1($this->file . $now . $this->user_id . $line),
            'user_id' => $this->user_id,
            'import_group_guid' => $this->importGroup->guid,
            'row' => trim($line),
            'type' => ImportType::ITEMSTYLE,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        if(count($this->itemStyles) >= $this->per_group) {
            $this->pushItemStyles();
        }

    }

    public function pushSmithing() {
        if($this->smithing->count() == 0) {
            return true;
        }

        $guids = $this->smithing->pluck('guid')->toArray();
        ImportRow::insert($this->smithing->toArray());
        $this->smithing = new Collection();

        $smithingJob = new Smithings($this->user_id, $this->importGroup->guid, $guids);
        $smithingJob->onQueue('inventory');
        $this->job_ids[] = dispatch($smithingJob);

        return true;
    }

    public function pushItemStyles() {
        if($this->itemStyles->count() == 0) {
            return true;
        }

        $guids = $this->itemStyles->pluck('guid')->toArray();
        ImportRow::insert($this->itemStyles->toArray());
        $this->itemStyles = new Collection();

        $itemStylesJob = new ItemStyles($this->user_id, $this->importGroup->guid, $guids);
        $itemStylesJob->onQueue('inventory');
        $this->job_ids[] = dispatch($itemStylesJob);

        return true;
    }

    public function pushItems() {
        if($this->items->count() == 0) {
            return true;
        }

        $guids = $this->items->pluck('guid')->toArray();
        ImportRow::insert($this->items->toArray());
        $this->items = new Collection();

        $itemsJob = new Items($this->user_id, $this->importGroup->guid, $guids);
        $itemsJob->onQueue('inventory');
        $this->job_ids[] = dispatch($itemsJob);

        return true;
    }

}
