<?php

use yii\db\Migration;

class m160712_174834_CREATE_TABLE_game_attributes extends Migration
{
    public function up()
    {
        $this->createTable('game_attributes', [
            'id' => $this->primaryKey(),
            'game_id'=>$this->integer(),
            'attribute' => $this->string(),
            'value' => $this->text(),
        ], 'ENGINE=InnoDB DEFAULT CHARACTER SET=utf8');
        $this->addForeignKey('fk-game-attributes-to-game-id', 'game_attributes', 'game_id', 'game', 'id', 'CASCADE', 'CASCADE');

    }

    public function down()
    {
        $this->dropTable('game_attributes');
    }

}
