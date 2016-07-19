<?php
/**
 * Created by PhpStorm.
 * User: Dz
 * Date: 11.7.2016 г.
 * Time: 1:09
 */

namespace common\components\scraping\scraper;


interface IScraper
{

    public function getHtml($headers = array());

    public function getTitle();

    public function getDescription();

    public function setUrl($url);

    public function getUrl();

}