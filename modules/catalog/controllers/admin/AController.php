<?php
namespace app\modules\catalog\controllers\admin;

use Yii;
use app\components\CategoryController;
use app\modules\catalog\models\Category;


class AController extends CategoryController
{
    public $categoryClass = 'app\modules\catalog\models\Category';

    public $rootActions = ['fields'];

    public function actionFields($id)
    {
        if(!($model = Category::findOne($id))){
            return $this->redirect(['/'.$this->module->id.'/admin']);
        }

        if (Yii::$app->request->post('save'))
        {
            $fields = Yii::$app->request->post('Field') ?: [];
            $result = [];

            foreach($fields as $field){
                $temp = json_decode($field);

                if( $temp === null && json_last_error() !== JSON_ERROR_NONE ||
                    empty($temp->name) ||
                    empty($temp->title) ||
                    empty($temp->type) ||
                    !($temp->name = trim($temp->name)) ||
                    !($temp->title = trim($temp->title)) ||
                    !array_key_exists($temp->type, Category::$fieldTypes)
                ) {
                    continue;
                }
                $options = '';
                if($temp->type == 'select' || $temp->type == 'checkbox'){
                    if(empty($temp->options) || !($temp->options = trim($temp->options))){
                        continue;
                    }
                    $options = [];
                    foreach(explode(',', $temp->options) as $option){
                        $options[] = trim($option);
                    }
                }

                $result[] = [
                    'name' => $temp->name,
                    'title' => $temp->title,
                    'type' => $temp->type,
                    'options' => $options
                ];
            }

            $model->fields = $result;

            if($model->save()){
                $ids = [];
                foreach($model->children as $child){
                    $ids[] = $child->primaryKey;
                }
                if(count($ids)){
                    Category::updateAll(['fields' => json_encode($model->fields)], ['in', 'id', $ids]);
                }

                $this->flash('success', Yii::t('catalog', 'Категорія оновлена'));
            }
            else{
                $this->flash('error', Yii::t('app','Помилка. {0}', $model->formatErrors()));
            }
            return $this->refresh();
        }
        else {
            return $this->render('fields', [
                'model' => $model
            ]);
        }
    }

    public function actionEdit($id)
    {
        $this->view->params['submenu'] = true;

        return parent::actionEdit($id);
    }
}