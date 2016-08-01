<?php
/* @var $this yii\web\View */
/* @var $model \common\models\Game */
/* @var $related \common\models\Game[] */
$this->title = $model->name;
?>
<div id="game-details">

    <div id="cover" style="background-image: url('<?= $model->promo_img_url ?>');">
        &nbsp;

        <div class="row">
            <div id="thumb" class="pull-left">
                <img src="<?= $model->cover_url ?>"/>
            </div>
            <div id="game-metadata" class="pull-left">
                <h1 class="text-capitalize"><?= $model->name ?></h1>
                <p>Released: 2106</p>
                <p>Platforms: <?= implode(', ', $model->getPlatforms()); ?></p>
                <p>
                    <a class="btn btn-primary">Download</a>
                </p>
            </div>
            <div class="clearfix"></div>


        </div>

        <div id="description">
            <?= $model->description ?>
        </div>
    </div>

    <div>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#trailers" aria-controls="trailers" role="tab"
                                                      data-toggle="tab">
                    <h4>Gameplay Videos and Trailers</h4>
                </a></li>
            <li role="presentation"><a href="#news" aria-controls="news" role="tab" data-toggle="tab">
                    <h4>News</h4>
                </a></li>
            <li role="presentation"><a href="#comments" aria-controls="comments" role="tab" data-toggle="tab">
                    <h4>Discussion Forum</h4>
                </a></li>
            <li role="presentation"><a href="#reviews" aria-controls="reviews" role="tab" data-toggle="tab">
                    <h4>Reviews</h4>
                </a></li>
            <li role="presentation"><a href="#cheats" aria-controls="cheats" role="tab" data-toggle="tab">
                    <h4>Cheat Codes</h4>
                </a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content lead">
            <div role="tabpanel" class="tab-pane" id="news">
                <p>
                    Latest news and updates on <?= $model->name ?>. At the moment, there are no news
                    for <?= $model->name ?>.
                </p>
            </div>
            <div role="tabpanel" class="tab-pane active" id="trailers">
                <p>
                    Here you can find the latest <b><?= $model->name ?> gameplay videos</b> and <b><?= $model->name ?>
                        trailers</b>.
                </p>

                <br/>

                <!-- Common video player Modal -->
                <div class="modal fade bs-example-modal-lg" id="video-player" tabindex="-1" role="dialog"
                     aria-labelledby="myModalLabel">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title"></h4>
                            </div>
                            <div class="modal-body">

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                <? foreach ($videos as $video): ?>
                    <?
                    $videoId = $video->id->videoId;
                    $title = $video->snippet->title;
                    $rand = sha1($videoId);
                    ?>
                    <div class="media">
                        <div class="media-left">
                            <a class="play-trailer" data-title="<?=$title?>" data-video-id="<?=$videoId?>">
                                <img style="width: 90px;" class="media-object img-thumbnail"
                                     src="<?= $video->snippet->thumbnails->default->url ?>" alt="...">
                            </a>
                        </div>
                        <div class="media-body">
                            <h3 class="media-heading">
                                <?= $video->snippet->title ?>
                            </h3>

                            <div>
                                <?= $video->snippet->description ?>
                            </div>
                        </div>
                    </div>

                <? endforeach; ?>
            </div>
            <div role="tabpanel" class="tab-pane" id="comments">
                <p>
                    This is the thread for discussing and commenting all things related to <?= $model->name ?>.
                    At the moment, there are no <b>comments for <?= $model->name ?></b>. Would you like to leave one?
                </p>
            </div>
            <div role="tabpanel" class="tab-pane" id="reviews">
                <p>
                    A collection of <b>reviews for <?= $model->name ?></b> from all around the internet. Check them and
                    see
                    what the experts think about <?= $model->name ?>.
                    No reviews for <?= $model->name ?> yet.
                </p>
            </div>
            <div role="tabpanel" class="tab-pane" id="cheats">
                <p>
                    This is the page where you can find <b>cheat codes and hacks for <?= $model->name ?></b>.
                    Currently, there are 0 cheat codes associated with <?= $model->name ?> .
                </p>
            </div>
        </div>

    </div>

    <div id="related-games">
        <h4>
            <b>Related games:</b>
        </h4>
        <br/>
        <div class="row">
            <? foreach ($related as $relatedGame): ?>
                <div class="col-lg-4">
                    <div class="pull-left thumb">
                        <img src="<?= $relatedGame->cover_url ?>"/>
                    </div>
                    <h3>
                        <a href="<?= \yii\helpers\Url::to(['game/details', 'id' => $relatedGame->id]) ?>">
                            <?= $relatedGame->name ?>
                        </a>
                    </h3>
                    <div>
                        <? $descr = $relatedGame->description; ?>
                        <?= strlen($descr) > 100 ? substr($descr, 0, 100) . "..." : $descr; ?>
                    </div>
                </div>
            <? endforeach; ?>
        </div>
        <br/>
    </div>

</div>