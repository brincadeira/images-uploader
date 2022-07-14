<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\UploadForm;
use app\models\Images;
use yii\web\UploadedFile;
use yii\helpers\Inflector;
use yii\imagine\Image;
use \yii\helpers\Html;
use yii\data\ActiveDataProvider;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    
    /**
     * Displays upload page.
     *
     * @return Response
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionUpload()
    {
        $model = new UploadForm();        

        if (Yii::$app->request->isPost) {            
            $model->imageFile = UploadedFile::getInstances($model, 'imageFile');
            foreach ($model->imageFile as $file) {          
                $baseName = $file->baseName;            
                $baseName = Inflector::transliterate($baseName);
                $baseName = strtolower($baseName);
                $extension = strtolower($file->extension);
                $name = $baseName.'.'.$extension;
                while (Images::find()->where(['name' => $name])->exists()) {	
                    $name = uniqid().'.'.$extension;
                }
                $images = new Images();
                $images->name = $name;
                $file->saveAs('site/uploads/' . $name);
                Image::thumbnail('@webroot/site/uploads/'.$name, 50, 50)->save(Yii::getAlias('@webroot/site/resized/'.$name), ['quality' => 80]);
                $images->save();
            }
            return $this->redirect(['site/images']);
        }

        return $this->render('upload', ['model' => $model]);
    }

    /**
     * Displays list of images.
     *
     * @return Response
     */
    public function actionImages()
    {        
        $query = Images::find();

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'date' => SORT_DESC,
                    'name' => SORT_ASC, 
                ]
            ],
        ]);
        return $this->render('images', [
            'dataProvider' => $provider
        ]);
    }   

}
