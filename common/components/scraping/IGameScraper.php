<?php

namespace common\components\scraping;

interface IGameScraper
{

    public function getName();

    public function getReleaseDate();

    public function getPlatforms();

    public function getCoverUrl();

}