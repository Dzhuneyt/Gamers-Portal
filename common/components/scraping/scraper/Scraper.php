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

abstract class Scraper implements IScraper
{
    protected $url;

    protected $curl = false;
    protected $parser = false;

    private $_html = null;

    public function __construct($url)
    {
        $this->url = $url;
        $this->curl = new Curl();
        $this->parser = new HtmlDomParser();
    }

    public function getHtml($headers = array())
    {
        if($this->_html===null){
            $this->_html = $this->curl->get($this->url);
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