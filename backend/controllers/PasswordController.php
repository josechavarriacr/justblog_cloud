<?php

namespace backend\controllers;

use Yii;
use backend\models\Password;
use backend\models\PasswordSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class PasswordController extends Controller
{
    public function behaviors()
    {
        return [
        'verbs' => [
        'class' => VerbFilter::className(),
        'actions' => [
        'delete' => ['POST'],
        ],
        ],
        ];
    }

    public function actionIndex()
    {
        if (\Yii::$app->user->can('deletePost')) {
            $searchModel = new PasswordSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                ]);
        } else {
         Yii::$app->session->setFlash('error','User not allowed');
         return $this->goHome();
     }

 }

 public function actionView($id)
 {
    if (\Yii::$app->user->can('deletePost')) {
        return $this->render('view', [
            'model' => $this->findModel($id),
            ]);
    } else {
        Yii::$app->session->setFlash('error','User not allowed');
        return $this->goHome();
    }

}

public function actionCreate()
{
    if (\Yii::$app->user->can('deletePost')) {
        $model = new Password();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                ]);
        }
    } else {
        Yii::$app->session->setFlash('error','User not allowed');
        return $this->goHome();
    }
    
}

public function actionUpdate($id)
{
    if (\Yii::$app->user->can('deletePost')) {
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
    return $this->goHome();
}
}

    /**
     * Deletes an existing Password model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if(\Yii::$app->user->can('deletePost')){
            $this->findModel($id)->delete();

            return $this->redirect(['index']);
        }else{
            Yii::$app->session->setFlash('error','User not allowed');
            return $this->goHome();
        }
    }

    /**
     * Finds the Password model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Password the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Password::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
