<?php

/* @var $this yii\web\View */
/* @var $games Game[] */
/* @var $hotGames Game[] */
/* @var $spotlight Game */

use common\models\Game;

$this->title = 'Latest Games';

?>
<div class="site-index">

    <div class="jumbotron">
        <h1><?= $this->title ?></h1>

        <p class="lead">Download from a wide selection of latest released games.</p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-7">
                <div class="panel panel-default">
                    <div
                        style="width: 100%; height: 100%; min-height: 300px; background-image: url('<?= $spotlight->promo_img_url ?>'); background-size: cover;">
                        &nbsp;
                    </div>

                    <h2 class="" style="margin: 20px;">
                        <a href="<?= \yii\helpers\Url::to(['game/details', 'id' => $spotlight->id]) ?>">
                            <?= $spotlight->name ?>
                        </a>
                    </h2>

                    <div class="lead" style="margin: 20px;">
                        <?= $spotlight->description ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="panel2 panel-default">
                    <h2 class="text-center" style="margin:0">Hot Games:</h2>

                    <br/>

                    <div class="row">
                        <? foreach ($hotGames as $hotGame): ?>
                            <div class="col-lg-4 text-center">

                                <div>
                                    <a href="<?= \yii\helpers\Url::to(['game/details', 'id' => $hotGame->id]) ?>">
                                        <img style="width: 120px;" src="<?= $hotGame->cover_url ?>"/>
                                    </a>
                                </div>
                                <h3>
                                    <a href="<?= \yii\helpers\Url::to(['game/details', 'id' => $hotGame->id]) ?>">
                                        <small>
                                            <?= $hotGame->name ?>
                                        </small>
                                    </a>
                                </h3>

                                <br/>

                            </div>
                        <? endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <br/><br/><br/>

        <hr/>

        <h2 class="text-center text-capitalize">
            More games:
        </h2>

        <br/>

        <div class="row">
            <? $i = 0; ?>
            <? foreach ($games as $game): /* @var $game Game */ ?>
                <div class="col-lg-6 lead">

                    <div class="media">
                        <div class="media-left">
                            <a href="<?= \yii\helpers\Url::to(['game/details', 'id' => $game->id]) ?>">
                                <img style="width: 90px;" class="media-object img-thumbnail"
                                     src="<?= $game->cover_url ?>"" alt="...">
                            </a>
                        </div>
                        <div class="media-body">
                            <h3 class="media-heading">
                                <a href="<?= \yii\helpers\Url::to(['game/details', 'id' => $game->id]) ?>">
                                    <?= $game->name ?>
                                </a>
                            </h3>

                            <div>
                                <?= $game->description ?>
                            </div>
                        </div>
                    </div>

                </div>
                <?
                $i++;
                if ($i == 2) {
                    echo '</div><br/><br/><div class="row">';
                    $i = 0;
                }
                ?>
            <? endforeach; ?>
        </div>


    </div>
</div>
