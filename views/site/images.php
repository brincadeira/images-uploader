<?php
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use \yii\helpers\{Html, Url};

echo yii\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'name',
        'date',
        'url' => ['attribute' => 'name', 
            'header'  => 'Image',
            'format' => 'raw', 
            'value' => function ($model) {
                return Html :: a ($model-> name, ['site/uploads/'.$model-> name], [' target '=>' _blank ']);
            },
        ],
        'img' => ['attribute' => 'name', 
            'header'  => 'Preview',
            'format' => 'raw', 
            'value' => function ($model) {
                return Html::img('@web/site/resized/'.$model-> name, ['alt' => 'Preview']);
            },
        ],
    ],
]);

