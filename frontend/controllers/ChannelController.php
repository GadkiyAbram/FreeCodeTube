<?php


namespace frontend\controllers;


use common\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ChannelController extends Controller
{
    public function actionView($username)
    {
        $channel = $this->findChannel($username);

        return $this->render('view', [
            'channel' => $channel
        ]);
    }

    /**
     * @param $username
     * @throws NotFoundHttpException
     */
    public function findChannel($username)
    {
        $channel = User::findByUsername($username);
        if (!$channel) {
            throw new NotFoundHttpException("Channel does not exist");
        }
    }


}