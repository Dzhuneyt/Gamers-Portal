<?php
/**
 * Created by PhpStorm.
 * User: Dz
 * Date: 11.7.2016 г.
 * Time: 1:10
 */

namespace common\components\scraping\scraper;


use linslin\yii2\curl\Curl;
use Sunra\PhpSimple\HtmlDomParser;
use Yii;

abstract class Scraper implements IScraper
{
    protected $url;

    protected $curl = false;
    protected $parser = false;

    public $cacheDays = 3; // Zero for no cache

    private $_html = null;

    public function __construct($url)
    {
        $this->url = $url;
        $this->curl = new Curl();
        $this->curl->setOption(CURLOPT_USERAGENT,
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.103 Safari/537.36');
        $this->curl->setOption(CURLOPT_REFERER, $url);
        $this->parser = new HtmlDomParser();
    }

    public function getHtml($headers = array())
    {
        if ($this->cacheDays > 0) {
            // Cache enabled, try cache hit first
            $cacheHit = \Yii::$app->cache->get('game_html:' . $this->url);
            if ($cacheHit) {
                $this->_html = $cacheHit;
                Yii::info('Cache hit for '.$this->url);
            }
        }

        if ($this->_html === null) {
            $this->_html = $this->curl->get($this->url);
            \Yii::$app->cache->set('game_html:' . $this->url, $this->_html, $this->cacheDays * 3600 * 24);
            Yii::info('Cache save for '.$this->url);
        }
        return $this->_html;
    }

    public function getTitle()
    {
        $html = $this->getHtml();
        $parser = $this->parser->str_get_html($html);
        return $parser->find('title', -1)->plaintext;
    }

    public function getDescription()
    {
        $html = $this->getHtml();
        $parser = $this->parser->str_get_html($html);
        return $parser->find('meta[name="description"]', 0)->content;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function getUrl()
    {
        return $this->url;
    }


}