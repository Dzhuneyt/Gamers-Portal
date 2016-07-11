<?php
/**
 * Created by PhpStorm.
 * User: Dz
 * Date: 11.7.2016 г.
 * Time: 1:19
 */

namespace common\components\scraping;


use common\components\scraping\scraper\Scraper;

class GamespotSingleGameScraper extends Scraper
{
    public function getTitle()
    {
        $title = parent::getTitle();

        $title = str_ireplace(' - Gamespot', '', $title);
        return $title;
    }

    public function getDescription()
    {
        $html = $this->getHtml();
        $parser = $this->parser->str_get_html($html);

        $tmp = $parser->find('[class="pod-objectStats-info__deck"]', 0);
        $descr = $tmp ? trim($tmp->plaintext) : null;
        if (!$descr) {
            $descr = parent::getDescription();
        }
        return $descr;
    }

    public function getPlatformsList()
    {
        $html = $this->getHtml();
        $parser = $this->parser->str_get_html($html);

        $list = array();
        foreach ($parser->find('[itemprop="device"]') as $device) {
            $list[] = trim($device->plaintext);
        }
        return $list;
    }

    public function getReleaseDate()
    {
        $html = $this->getHtml();
        $parser = $this->parser->str_get_html($html);

        $tmp = $parser->find('[class="kubrick-info__releasedate"]', -1); // find last
        return strtotime(trim($tmp->find('span', 0)->plaintext));
    }

    public function getCoverUrl()
    {
        $html = $this->getHtml();
        $parser = $this->parser->str_get_html($html);

        $tmp = $parser->find('[class="gameObject__img"]', 0); // find first
        $tmp = $tmp->find('img', 0);
        return $tmp->src;
    }

    public function getPromoImageUrl()
    {
        $html = $this->getHtml();
        $parser = $this->parser->str_get_html($html);

        $tmp = $parser->find('#kubrick-lead', 0); // find first
        if ($tmp) {
            $tmp = $tmp->style;
            if ($tmp) {
                preg_match('#\((.*)\)#Ui', $tmp, $matches);
                if ($matches[1]) {
                    return $matches[1];
                }
            }
        }
        return false;
    }


}