<?php

namespace backend\controllers;

use Yii;
use backend\models\Tag;
use backend\models\TagSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class TagController extends Controller
{
    public function behaviors()
    {   
        return [
        'access' => [
        'class' => AccessControl::className(),
        'rules' => [
        [
        'actions' => ['login', 'error'],//actions without loggin
        'allow' => true,
        ],
        [
        'actions' => ['logout','index','view','create','update','delete'],//action with login
        'allow' => true,
        'roles' => ['@'],
        ],
        ]
        ],
        'verbs' => [
        'class' => VerbFilter::className(),
        'actions' => [
        'flush-cache' => ['POST'],
        'clear-assets' => ['POST'],
        ],
        ],
        ];
    }

    public function actions()
    {
        return [
        'error' => [
        'class' => 'yii\web\ErrorAction',
        ],
        ];
    }
    public function actionIndex()
    {
        $searchModel = new TagSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
            ]);
    }

    public function actionCreate()
    {
        if (\Yii::$app->user->can('createPost')) {
            $model = new Tag();

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                    ]);
            }
        } else {
            Yii::$app->session->setFlash('error', 'User not allowed');
            return $this->redirect(['index']);
        }
        
    }

    public function actionUpdate($id)
    {
        if (\Yii::$app->user->can('updatePost')) {
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                    ]);
            }
        } else {
            Yii::$app->session->setFlash('error', 'User not allowed');
            return $this->redirect(['index']);
        }
        
    }

    public function actionDelete($id)
    {
        if(\Yii::$app->user->can('updatePost')){
            $this->findModel($id)->delete();

            return $this->redirect(['index']);
        }else{
            Yii::$app->session->setFlash('error', 'User not allowed');
            return $this->redirect(['index']);
        }
    }

    protected function findModel($id)
    {
        if (($model = Tag::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
