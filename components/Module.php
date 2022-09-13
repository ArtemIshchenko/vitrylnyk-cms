<?php
namespace app\components;

use Yii;
use app\modules\admin\models\Module as ModuleModel;

/**
 * Base module class. Inherit from this if you are creating your own modules manually
 * @package yii\easyii\components
 */
class Module extends \yii\base\Module
{
    /** @var array  */
    public $settings = [];

    /** @var  @todo */
    public $i18n;
		
		public static $routes = [];
		
		/**
     * Configuration for installation
     * @var array
     */
    public static $installConfig = [
        'title' => [
            'en' => 'Custom Module',
        ],
        'icon' => 'asterisk',
        'order_num' => 0,
    ];

    public function init()
    {
        parent::init();
				$moduleName = self::getModuleName(self::className());
        self::registerTranslations($moduleName);
    }

    /**
     * Registers translations connected to the module
     * @param $moduleName string
     */
    public static function registerTranslations($moduleName)
    {
			$moduleClassFile = '';
        foreach(ModuleModel::findAllActive() as $name => $module) {
            if($name == $moduleName){
                $moduleClassFile = (new \ReflectionClass($module->class))->getFileName();
                break;
            }
        }
				if($moduleClassFile) {			
					Yii::$app->i18n->translations[$moduleName . '*'] = [
						'class' => 'yii\i18n\PhpMessageSource',
						'sourceLanguage' => 'uk-UA',
						'basePath' => dirname($moduleClassFile) . DIRECTORY_SEPARATOR . 'messages',
						'fileMap' => [
							$moduleName => 'app.php',
							$moduleName . '/api' => 'api.php'
						]
					];
				}
		}
	
	   /**
     * Module name getter
     *
     * @param $namespace
     * @return string|bool
     */
    public static function getModuleName($namespace)
    {
        foreach(ModuleModel::findAllActive() as $module)
        {
            $moduleClassPath = preg_replace('/[\w]+$/', '', $module->class);
            if(strpos($namespace, $moduleClassPath) !== false){
                return $module->name;
            }
        }
        return false;
    }
}