<?php


namespace frontend\controllers;


use app\models\Subscriber;
use common\models\User;
use common\models\Video;
use yii\data\ActiveDataProvider;
use yii\debug\models\timeline\DataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ChannelController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' =>AccessControl::class,
                'only' => ['subscribe'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ],
        ];
    }

    public function actionView($username)
    {
        $channel = $this->findChannel($username);

        $dataProvider = new ActiveDataProvider([
            'query' => Video::find()->creator($channel->id)->published()
        ]);

        return $this->render('view', [
            'channel' => $channel,
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionSubscribe($username)
    {
        $channel = $this->findChannel($username);

        $userId = \Yii::$app->user->id;
        $subscriber = $channel->isSubscribed($userId);
        if (!$subscriber) {
            $subscriber = new Subscriber();
            $subscriber->channel_id = $channel->id;
            $subscriber->user_id = $userId;
            $subscriber->created_at = time();
            $subscriber->save();
        }else{
            $subscriber->delete();
        }

        return $this->renderAjax('_subscribe', [
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

        return $channel;
    }
}