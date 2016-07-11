<?php
/**
 * Created by PhpStorm.
 * User: Dz
 * Date: 11.7.2016 г.
 * Time: 1:54
 */

namespace common\components;

use Unirest\Request;


class ImageUploader
{

    public $mashapeKey;
    public $imgurClientId;

    public function upload($url)
    {
        // These code snippets use an open-source library.
        $response = Request::post("https://imgur-apiv3.p.mashape.com/3/image",
            array(
                "X-Mashape-Key" => $this->mashapeKey,
                "Authorization" => "Client-ID " . $this->imgurClientId,
                "Content-Type" => "application/x-www-form-urlencoded",
                "Accept" => "application/json"
            ),
            'image=' . trim($url)
        );

        if ($response->code != 200) {
            \Yii::error('Image upload failed for URL ' . $url . ' with error code ' . $response->code);
            \Yii::error($response->body);
            return false;
        } else {
            return $response->body->data->link;
        }

    }

}