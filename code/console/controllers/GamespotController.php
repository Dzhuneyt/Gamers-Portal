<?php

namespace console\controllers;


use common\components\scraping\GamespotSingleGameScraper;
use common\components\scraping\GamespotTop50Scraper;
use common\models\Game;
use common\models\GameAttributes;
use Exception;
use Yii;
use yii\console\Controller;
use yii\db\Query;

class GamespotController extends Controller
{
    public function actionComingSoon()
    {

        set_time_limit(600); // 10 minutes

        $gameFetchMinIntervalSeconds = 3600 * 24 * 3;

        $url = 'http://www.gamespot.com/gamespot-50/';

        $scraper = new GamespotTop50Scraper($url);
        $top50GameUrls = $scraper->getTop50GameUrls();

        $scrapedGames = [];

        echo "Scraping information for " . count($top50GameUrls) . ' games' . PHP_EOL;

        //$top50GameUrls = array_slice($top50GameUrls, 0, 3);

        foreach ($top50GameUrls as $gameUrl) {
            $transaction = \Yii::$app->getDb()->getTransaction() ? \Yii::$app->getDb()->getTransaction() : \Yii::$app->getDb()->beginTransaction();

            try {

                // Check if the game was fetched already recently
                $game = Game::findGameByGamespotUrl($gameUrl);

                if ($game) {
                    $lastUpdateTimestamp = $game->getLastUpdateTimestamp();
                } else {
                    $game = new Game();
                    $lastUpdateTimestamp = 0;
                }

                if ($lastUpdateTimestamp < (time() - $gameFetchMinIntervalSeconds)) {
                    // Game needs refreshing, fetched more than X days ago

                    // Prepare the scraper
                    $gameDetailsScraper = new GamespotSingleGameScraper($gameUrl);

                    $gameName = $gameDetailsScraper->getTitle();
                    $gameDescription = $gameDetailsScraper->getDescription();
                    $gameReleaseDate = $gameDetailsScraper->getReleaseDate();
                    $gameCoverImage = $gameDetailsScraper->getCoverUrl();
                    $gamePromoImage = $gameDetailsScraper->getPromoImageUrl();
                    $gamePlatforms = $gameDetailsScraper->getPlatformsList();

                    $game->name = $gameName;
                    $game->description = $gameDescription;
                    $game->release_date = date('Y-m-d', $gameReleaseDate);

                    $coverUrl = \Yii::$app->imageUploader->upload($gameCoverImage);
                    if ($coverUrl) {
                        $game->cover_url = $coverUrl;
                    }

                    $promoImgUrl = \Yii::$app->imageUploader->upload($gamePromoImage);
                    if ($promoImgUrl) {
                        $game->promo_img_url = \Yii::$app->imageUploader->upload($gamePromoImage);
                    }

                    if (!$game->save()) {
                        \Yii::error($game->getErrors());
                        throw new \yii\base\Exception('Unable to save game ' . $game->name . ' due to ' . print_r($game->getFirstErrors(),
                                true));
                    } else {

                        Game::setLastUpdateTimestamp($game->id);
                        Game::setGamespotUrl($game->id, $gameUrl);

                        Game::updateGamePlatforms($game->id, $gamePlatforms);

                        echo 'Saved game: ' . $game->name . PHP_EOL;

                        $scrapedGames[] = [
                            'name' => $gameName,
                            'description' => $gameDescription,
                            'release_date' => date('Y-m-d', $gameReleaseDate),
                            'cover_url' => $gameCoverImage,
                            'promo_img_url' => $gamePromoImage,
                            'platforms' => $gamePlatforms,
                        ];
                    }
                } else {
                    // Game fetched recently, no need to fetch again
                    echo 'Game fresh enough. No need to fetch. URL was: ' . $gameUrl . PHP_EOL;
                }

                $transaction->commit();

                usleep(rand(1000, 3500));
            } catch (Exception $e) {
                $transaction->rollBack();
            }

            if(count($scrapedGames)>=9){
                break;
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