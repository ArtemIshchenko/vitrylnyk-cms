<?php
namespace app\modules\admin\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\UploadedFile;
use yii\web\Response;

use app\helpers\Image;
use app\components\Controller;
use app\models\Photo;
use app\behaviors\ControlPositionController;

class PhotosController extends Controller
{
    public function behaviors()
    {
        return [
            [
                'class' => 'yii\filters\ContentNegotiator',
                'formats' => [
                    'application/json' => Response::FORMAT_JSON
                ],
            ],
            [
								'class' => ControlPositionController::className(),
								'modelClass' => Photo::className(),
						],
        ];
    }

    public function actionUpload($class, $item_id)
    {
        $success = null;

        $photo = new Photo;
        $photo->class = $class;
        $photo->item_id = $item_id;
        $photo->image = UploadedFile::getInstance($photo, 'image');

        if($photo->image && $photo->validate(['image'])) {
            $photo->image = Image::upload($photo->image, 'photos', Photo::PHOTO_MAX_WIDTH);

            if($photo->image){
                if($photo->save()) {
                    $success = [
                        'message' => Yii::t('app', 'Photo uploaded'),
                        'photo' => [
                            'id' => $photo->primaryKey,
                            'image' => $photo->image,
                            'thumb' => Image::thumb($photo->image, Photo::PHOTO_THUMB_WIDTH, Photo::PHOTO_THUMB_HEIGHT),
                            'description' => ''
                        ]
                    ];
                }
                else {
                    @unlink(Yii::getAlias('@webroot') . str_replace(Url::base(true), '', $photo->image));
                    $this->error = Yii::t('app', 'Create error. {0}', $photo->formatErrors());
                }
            }
            else {
                $this->error = Yii::t('app', 'File upload error. Check uploads folder for write permissions');
            }
        }
        else {
            $this->error = Yii::t('app', 'File is incorrect');
        }
        return $this->formatResponse($success);
    }

    public function actionDescription($id)
    {
        if(($model = Photo::findOne($id)))
        {
            if(Yii::$app->request->post('description'))
            {
                $model->description = Yii::$app->request->post('description');
                if(!$model->update()) {
                    $this->error = Yii::t('app', 'Update error. {0}', $model->formatErrors());
                }
            }
            else {
                $this->error = Yii::t('app', 'Bad response');
            }
        }
        else {
            $this->error = Yii::t('app', 'Not found');
        }

        return $this->formatResponse(Yii::t('app', 'Photo description saved'));
    }

    public function actionImage($id)
    {
        $success = null;

        if(($photo = Photo::findOne($id)))
        {
            $oldImage = $photo->image;

            $photo->image = UploadedFile::getInstance($photo, 'image');

            if($photo->image && $photo->validate(['image'])){
                $photo->image = Image::upload($photo->image, 'photos', Photo::PHOTO_MAX_WIDTH);
                if($photo->image){
                    if($photo->save()){
                        @unlink(Yii::getAlias('@webroot').$oldImage);

                        $success = [
                            'message' => Yii::t('app', 'Photo uploaded'),
                            'photo' => [
                                'image' => $photo->image,
                                'thumb' => Image::thumb($photo->image, Photo::PHOTO_THUMB_WIDTH, Photo::PHOTO_THUMB_HEIGHT)
                            ]
                        ];
                    }
                    else{
                        @unlink(Yii::getAlias('@webroot').$photo->image);

                        $this->error = Yii::t('app', 'Update error. {0}', $photo->formatErrors());
                    }
                }
                else{
                    $this->error = Yii::t('app', 'File upload error. Check uploads folder for write permissions');
                }
            }
            else{
                $this->error = Yii::t('app', 'File is incorrect');
            }

        }
        else{
            $this->error =  Yii::t('app', 'Not found');
        }

        return $this->formatResponse($success);
    }

    public function actionDelete($id, $class)
    {
        if(($model = Photo::findOne(['id'=>$id, 'class'=>$class]))) {
            $model->delete();
        } else {
            $this->error = Yii::t('app', 'Not found');
        }
        return $this->formatResponse(Yii::t('app', 'Photo deleted'));
    }

    public function actionUp($id, $class)
    {
        return $this->posUp($id, $class);
    }

    public function actionDown($id, $class)
    {
        return $this->posDown($id, $class);
    }
}