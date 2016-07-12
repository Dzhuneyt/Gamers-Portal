<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "game_attributes".
 *
 * @property integer $id
 * @property integer $game_id
 * @property string $attribute
 * @property string $value
 *
 * @property Game $game
 */
class GameAttributes extends \yii\db\ActiveRecord
{

    const ATTRIBUTE_GAMESPOT_LAST_UPDATE = 'gamespot/lastupdate';
    const ATTRIBUTE_GAMESPOT_URL = 'gamespot/url';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'game_attributes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['game_id'], 'integer'],
            [['value'], 'string'],
            [['attribute'], 'string', 'max' => 255],
            [['game_id'], 'exist', 'skipOnError' => true, 'targetClass' => Game::className(), 'targetAttribute' => ['game_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'game_id' => Yii::t('app', 'Game ID'),
            'attribute' => Yii::t('app', 'Attribute'),
            'value' => Yii::t('app', 'Value'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGame()
    {
        return $this->hasOne(Game::className(), ['id' => 'game_id']);
    }
}
