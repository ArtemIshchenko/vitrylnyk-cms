<?php

namespace app\modules\article\models;

use Yii;
use yii\validators\UniqueValidator;
use app\modules\article\models\Part;
use app\modules\article\models\Attribute;
use app\modules\article\models\Value;
use app\modules\article\models\Image;
use app\components\ControlPosBehavior;
use app\components\BreadcrumbsBehavior;
/**
 * This is the model class for table "item".
 *
 * @property integer $id
 * @property integer $part_id
 * @property string $name
 * @property string $url
 * @property integer $is_active
 * @property string $meta_title
 * @property string $meta_description
 * @property string $meta_keywords
 * @property integer $pos
 */
class Item extends \yii\db\ActiveRecord
{
		public $saveImageModel = false;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'required', 'message'=>'Заповніть, будь ласка, поле "{attribute}"'],
						['name', 'unique1'],
						['url', 'unique2'],
						['name', 'string', 'min'=>2, 'max'=>70,
						'tooShort'=>'Кількість символів в полі "{attribute}" повинно буди не меньше 2',
						'tooLong'=>'Кількість символів в полі "{attribute}" повинно буди не більше 50'],
            [['id', 'part_id'], 'integer'],
            [['is_active', 'pos', 'meta_title', 'meta_description', 'meta_keywords'], 'safe']
        ];
    }
		public function unique1($attribute,$params) {
			$unique = new UniqueValidator();
			$unique->message = '{attribute} "{value}" вже є';
			$unique->filter=['part_id'=>$this->part_id];
			$unique->validateAttribute($this,$attribute);
		}
		public function unique2($attribute,$params) {
			$unique = new UniqueValidator();
			$unique->message = '{attribute} "{value}" вже є';
			$unique->filter=['part_id'=>$this->part_id];
			$unique->validateAttribute($this,$attribute);
			$unique->targetClass = 'app\modules\article\models\Article';
			$unique->validateAttribute($this,$attribute);
		}

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
						'part_id' => 'Разділ',
						'name' => 'Назва',
						'url' => 'Url переліку',
						'is_active' => 'Видимість',
						'meta_title' => 'Заголовок сторінки',
						'meta_description' => 'Опис сторінки',
						'meta_keywords' => 'Ключьові слова',
						'pos' => 'Поз.',
        ];
    }
		public function getPart() {
			return $this->hasOne(Part::className(), ['id'=>'part_id']);
		}
		public function getAttributesList() {
			return $this->hasMany(Attribute::className(), ['item_id'=>'id'])
									->where('is_active=true')
									->orderBy('pos');
		}
		public function getValues() {
			return $this->hasMany(Value::className(), ['item_id'=>'id'])
									->orderBy('pos');
		}
		public function getParts() {
			return $this->hasMany(Part::className(), ['parent_id'=>'id'])
									->orderBy('pos');
		}
		public function getAttributeCount() {
			return $this->getAttributesList->count();
		}
		public function getRImage() {
			return $this->hasOne(Image::className(), ['item_id'=>'id']);
		}
		private $_image;
		public function setImage($value) {
			$this->_image = $value;
		}
		public function getImage() {
			if(!empty($this->_image))
				return $this->_image;
			else
				return $this->rImage;
		}
		public function behaviors() {
				return [
					ControlPosBehavior::className(),
					BreadcrumbsBehavior::className(),
				];
		}
		public function beforeValidate() {
			if(!empty($this->image) && (!empty($this->image->name) || !empty($this->image->alt)))
				$this->saveImageModel = true;
			return parent::beforeValidate();
		}
		public function beforeSave($insert) {
			if(parent::beforeSave($insert)) {
				if($insert)
					$this->setNextPos();
				return true;
			}
			else
				return false;
		}
		public function afterFind() {
			if(empty($this->image))
				$this->image = new Image();
			parent::afterFind();
		}
		public function afterSave($insert, $changedAttributes) {
			if($this->saveImageModel && !empty($this->image)) {
				$this->image->attributes = ['item_id'=>$this->primaryKey];
				$this->image->save(false);
			}
		}
		public function afterDelete() {
			foreach($this->values as $value)
				$value->delete();
			foreach($this->attributesList as $value)
				$value->delete();
			if(!empty($this->image) && !$this->image->isNewRecord)
				$this->image->delete();
			$this->recalcPos();
			parent::afterDelete();
		}
		public function getParams() {
			$params = [];
			if(isset($_GET['page']))
				$params['page'] = $_GET['page'];
			if(isset($_GET['per-page']))
				$params['per-page'] = $_GET['per-page'];
			return $params;
		}
}
