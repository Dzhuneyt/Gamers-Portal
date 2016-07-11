<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%platform}}".
 *
 * @property integer $id
 * @property string $name
 *
 * @property GamePlatform[] $gamePlatforms
 * @property Game[] $idGames
 */
class Platform extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%platform}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGamePlatforms()
    {
        return $this->hasMany(GamePlatform::className(), ['id_platform' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdGames()
    {
        return $this->hasMany(Game::className(), ['id' => 'id_game'])->viaTable('{{%game_platform}}', ['id_platform' => 'id']);
    }
}
