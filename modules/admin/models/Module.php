<?php
namespace app\modules\admin\models;

use Yii;

use app\helpers\Data;
use app\helpers\WebConsole;
use app\behaviors\CacheFlush;
use app\behaviors\ControlPositionModel;
use yii\data\ActiveDataProvider;

class Module extends \app\components\ActiveRecord
{
    const CACHE_KEY = 'module';
		const STATUS_OFF= 0;
    const STATUS_ON = 1;
		
    public static function tableName()
    {
        return 'module';
    }

    public function rules()
    {
        return [
            [['name', 'class', 'title'], 'required', 'message'=>Yii::t('app', 'Заповніть, будь ласка, поле "{attribute}"')],
            [['name', 'title', 'icon'], 'trim'],
            ['name', 'match', 'pattern' => '/^[a-z]+$/', 'message'=>Yii::t('app', 'Назва модуля повинна складатись з літер')],
            ['name', 'unique', 'message'=>Yii::t('app', 'Модуль з такою назвою вже існує')],
						['class', 'classExistsCheck'],
            ['icon', 'string'],
						['status', 'default', 'value' => 1],
            [['pos', 'status', 'settings'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Ідентифікатор'),
						'class' => Yii::t('app', 'Класс'),
            'title' => Yii::t('app', 'Им\'я'),
            'icon' => Yii::t('app', 'Ярлик'),
            'pos' => Yii::t('app', 'Позиція'),
        ];
    }


    public function behaviors()
    {
        return [
            CacheFlush::className(),
            ControlPositionModel::className()
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if(!$this->settings || !is_array($this->settings)) {
								if($insert && !empty($this->class)) {
									$this->settings = Yii::createObject($this->class,['id'])->settings;
								}
								else
									$this->settings = self::getDefaultSettings($this->name);
            }
            $this->settings = json_encode($this->settings);
						if($insert)
							$this->makeMigration();
            return true;
        } else {
            return false;
        }
    }
		
		public function makeMigration()
		{
				$path = str_replace('\\', '/', $this->class);
				$moduleId = lcfirst(basename($path));
				WebConsole::migrate($moduleId);
		}
		
    public function afterFind()
    {
        parent::afterFind();
        $this->settings = $this->settings !== '' ? json_decode($this->settings, true) : self::getDefaultSettings($this->name);
    }

    public static function findAllActive()
    {
        return Data::cache(self::CACHE_KEY, 3600, function() {
            $result = [];
            try {
                foreach (self::find()->where(['status' => self::STATUS_ON])->sortPos()->all() as $module) {
                    $result[$module->name] = (object)$module->attributes;
                }
            } catch(\yii\db\Exception $e){}

            return $result;
        });
    }

    public function setSettings($settings)
    {
        $newSettings = [];
        foreach($this->settings as $key => $value){
            $newSettings[$key] = is_bool($value) ? ($settings[$key] ? true : false) : ($settings[$key] ? $settings[$key] : '');
        }
        $this->settings = $newSettings;
    }

    public function classExistsCheck($attribute, $params)
    {
				if (!$this->hasErrors()) {
					if(!class_exists($this->class)) {
							$this->addError($attribute, Yii::t('app', 'Класс не існує'));
					}
				}
    }
		
		public function getParentInfo()
		{
			return false;
		}

    public static function getDefaultSettings($moduleName)
    {
				$modules = Yii::$app->activeModules;
        if(isset($modules[$moduleName])){
            return Yii::createObject($modules[$moduleName]->class, [$moduleName])->settings;
        } else {
            return [];
        }
    }
		
		public static function search()
		{
				$data = new ActiveDataProvider([
            'query' => self::find()->sortPos(),
        ]);
				return $data;
		}

}