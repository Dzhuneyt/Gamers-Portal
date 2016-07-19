<?php

use yii\db\Migration;

class m160710_215914_CREATE_TABLE_games extends Migration
{
    public function up()
    {
        $this->createTable('game', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'release_date' => $this->date(),
            'description' => $this->text(),
            'cover_url' => $this->string(255),
            'promo_img_url' => $this->string(255),
        ], 'ENGINE=InnoDB DEFAULT CHARACTER SET=utf8');

    }

    public function down()
    {
        $this->dropTable('game');
    }

}
