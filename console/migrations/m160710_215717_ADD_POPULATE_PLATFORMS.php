<?php

use yii\db\Migration;

class m160710_215717_ADD_POPULATE_PLATFORMS extends Migration
{
    public function up()
    {
        $this->insert('platform', ['name' => 'PC']);
        $this->insert('platform', ['name' => 'PS3']);
        $this->insert('platform', ['name' => 'PS4']);
        $this->insert('platform', ['name' => 'Xbox One']);
        $this->insert('platform', ['name' => 'Xbox 360']);
        $this->insert('platform', ['name' => 'Wii U']);
        $this->insert('platform', ['name' => 'Vita']);
        $this->insert('platform', ['name' => '3DS']);
    }

    public function down()
    {
        $this->truncateTable('platform');
    }

}
