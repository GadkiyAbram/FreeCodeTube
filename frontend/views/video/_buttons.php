<?php
/** @var $model \common\models\Video */
use yii\helpers\Url; ?>

<a href="<?php echo Url::to(['/video/like', 'id' => $model->video_id])?>"
   class="btn btn-sm <?php echo $model->isLikedBy(Yii::$app->user->id) ? 'btn-outline-primary' : 'btn-outline-secondary'?>"
   data-method="post" data-pjax="1">
    <i class="far fa-thumbs-up"></i> 9
</a>
<button class="btn btn-sm btn-outline-secondary">
    <i class="far fa-thumbs-down"></i> 3
</button>
