<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $votedUpAPIsDataProvider yii\data\ActiveDataProvider */
/* @var $votedDownAPIsDataProvider yii\data\ActiveDataProvider */
/* @var $votedUpObjectsDataProvider yii\data\ActiveDataProvider */
/* @var $votedDownObjectsDataProvider yii\data\ActiveDataProvider */
/* @var $votedUpCommentsDataProvider yii\data\ActiveDataProvider */
/* @var $votedDownCommentsDataProvider yii\data\ActiveDataProvider */
/* @var $followedUsersDataProvider yii\data\ActiveDataProvider */
/* @var $followedApisDataProvider yii\data\ActiveDataProvider */
/* @var $doIFollow boolean */
/* @var $followed integer */
/* @var $followers integer */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$noSummaryLayout = "{items}\n{pager}";

$apiColumns = [
	[
		'attribute' => 'name',
		'value'=>function ($model, $key, $index, $widget) {
			return
				Html::a($model->name, ['apis/', 'id' => $model->id]);
		},
		'format'=>'raw',
		'hAlign' => GridView::ALIGN_CENTER,
		'vAlign' => GridView::ALIGN_MIDDLE
	],
	[
		'attribute' => 'version',
		'hAlign' => GridView::ALIGN_CENTER,
		'vAlign' => GridView::ALIGN_MIDDLE
	],
];

$objectColumns = [
	[
		'attribute' => 'name',
		'value'=>function ($model, $key, $index, $widget) {
			return
				Html::a($model->name, ['objects/', 'id' => $model->id]);
		},
		'format'=>'raw',
		'hAlign' => GridView::ALIGN_CENTER,
		'vAlign' => GridView::ALIGN_MIDDLE
	],
	[
		'attribute' => 'createdBy.username',
		'value'=>function ($model, $key, $index, $widget) {
			return Html::a($model->createdBy->username, ['view', 'id' => $model->createdBy->id]);
		},
		'format'=> 'raw',
		'hAlign' => GridView::ALIGN_CENTER,
		'vAlign' => GridView::ALIGN_MIDDLE
	]
];

$commentColumns = [
	[
		'attribute' => 'name',
		'value'=>function ($model, $key, $index, $widget) {
			return
				Html::a($model->name, ['comments/', 'id' => $model->id]);
		},
		'format'=>'raw',
		'hAlign' => GridView::ALIGN_CENTER,
		'vAlign' => GridView::ALIGN_MIDDLE
	],
	[
		'attribute' => 'version',
		'hAlign' => GridView::ALIGN_CENTER,
		'vAlign' => GridView::ALIGN_MIDDLE
	],
];

if (isset($this->params['followed'])) {
	if ($this->params['followed'])
		$this->registerJs(
			'
			var options =  {
				content: "You just followed '.$model->username.' !", // text of the snackbar
				style: "toast", // add a custom class to your snackbar
				timeout: 3000 // time in milliseconds after the snackbar autohides, 0 is disabled
			};

			$.snackbar(options);'
		);
	else
		$this->registerJs(
			'
			var options =  {
				content: "You just unfollowed '.$model->username.' !", // text of the snackbar
				style: "toast", // add a custom class to your snackbar
				timeout: 3000 // time in milliseconds after the snackbar autohides, 0 is disabled
			};

			$.snackbar(options);'
		);
}
?>
<div class="user-view">

	<h1><?= Html::encode($this->title) ?></h1>

	<h1>
		<?php if ($doIFollow) {?>
			<?= Html::a($followers, ['unfollow', 'id' => $model->id], ['class' => 'unfollow glyphicon glyphicon-minus nounderline', 'data' => ['toggle' => 'tooltip', 'placement' => 'right'], 'title' => 'Unfollow']) ?>
		<?php } else { ?>
			<?= Html::a($followers, ['follow', 'id' => $model->id], ['class' => 'follow glyphicon glyphicon-plus nounderline', 'data' => ['toggle' => 'tooltip', 'placement' => 'right'], 'title' => 'Follow me!']) ?>
		<?php } ?>
	</h1>

	<?= DetailView::widget([
		'model' => $model,
		'attributes' => [
			'email:email',
			[
				'attribute' => 'photo',
				'value' => $model->getImage()->getUrl('120'),
				'format' => ['image',['width'=>'120','height'=>'120']],
			],
			'created_at:date',
			[
				'attribute'=>'github',
				'format'=>'raw',
				'value'=>Html::a($model->github, 'https://github.com/' . $model->github, ['target' => 'blank']),
			],
			[
				'attribute'=>'linkedin',
				'format'=>'raw',
				'value'=>Html::a($model->linkedin, 'https://www.linkedin.com/in/' . $model->linkedin, ['target' => 'blank']),
			],
		],
	]) ?>

	<div class="row text-center">
		<div class="col-lg-6">
			<h3>Followed Apis</h3>
			<?= GridView::widget([
				'dataProvider' => $followedApisDataProvider,
				'columns' => [
					[
						'attribute' => 'name',
						'value'=>function ($model, $key, $index, $widget) {
							return Html::a($model->name, ['/apis/view', 'id' => $model->id]);
						},
						'format'=> 'raw',
						'hAlign' => GridView::ALIGN_CENTER,
						'vAlign' => GridView::ALIGN_MIDDLE
					],
					[
						'attribute' => 'description',
						'hAlign' => GridView::ALIGN_CENTER,
						'vAlign' => GridView::ALIGN_MIDDLE
					]
				],
				'layout' => $noSummaryLayout
			]); ?>
		</div>
		<div class="col-lg-6">
			<h3>Followed Users</h3>
			<?= GridView::widget([
				'dataProvider' => $followedUsersDataProvider,
				'columns' => [
					[
						'attribute' => 'username',
						'value'=>function ($model, $key, $index, $widget) {
							return Html::a($model->username, ['view', 'id' => $model->id]);
						},
						'format'=> 'raw',
						'hAlign' => GridView::ALIGN_CENTER,
						'vAlign' => GridView::ALIGN_MIDDLE
					],
					[
						'attribute' => 'photo',
						'value'=>function ($model, $key, $index, $widget) {
							return
								$model->getImage()->getUrl('60');
						},
						//'value' => $model->getImage()->getUrl('120'),
						'format' => ['image',['width'=>'60','height'=>'60']],
						'hAlign' => GridView::ALIGN_CENTER,
						'vAlign' => GridView::ALIGN_MIDDLE
					],
					[
						'label' => 'Unfollow',
						'value'=>function ($model, $key, $index, $widget) {
							return Html::a('Unfollow', ['unfollow', 'id' => $model->id, 'url' => '/profile/index']);
						},
						'format'=> 'raw',
						'hAlign' => GridView::ALIGN_CENTER,
						'vAlign' => GridView::ALIGN_MIDDLE
					]
				],
				'layout' => $noSummaryLayout
			]); ?>
		</div>
	</div>
	<div class="row text-center">
		<div class="col-lg-6">
			<h3>Voted Up</h3>
			<h4>APIs</h4>
			<?= GridView::widget([
				'dataProvider' => $votedUpAPIsDataProvider,
				'columns' => $apiColumns,
				'layout' => $noSummaryLayout
			]); ?>
		</div>
		<div class="col-lg-6">
			<h3>Voted Down</h3>
			<h4>APIs</h4>
			<?= GridView::widget([
				'dataProvider' => $votedDownAPIsDataProvider,
				'columns' => $apiColumns,
				'layout' => $noSummaryLayout
			]); ?>
		</div>
	</div>

	<div class="row text-center">
		<div class="col-lg-6">
			<h4>Objects</h4>
			<?= GridView::widget([
				'dataProvider' => $votedUpObjectsDataProvider,
				'columns' => $objectColumns,
				'layout' => $noSummaryLayout
			]); ?>
		</div>
		<div class="col-lg-6">
			<h4>Objects</h4>
			<?= GridView::widget([
				'dataProvider' => $votedDownObjectsDataProvider,
				'columns' => $objectColumns,
				'layout' => $noSummaryLayout
			]); ?>
		</div>
	</div>

</div>
