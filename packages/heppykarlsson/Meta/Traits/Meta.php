<?php namespace HeppyKarlsson\Meta\Traits;

use HeppyKarlsson\Meta\Model\Meta as MetaModel;

trait Meta
{

    public function meta() {
        return $this->morphMany(MetaModel::class, 'metable');
    }

    public function getMeta($key) {
        $meta = $this->meta->where('key', $key)->first();

        return is_null($meta) ? null : $meta->value;
    }

    public function setMeta($key, $value) {
        $meta = $this->meta->where('key', $key)->first();

        if(is_null($meta)) {
            $meta = new MetaModel();
        }

        if($meta->value === $value) {
            return true;
        }

        $meta->key = $key;
        $meta->value = $value;
        $this->meta()->save($meta);
        return true;
    }

}