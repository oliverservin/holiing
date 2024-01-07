<?php

namespace App;

use Illuminate\Support\Facades\Validator;

class DomainWithoutWWWGenerator
{
    public function __construct(protected $url) {}

    public function generate()
    {
        $validator = Validator::make(['url' => $this->url], [
            'url' => 'url'
        ]);

        if ($validator->passes()) {
            $hostname = parse_url($this->url, PHP_URL_HOST);

            return preg_replace('/^www\./', '', $hostname);
        }

        if (strpos($this->url, ".") !== false && strpos($this->url, " ") === false) {
            $hostname = parse_url('https://' . $this->url, PHP_URL_HOST);

            return preg_replace('/^www\./', '', $hostname);
        }

        return null;
    }
}
