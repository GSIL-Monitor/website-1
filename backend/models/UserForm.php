<?php
/**
 * @link http://www.shuwon.com/
 * @copyright Copyright (c) 2016 成都蜀美网络技术有限公司
 * @license http://www.shuwon.com/
 */
namespace backend\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * @author 制作人
 * @since 1.0
 */
class UserForm extends ActiveRecord {

    public $verifyPassword;
    public $roles;

    public static function tableName() {
        return 'user';
    }

    public function attributeLabels() {
        return [
            'username' => '用户名',
            'password' => '密码',
            'verifyPassword' => '确认密码',
            'roles' => '角色',
            'enabled' => '启用'
        ];
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->auth_key = Yii::$app->security->generateRandomString(); //自动添加随机auth_key
                $this->password = Yii::$app->security->generatePasswordHash($this->password); //密码加密
                $this->created_at = time();
                $this->updated_at = time();
            }
            return true;
        }
        return false;
    }

    public function rules() {
        return [
            [['username', 'password', 'verifyPassword'], 'trim'], //去两端空格
            ['enabled', 'boolean'],
            ['username', 'string', 'length' => [2, 10]],
            [['password', 'verifyPassword'], 'string', 'length' => [4, 12]],
            [['username', 'password', 'verifyPassword'], 'required'],
            ['verifyPassword', 'compare', 'compareAttribute' => 'password', 'message' => '请重复输入密码'],
            ['username', 'unique'], //唯一
            ['roles', 'required']
        ];
    }
    public function fields() {
        $fields = parent::fields();
        $fields['password'] = function() {
            return '******';
        };
        $fields['roles'] = function() {
            return \yii\helpers\ArrayHelper::getColumn(Yii::$app->authManager->getRolesByUser($this->id), 'name');
        };
        unset($fields['auth_key'], $fields['access_token']);
        return $fields;
    }
}
