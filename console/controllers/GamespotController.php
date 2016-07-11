<?php

namespace console\controllers;


use common\components\scraping\GamespotSingleGameScraper;
use common\components\scraping\GamespotTop50Scraper;
use common\models\Game;
use yii\console\Controller;

class GamespotController extends Controller
{
    public function actionScrapeComingSoonGames()
    {
        $url = 'http://www.gamespot.com/gamespot-50/';

        $scraper = new GamespotTop50Scraper($url);
        $top50GameUrls = $scraper->getTop50GameUrls();

        $scrapedGames = [];

        foreach ($top50GameUrls as $gameUrl) {
            $gameDetailsScraper = new GamespotSingleGameScraper($gameUrl);

            $gameName = $gameDetailsScraper->getTitle();
            $gameDescription = $gameDetailsScraper->getDescription();
            $gameReleaseDate = $gameDetailsScraper->getReleaseDate();
            $gameCoverImage = $gameDetailsScraper->getCoverUrl();
            $gamePromoImage = $gameDetailsScraper->getPromoImageUrl();
            $gamePlatforms = $gameDetailsScraper->getPlatformsList();

            $scrapedGames[] = [
                'name' => $gameName,
                'description' => $gameDescription,
                'release_date' => date('Y-m-d', $gameReleaseDate),
                'cover_url' => $gameCoverImage,
                'promo_img_url' => $gamePromoImage,
                'platforms' => $gamePlatforms,
            ];
            //if(count($scrapedGames)>5) break;
        }

        foreach ($scrapedGames as $gameDetails) {
            $game = new Game();

            $platforms = $gameDetails['platforms'];

            unset($gameDetails['platforms']);

            $game->setAttributes($gameDetails);

            $game->cover_url = \Yii::$app->imageUploader->upload($game->cover_url);
            $game->promo_img_url = \Yii::$app->imageUploader->upload($game->promo_img_url);

            if (!$game->save()) {
                \Yii::error($game->getErrors());
            } else {
                echo 'Saved game: ' . $game->name.'\n';
            }
        }
    }
//    public function actionScrapeGame($url)
//    {
//        $scraper = new GamespotSingleGameScraper($url);
//        $coverUrl = $scraper->getCoverUrl();
//        $promoUrl = $scraper->getPromoImageUrl();
//
//        echo \Yii::$app->imageUploader->upload($promoUrl);
//    }

}