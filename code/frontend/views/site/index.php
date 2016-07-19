<?php

/* @var $this yii\web\View */

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
            <? $i = 0; ?>
            <? foreach ($games as $game): /* @var $game Game */ ?>
                <div class="col-lg-4 lead">

                    <div class="text-center">
                        <img style="min-width: 320px; min-height: 320px; max-width: 320px; max-height: 320px;" class="img-thumbnail"
                             src="<?= $game->cover_url ?>"/>
                    </div>

                    <h2 class="lead text-center">
                        <?= $game->name ?>
                    </h2>

                    <div class="text-center">
                        <a class="btn btn-primary btn-lg" href="#">
                            Download
                        </a>
                        <a class="btn btn-default btn-lg" href="#">
                            Details
                        </a>
                    </div>
                </div>
                <?
                $i++;
                if ($i == 3) {
                    echo '</div><br/><hr/><br/><br/><div class="row">';
                    $i = 0;
                }
                ?>
            <? endforeach; ?>
        </div>

    </div>
</div>
