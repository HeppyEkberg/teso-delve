<?php namespace HeppyKarlsson\Sitemap;


class Page
{
    protected $url;
    protected $changeFrequency = 'weekly';

    public function __construct($url)
    {
        $this->url = $url;
    }

    static public function route($name, $params = []) {
        return new Page(route($name, $params));
    }

    public function getUrl() {
        return $this->url;
    }

    public function changeFrequency($changeFrequency = null) {
        if(!is_null($changeFrequency)) {
            $this->changeFrequency = $changeFrequency;
            return $this;
        }

        return $this->changeFrequency;
    }

    public function __toString()
    {
        return $this->url;
    }



}