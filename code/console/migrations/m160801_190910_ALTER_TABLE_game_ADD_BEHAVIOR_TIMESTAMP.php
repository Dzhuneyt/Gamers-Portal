<?php

use yii\db\Migration;

class m160801_190910_ALTER_TABLE_game_ADD_BEHAVIOR_TIMESTAMP extends Migration
{
    public function up()
    {

        $this->addColumn('game', 'created_at', $this->integer()->notNull());
        $this->addColumn('game', 'updated_at', $this->integer()->notNull());
    }

    public function down()
    {
        $this->dropColumn('game', 'created_at');
        $this->dropColumn('game', 'updated_at');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
