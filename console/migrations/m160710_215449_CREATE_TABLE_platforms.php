<?php

use yii\db\Migration;

class m160710_215449_CREATE_TABLE_platforms extends Migration
{
    public function up()
    {
        $this->createTable('platform', [
            'id'=>$this->primaryKey(),
            'name'=>$this->string(),
        ], 'ENGINE=InnoDB DEFAULT CHARACTER SET=utf8');

    }

    public function down()
    {
        $this->dropTable('platform');
    }

}
