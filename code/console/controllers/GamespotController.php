<?php

namespace console\controllers;


use common\components\scraping\GamespotSingleGameScraper;
use common\components\scraping\GamespotTop50Scraper;
use common\models\Game;
use common\models\GameAttributes;
use yii\console\Controller;
use yii\db\Query;

class GamespotController extends Controller
{
    public function actionScrapeComingSoonGames()
    {

        set_time_limit(600); // 10 minutes

        $gameFetchMinIntervalSeconds = 3600 * 24 * 7;

        $url = 'http://www.gamespot.com/gamespot-50/';

        $scraper = new GamespotTop50Scraper($url);
        $top50GameUrls = $scraper->getTop50GameUrls();

        $scrapedGames = [];

        echo "Scraping information for " . count($top50GameUrls) . ' games' . PHP_EOL;

        $top50GameUrls = array_slice($top50GameUrls, 0, 3);

        foreach ($top50GameUrls as $gameUrl) {

            $lastUpdateTimestamp = 0; // Never

            // Check if the game was fetched already recently
            $gameIdExisting = GameAttributes::find()->where([
                'value' => $gameUrl,
                'attribute' => GameAttributes::ATTRIBUTE_GAMESPOT_URL,
            ])->select(['game_id'])->scalar();

            if ($gameIdExisting) {
                $lastUpdateTimestamp = Game::getLastUpdateTimestamp($gameIdExisting);
            }

            $gameDetailsScraper = new GamespotSingleGameScraper($gameUrl);

            $gameName = $gameDetailsScraper->getTitle();

            if ($lastUpdateTimestamp < (time() - $gameFetchMinIntervalSeconds)) {
                // Game needs refreshing, fetched more than X days ago

                $gameDescription = $gameDetailsScraper->getDescription();
                $gameReleaseDate = $gameDetailsScraper->getReleaseDate();
                $gameCoverImage = $gameDetailsScraper->getCoverUrl();
                $gamePromoImage = $gameDetailsScraper->getPromoImageUrl();
                $gamePlatforms = $gameDetailsScraper->getPlatformsList();

                echo 'Scraping information for ' . $gameName . PHP_EOL;

                $game = new Game();
                $game->name = $gameName;
                $game->description = $gameDescription;
                $game->release_date = date('Y-m-d', $gameReleaseDate);

                $game->cover_url = \Yii::$app->imageUploader->upload($gameCoverImage);
                $game->promo_img_url = \Yii::$app->imageUploader->upload($gamePromoImage);

                if (!$game->save()) {
                    \Yii::error($game->getErrors());
                } else {
                    Game::setLastUpdateTimestamp($game->id);
                    Game::setGamespotUrl($game->id, $gameUrl);

                    echo 'Saved game: ' . $game->name . PHP_EOL;
                }

                $scrapedGames[] = [
                    'name' => $gameName,
                    'description' => $gameDescription,
                    'release_date' => date('Y-m-d', $gameReleaseDate),
                    'cover_url' => $gameCoverImage,
                    'promo_img_url' => $gamePromoImage,
                    'platforms' => $gamePlatforms,
                ];
            } else {
                // Game fetched recently, no need to fetch again
                echo 'Game already fetched recently: ' . $gameName . PHP_EOL;
            }

            usleep(rand(1000,3500));
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