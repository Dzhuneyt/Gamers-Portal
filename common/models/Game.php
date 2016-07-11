<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%game}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $release_date
 * @property string $description
 * @property string $cover_url
 * @property string $promo_img_url
 *
 * @property GamePlatform[] $gamePlatforms
 * @property Platform[] $idPlatforms
 */
class Game extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%game}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description', 'release_date', 'cover_url', 'promo_img_url'], 'safe'],
            [['description'], 'string'],
            [['name', 'cover_url', 'promo_img_url'], 'string', 'max' => 255],
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
            'release_date' => Yii::t('app', 'Release Date'),
            'description' => Yii::t('app', 'Description'),
            'cover_url' => Yii::t('app', 'Cover Url'),
            'promo_img_url' => Yii::t('app', 'Promo Img Url'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGamePlatforms()
    {
        return $this->hasMany(GamePlatform::className(), ['id_game' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPlatforms()
    {
        return $this->hasMany(Platform::className(), ['id' => 'id_platform'])->viaTable('{{%game_platform}}', ['id_game' => 'id']);
    }
}
