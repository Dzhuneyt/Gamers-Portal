<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Query;

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
 * @property GameAttributes[] $gameAttributes
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

    public static function updateGamePlatforms($id, array $gamePlatforms)
    {
        GamePlatform::deleteAll(['id_game' => $id]);

        // Pre-create new platforms
        $existingPlatforms = Platform::find()->indexBy('name')->all();
        foreach ($gamePlatforms as $platformName) {
            if (!isset($existingPlatforms[$platformName])) {
                Yii::warning('Creating new platform: ' . $platformName);

                $model = new Platform();
                $model->name = $platformName;
                if (!$model->save()) {
                    Yii::error('Unable to save platform ' . $platformName);
                    Yii::error($model->getErrors());
                } else {
                    $existingPlatforms[$platformName] = $model;
                }
            }
        }

        // Assign the game's platforms, finally
        foreach ($gamePlatforms as $platform) {
            if (!isset($existingPlatforms[$platform])) {
                continue; // Fatal error?
            }

            $model = new GamePlatform();
            $model->id_game = $id;
            $model->id_platform = $existingPlatforms[$platform]->id;
            if (!$model->save()) {
                Yii::error('Unable to assign platform ' . $platform . ' to game ' . $id);
                Yii::error($model->getErrors());
            }
        }
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
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
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
    public function getGameAttributes()
    {
        return $this->hasMany(GameAttributes::className(), ['game_id' => 'id']);
    }

    public function getPlatforms()
    {
        $platforms = $this->getGamePlatforms()->all();
        $tmp = [];
        foreach ($platforms as $platform) {
            $tmp[] = $platform->idPlatform->name;
        }
        return $tmp;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPlatforms()
    {
        return $this->hasMany(Platform::className(), ['id' => 'id_platform'])->viaTable('{{%game_platform}}',
            ['id_game' => 'id']);
    }

    public static function setLastUpdateTimestamp($gameId, $timestamp = null)
    {
        if ($timestamp === null) {
            $timestamp = time();
        }
        $model = GameAttributes::find()->where([
            'game_id' => $gameId,
            'attribute' => GameAttributes::ATTRIBUTE_GAMESPOT_LAST_UPDATE,
        ])->one();
        if (!$model) {
            $model = new GameAttributes();
            $model->game_id = $gameId;
            $model->attribute = GameAttributes::ATTRIBUTE_GAMESPOT_LAST_UPDATE;
        }
        $model->value = (string)$timestamp;
        if (!$model->save()) {
            Yii::error($model->getErrors());
            return false;
        } else {
            return true;
        }

    }

    /**
     * @param $url
     * @return Game
     */
    public static function findGameByGamespotUrl($url)
    {
        return Game::find()->joinWith('gameAttributes')->where([
            'game_attributes.attribute' => GameAttributes::ATTRIBUTE_GAMESPOT_URL,
            'game_attributes.value' => $url
        ])->one();
    }

    public function getLastUpdateTimestamp($gameId = null)
    {
        if (!$gameId) {
            $gameId = $this->id;
        }

        return (int)(new Query())->select('value')
            ->from(GameAttributes::tableName())
            ->where(['attribute' => GameAttributes::ATTRIBUTE_GAMESPOT_LAST_UPDATE])
            ->andWhere(['game_id' => $gameId])
            ->scalar();
    }

    public static function setGamespotUrl($gameId, $gamespotUrl)
    {
        $model = GameAttributes::find()->where([
            'game_id' => $gameId,
            'attribute' => GameAttributes::ATTRIBUTE_GAMESPOT_URL
        ])->one();
        if (!$model) {
            $model = new GameAttributes();
            $model->game_id = $gameId;
            $model->attribute = GameAttributes::ATTRIBUTE_GAMESPOT_URL;
        }

        $model->value = $gamespotUrl;

        if (!$model->save()) {
            Yii::error($model->getErrors());
            return false;
        } else {
            return true;
        }
    }

    public static function getGamespotUrl($gameId)
    {
        return (new Query())->select('value')
            ->from(GameAttributes::tableName())
            ->where(['attribute' => GameAttributes::ATTRIBUTE_GAMESPOT_URL])
            ->andWhere(['game_id' => $gameId])
            ->scalar();
    }
}
