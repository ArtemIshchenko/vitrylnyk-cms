<?php
namespace app\modules\admin\controllers;

use Yii;
use app\helpers\WebConsole;
use app\modules\admin\models\Setting;

class SystemController extends \app\components\Controller
{
    public $rootActions = ['*'];

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionUpdate()
    {
        $result = WebConsole::migrate();

        Setting::set('version', \app\components\Application::VERSION);
        Yii::$app->cache->flush();

        return $this->render('update', ['result' => $result]);
    }

    public function actionFlushCache()
    {
        Yii::$app->cache->flush();
        $this->flash('success', Yii::t('app', 'Кеш очіщено'));
        return $this->back();
    }

    public function actionClearAssets()
    {
        foreach(glob(Yii::$app->assetManager->basePath . DIRECTORY_SEPARATOR . '*') as $asset){
            if(is_link($asset)){
                unlink($asset);
            } elseif(is_dir($asset)){
                $this->deleteDir($asset);
            } else {
                unlink($asset);
            }
        }
        $this->flash('success', Yii::t('app', 'Assets очіщені'));
        return $this->back();
    }

    public function actionLiveEdit($id)
    {
        Yii::$app->session->set('live_edit', $id);
        $this->back();
    }

    private function deleteDir($directory)
    {
        $iterator = new \RecursiveDirectoryIterator($directory, \RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new \RecursiveIteratorIterator($iterator, \RecursiveIteratorIterator::CHILD_FIRST);
        foreach($files as $file) {
            if ($file->isDir()){
                rmdir($file->getRealPath());
            } else {
                unlink($file->getRealPath());
            }
        }
        return rmdir($directory);
    }
}