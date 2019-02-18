<?php
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');

Yii::setAlias('staticroot', dirname(dirname(__DIR__)) . '/static');
if (!YII_ENV_PROD) {
	Yii::setAlias('static', '/static');
} else {
	Yii::setAlias('static', '/static');
}
