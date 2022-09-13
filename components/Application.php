<?php

namespace app\components;

use Yii;
use yii\web\View;
use yii\web\Response;
use app\modules\admin\models\Module;
/**
 * Main application class
 */
class Application extends \yii\web\Application {
	const VERSION = 0.0;
	
	public $activeModules;
	private $_installed;
	
	public function __construct($config=[]) {
		parent::__construct($config);
	}
	
	/**
	 * Initialize component
	 */
	public function init() {
			if(strpos($this->request->pathInfo, 'install')!==false)
				Yii::$app->urlManager->addRules(['install/<action>' => 'install/<action>']);
			if($this->cache === null) {
				throw new \yii\web\ServerErrorHttpException('Будь ласка, зконфігуруйте компонент cache.');
			}
			$this->activeModules = Module::findAllActive();
			$modules = [];
			foreach($this->activeModules as $name => $module) {
				$modules[$name]['class'] = $module->class;
				if(is_array($module->settings)) {
					$modules[$name]['settings'] = $module->settings;
				}
				$moduleClass = $module->class;
				if($routes = $moduleClass::$routes)
					Yii::$app->urlManager->addRules($routes);
			}
			$this->setModules($modules);
			define('IS_ROOT', !$this->user->isGuest && $this->user->identity->isRoot());
			define('LIVE_EDIT', !$this->user->isGuest && $this->session->get('live_edit'));
			if(!$this->user->isGuest && strpos($this->request->pathInfo, 'admin') === false) {
				Yii::$app->on(self::EVENT_BEFORE_REQUEST, function () {
					$this->getView()->on(View::EVENT_BEGIN_BODY, [$this, 'renderToolbar']);
				});
			}
			if(strpos($this->request->pathInfo, 'admin') === false && strpos($this->request->pathInfo, 'install') === false && strpos($this->request->pathInfo, 'debug/default/toolbar') === false && \app\models\Setting::get('counters')=='enable')
				Yii::$app->response->on(Response::EVENT_AFTER_SEND, ['\app\models\Counter', 'setCounters']);
			parent::init();
	}
	
	public function renderToolbar()
  {
    $view = Yii::$app->getView();
    echo $view->render('@app/views/layouts/frontend-toolbar.php');
  }

	public function getInstalled()
  {
    if($this->_installed === null) {
      try {
				$this->_installed = Yii::$app->db->createCommand("SHOW TABLES LIKE '%'")->query()->count() > 0 ? true : false;
      } catch (\Exception $e) {
        $this->_installed = false;
        }
    }
    return $this->_installed;
  }
}
