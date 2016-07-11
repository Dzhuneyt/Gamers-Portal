<?php
/**
 * Created by PhpStorm.
 * User: Dz
 * Date: 11.7.2016 г.
 * Time: 3:06
 */

namespace common\components\scraping;


use common\components\scraping\scraper\Scraper;

class GamespotTop50Scraper extends Scraper
{

    public function __construct($url)
    {
        if (!$url) {
            $url = 'http://www.gamespot.com/gamespot-50/';
        }
        parent::__construct($url);
    }

    public function getTop50GameUrls()
    {
        $parser = $this->parser->str_get_html($this->getHtml());

        $urls = array();
        foreach ($parser->find('[class="gs50-item"]') as $top50Game) {
            $firstLink = $top50Game->find('[class="gs50-item__title"] a', 0);
            if ($firstLink && $firstLink->href) {
                $href = $firstLink->href;
                if ($href) {
                    $urls[] = 'http://www.gamespot.com' . $firstLink->href;
                }
            }
        }
        return $urls;
    }

}