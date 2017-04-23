<?php namespace HeppyKarlsson\Sluggify\Traits;


trait Sluggify
{

    static public function bootSluggify() {
        static::saving(function($model){
            $model->generateSlug();
        });
    }

    public function generateSlug() {
        foreach($this->sluggify['slugs'] as $slugColumn => $valueColumn) {
            $value = '';

            if(is_array($valueColumn)) {
                foreach($valueColumn as $column) {
                    $value = $value . " " .$this->$column;
                }
            }
            else {
                $value = trim($this->$valueColumn);
                if(empty(trim($this->$valueColumn))) {
                    $value = $this->id;
                }
            }

            $value = str_ireplace("'", '', $value);

            $value = str_slug($value);
            $this->$slugColumn = empty(trim($value)) ? null : $value;
        }
    }

    public function getRouteKeyName()
    {
        if(isset($this->sluggify['routeKey'])) {
            return $this->sluggify['routeKey'];
        }

        return 'id';
    }


}