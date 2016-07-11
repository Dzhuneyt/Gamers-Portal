<?php

use yii\db\Migration;

class m160710_234836_CREAT_TABLE_games_platforms extends Migration
{
    public function up()
    {
        $this->createTable('game_platform', [
            'id_game' => $this->integer(),
            'id_platform' => $this->integer(),
            'PRIMARY KEY (`id_game`, `id_platform`)', // prevent duplicates
        ], 'ENGINE=InnoDB DEFAULT CHARACTER SET=utf8');
        $this->addForeignKey('fk-games-platforms-game', 'game_platform', 'id_game', 'game', 'id', 'CASCADE',
            'CASCADE');
        $this->addForeignKey('fk-games-platforms-platform', 'game_platform', 'id_platform', 'platform', 'id',
            'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('game_platform');
    }
}
