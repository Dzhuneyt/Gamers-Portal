<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%game_platform}}".
 *
 * @property integer $id_game
 * @property integer $id_platform
 *
 * @property Game $idGame
 * @property Platform $idPlatform
 */
class GamePlatform extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%game_platform}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_game', 'id_platform'], 'required'],
            [['id_game', 'id_platform'], 'integer'],
            [['id_game'], 'exist', 'skipOnError' => true, 'targetClass' => Game::className(), 'targetAttribute' => ['id_game' => 'id']],
            [['id_platform'], 'exist', 'skipOnError' => true, 'targetClass' => Platform::className(), 'targetAttribute' => ['id_platform' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_game' => Yii::t('app', 'Id Game'),
            'id_platform' => Yii::t('app', 'Id Platform'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdGame()
    {
        return $this->hasOne(Game::className(), ['id' => 'id_game']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPlatform()
    {
        return $this->hasOne(Platform::className(), ['id' => 'id_platform']);
    }
}
