<?php
namespace app\components;

use Yii;
use app\behaviors\SluggableBehavior;
use app\behaviors\SeoBehavior;

/**
 * Base CategoryModel. Shared by categories
 * @package yii\easyii\components
 * @inheritdoc
 */
class CategoryModel extends BaseCategoryModel
{

    public function rules()
    {
        return [
            ['title', 'required', 'message'=>Yii::t('app', 'Заповніть, будь ласка, поле "{attribute}"')],
            ['title', 'trim'],
            [['title', 'slug'], 'string', 'max' => 128, 'message'=>Yii::t('app', 'Кількість символів не повинна перевищувати 128')],
            ['image', 'image', 'message'=>Yii::t('app', 'Файл зображення завантаженний некорректно')],
            ['slug', 'match', 'pattern' => self::$SLUG_PATTERN, 'message' => Yii::t('app', 'Мітка може вміщувати тільки символи "0-9", "a-z" і "-"')],
            ['slug', 'default', 'value' => null],
						['parent_id', 'default', 'value' => 0],
            [['status', 'pos'], 'safe'],
						[['title', 'image', 'slug', 'status', 'pos'], 'safe', 'on'=>'search']
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => Yii::t('app', 'Им\'я'),
            'image' => Yii::t('app', 'Малюнок'),
            'slug' => Yii::t('app', 'Мітка'),
        ];
    }

    public function behaviors()
    {
				$parentsBehaviors = parent::behaviors();
        $behaviors = [
            'seoBehavior' => SeoBehavior::className(),
            'sluggable' => [
                'class' => SluggableBehavior::className(),
                'attribute' => 'title',
                'ensureUnique' => true
            ],
        ];
			return array_merge($parentsBehaviors, $behaviors);
    }
}