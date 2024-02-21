<?php

namespace App\Livewire\ShortLinks\Create;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Livewire\Form;
use Symfony\Component\DomCrawler\Crawler;
use Throwable;

class SocialPreview extends Form
{
    public $title;

    public $description;

    public $image;

    public $domain;

    public function fillMetaData($url)
    {
        try {
            $response = Http::get($url);
        } catch (Throwable $e) {
            return;
        }

        $crawler = new Crawler($response->body());

        if ($crawler->filter('title')->count() > 0) {
            $titleTag = $crawler->filter('title')->first()->text();
        } else {
            $titleTag = null;
        }

        if ($crawler->filter('meta[property="og:title"], meta[property="twitter:title"]')->count() > 0) {
            $this->title = $crawler->filter('meta[property="og:title"], meta[property="twitter:title"]')->first()->attr('content') ?? $titleTag;
        } else {
            $this->title = $titleTag;
        }

        $descriptionNodeList = $crawler->filter('meta[name="description"], meta[property="twitter:description"], meta[property="og:description"]');
        $this->description = $descriptionNodeList->count() > 0 ? $descriptionNodeList->first()->attr('content') : null;

        $imageNodeList = $crawler->filter('meta[property="og:image"], meta[property="twitter:image"]');
        $this->image = $imageNodeList->count() > 0 ? $imageNodeList->first()->attr('content') : null;

        $this->domain = Str::of($url)->domain();
    }
}
