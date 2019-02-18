<?php
/**
 * @link http://www.shuwon.com/
 * @copyright Copyright (c) 2016 成都蜀美网络技术有限公司
 * @license http://www.shuwon.com/
 */
namespace frontend\controllers;

use common\models\News;
use common\models\Seo;
use common\models\Single;
use Yii;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\Url;
use yii\helpers\Json;
use common\models\Config;
/**
 * 公共控制器，需要权限验证的都继承此控制器，在beforeAction验证权限。
 * @author 制作人
 * @since 1.0
 */
header("Content-type: text/html; charset=utf-8");
class CommonController extends Controller {


    private $crm_api = 'http://222.85.225.9:1999/CRM_VIP_Proxy.asmx?wsdl';
    private $KEY = '201511061724';
    private $USER = 'TEST';
    private $privateKey = '89622015104709087435617163207900';
    private $iv = 'abcdefghijklmnop';
    public $lang;
    public $layout;


    public function init(){
        parent::init();
        $this->lang = Yii::$app->request->get('lang','cn');
        $this->lang = in_array($this->lang,Yii::$app->params['lang'])?$this->lang:'cn';
        Yii::$app->params['lang_str'] = $this->lang;
        $this->layout = '../'.$this->lang.'/layouts/main';
        $this->setViewPath($this->module->getViewPath().'/'.$this->lang.'/'.$this->id);
    }


    public function beforeAction($action) {
        $config = Config::find()->asArray()->All();
        $config = array_column($config,'config_value','config_key');
        $key_arr = Config::find()->where(['config_type'=>'seo_site'])->one();
        Yii::$app->params['web_site_config'] = $config;
        Yii::$app->params['web_site_config']['keywords'] = $key_arr->config_value;
        return true;
    }
    //加密
    private function encode($value) {
    	$encrypted = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $this->privateKey, $value, MCRYPT_MODE_ECB, $this->iv);
    	$encode = base64_encode($encrypted);
    	return $encode;
    }
    
    //解密
    private function decode($value) {
    	$encrypted_data = base64_decode($value);
    	$decode = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $this->privateKey, $encrypted_data, MCRYPT_MODE_ECB, $this->iv);
    	return $decode;
    }
    public function getSingle($type){
        $data=Single::find()->where(['type'=>$type])->one();
        return $data;
    }
    //上一条
    public function getPage($type,$id,$cate=null,$cateUrl){

        if(!empty($cate)){
            $prev_article = News::find()->andFilterWhere(['>', 'news_id', $id])->andFilterWhere(['enabled' => 1])->andFilterWhere(['news_type' => $type])->andFilterWhere(['news_cate' => $cate])->orderBy(['sort'=>SORT_DESC,'news_id'=>SORT_DESC])->limit(1)->one();
            $next_article = News::find()->andFilterWhere(['<', 'news_id', $id])->andFilterWhere(['enabled' => 1])->andFilterWhere(['news_type' => $type])->andFilterWhere(['news_cate' => $cate])->orderBy(['sort'=>SORT_DESC,'news_id'=>SORT_ASC])->limit(1)->one();

        }else{
            $prev_article = News::find()->andFilterWhere(['>', 'news_id', $id])->andFilterWhere(['enabled' => 1])->andFilterWhere(['news_type' => $type])->orderBy(['sort'=>SORT_DESC,'news_id'=>SORT_DESC])->limit(1)->one();
            $next_article = News::find()->andFilterWhere(['<', 'news_id', $id])->andFilterWhere(['enabled' => 1])->andFilterWhere(['news_type' =>$type])->orderBy(['sort'=>SORT_DESC,'news_id'=>SORT_ASC])->limit(1)->one();

        }

        if(!empty($cate)) {
            $model['prev_article'] = [
                'url' => !is_null($prev_article) ? '/'.$cateUrl.'/'.$cate.'/'.$prev_article->news_id.'.html' : '###',
                'title' => !is_null($prev_article) ? $prev_article->news_title : '暂无上一条',
            ];
            $model['next_article'] = [
                'url' => !is_null($next_article) ? '/'.$cateUrl.'/'.$cate.'/'.$next_article->news_id.'.html' : '###',
                'title' => !is_null($next_article) ? $next_article->news_title : '暂无下一条',
            ];
        }else{
            $model['prev_article'] = [
                'url' => !is_null($prev_article) ? '/'.$cateUrl.'/'.$prev_article->news_id.'.html' : '###',
                'title' => !is_null($prev_article) ? $prev_article->news_title : '暂无上一条',
            ];
            $model['next_article'] = [
                'url' => !is_null($next_article) ? '/'.$cateUrl.'/'.$next_article->news_id.'.html' : '###',
                'title' => !is_null($next_article) ? $next_article->news_title : '暂无下一条',
            ];
        }
        return $model;
    }
    //seo
    public function getSeo($id) {
        $seo = Seo::find()->where(['seo_id' => $id])->one();

        if(!empty($seo)){
            Yii::$app->params['title'] = $seo->title;
            Yii::$app->params['face'] = Yii::getAlias('@static').'/'.$seo->banner_face;
            Yii::$app->params['subtitle'] = $seo->subtitle;
            Yii::$app->params['description'] = $seo->description;
        }
    }

    public function renderJson($params = array()) {
        header('Access-Control-Allow-Origin:*');
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $params;
    }
    public function newsArr($query,$pageSize){
        $data=[
            'query' => $query,
            'pagination' => [
                'pageSize' => $pageSize,
            ],
            'sort' => [
                'defaultOrder' => [
                    'sort' => SORT_DESC,
                    'news_id' => SORT_DESC,
                ]
            ],
        ];
        return $data;
    }
    //webp
    public function is_webp() {
    	$agent = $_SERVER["HTTP_USER_AGENT"];
    	return strpos($agent,'Chrome')!==false;
    }
    
    public function api_member_vipcode($vipcode) {
        $client = new \SoapClient($this->crm_api);
    
        $REQDATE = date('Ymd');
        $REQTIME = date('His');
        
        $Header = array(
            'SIGN'=>strtolower(md5($REQDATE.$REQTIME.$this->KEY)),
            'REQDATE'=>$REQDATE,
            'REQTIME'=>$REQTIME,
        	'USER'=>$this->USER,
        );

        $Data = array(
            'vipcode'=>$this->encode($vipcode),
        );
        $request = array('Header'=>$Header,'Data'=>$Data);
        $return = $client->GetVipInfo(array('request'=>$request));
        //echo '<pre>';print_R($request);
        //echo '<pre>';print_R($return);
        if($return->GetVipInfoResult->Header->ERRCODE==0){
            $member_info = [];
            $member_info['xf_active'] = $return->GetVipInfoResult->DATA->VIP->xf_active;
            $member_info['xf_address'] = $return->GetVipInfoResult->DATA->VIP->xf_address1.$return->GetVipInfoResult->DATA->VIP->xf_address2.$return->GetVipInfoResult->DATA->VIP->xf_address3.$return->GetVipInfoResult->DATA->VIP->xf_address4;
            $member_info['xf_bankcardno'] = $return->GetVipInfoResult->DATA->VIP->xf_bankcardno;
            $member_info['xf_birthday'] = $return->GetVipInfoResult->DATA->VIP->xf_birthdayyyyy.'-'.$return->GetVipInfoResult->DATA->VIP->xf_birthdaymm.'-'.$return->GetVipInfoResult->DATA->VIP->xf_birthdaydd;
            $member_info['xf_bonus'] = trim($this->decode($return->GetVipInfoResult->DATA->VIP->xf_bonus));
            $member_info['xf_grade'] = $return->GetVipInfoResult->DATA->VIP->xf_grade;
            $member_info['xf_jointdate'] = $return->GetVipInfoResult->DATA->VIP->xf_jointdate;
            $member_info['xf_sex'] = $return->GetVipInfoResult->DATA->VIP->xf_sex;
            $member_info['xf_surname'] = trim($this->decode($return->GetVipInfoResult->DATA->VIP->xf_surname));
            $member_info['xf_telephone'] = trim($this->decode($return->GetVipInfoResult->DATA->VIP->xf_telephone));
            $member_info['xf_vipcode'] = trim($this->decode($return->GetVipInfoResult->DATA->VIP->xf_vipcode));
            return $member_info;
        }else{
            return false;
        }
    }
    
    public function api_member_info($mobile) {
    	
        $client = new \SoapClient($this->crm_api);

        $REQDATE = date('Ymd');
        $REQTIME = date('his');

        $Header = array(
            'SIGN'=>md5($REQDATE.$REQTIME.$this->KEY),
            'REQDATE'=>$REQDATE,
            'REQTIME'=>$REQTIME,
        	'USER'=>$this->USER,
        );
        $Data = array(
            'vipcode'=>'',
            'mobile'=>$this->encode($mobile),
            'openid'=>'',
        );
        $request = array('Header'=>$Header,'Data'=>$Data);
        $return = $client->GetVipInfoByMobileOpenID(array('request'=>$request));
        //echo '<pre>';print_R($request);
        //echo '<pre>';print_R($return);
        if($return->GetVipInfoByMobileOpenIDResult->Header->ERRCODE==0){
            $member_info = [];
            $member_info['xf_active'] = $return->GetVipInfoByMobileOpenIDResult->DATA->VIP->xf_active;
            $member_info['xf_address'] = $return->GetVipInfoByMobileOpenIDResult->DATA->VIP->xf_address1.$return->GetVipInfoByMobileOpenIDResult->DATA->VIP->xf_address2.$return->GetVipInfoByMobileOpenIDResult->DATA->VIP->xf_address3.$return->GetVipInfoByMobileOpenIDResult->DATA->VIP->xf_address4;
            $member_info['xf_bankcardno'] = $return->GetVipInfoByMobileOpenIDResult->DATA->VIP->xf_bankcardno;
            $member_info['xf_birthday'] = $return->GetVipInfoByMobileOpenIDResult->DATA->VIP->xf_birthdayyyyy.'-'.$return->GetVipInfoByMobileOpenIDResult->DATA->VIP->xf_birthdaymm.'-'.$return->GetVipInfoByMobileOpenIDResult->DATA->VIP->xf_birthdaydd;
            $member_info['xf_bonus'] = trim($this->decode($return->GetVipInfoByMobileOpenIDResult->DATA->VIP->xf_bonus));
            $member_info['xf_grade'] = $return->GetVipInfoByMobileOpenIDResult->DATA->VIP->xf_grade;
            $member_info['xf_jointdate'] = $return->GetVipInfoByMobileOpenIDResult->DATA->VIP->xf_jointdate;
            $member_info['xf_sex'] = $return->GetVipInfoByMobileOpenIDResult->DATA->VIP->xf_sex;
            $member_info['xf_surname'] = trim($this->decode($return->GetVipInfoByMobileOpenIDResult->DATA->VIP->xf_surname));
            $member_info['xf_telephone'] = trim($this->decode($return->GetVipInfoByMobileOpenIDResult->DATA->VIP->xf_telephone));
            $member_info['xf_vipcode'] = trim($this->decode($return->GetVipInfoByMobileOpenIDResult->DATA->VIP->xf_vipcode));
            return $member_info;
        }else{
            return false;
        }
    }
    
    public function api_member_register($post_data) {
    	$client = new \SoapClient($this->crm_api);
    	 
    	$REQDATE = date('Ymd');
    	$REQTIME = date('His');
    	 
    	$xf_vipcode = $this->encode($post_data['vipcode']) ;
    	$surname = $this->encode($post_data['username']);
    	$mobile = $this->encode($post_data['mobile']);
    	$sex = $post_data['gender']==1 ? 'F' : 'M';
    	$birthday = date('Y-m-d',$post_data['birthday']);
    	$idcardtype = '';
    	$idcardno = '';
    	$address = $post_data['address'];
    	$weixin = '';
    	$email = '';
    	$vipgrade = '';
    	$vip_souce = '';
    	$jointdate = date('Y-m-d H:i:s');
    	$xf_issuestore = '';
    	$xf_vipcodeprefix = '863';
    	$xf_issuestaffcode = '';
    	 
    	$Header = array(
    			'SIGN'=>strtolower(md5($REQDATE.$REQTIME.$post_data['mobile'].$this->KEY)),
    			'REQDATE'=>$REQDATE,
    			'REQTIME'=>$REQTIME,
    			'USER'=>$this->USER,
    	);
    	$Data = array(
    			'xf_vipcode'=>$xf_vipcode,
    			'surname'=>$surname,
    			'mobile'=>$mobile,
    			'sex'=>$sex,
    			'birthday'=>$birthday,
    			'idcardtype'=>$idcardtype,
    			'idcardno'=>$idcardno,
    			'address'=>$address,
    			'weixin'=>$weixin,
    			'email'=>$email,
    			'vipgrade'=>$vipgrade,
    			'vip_souce'=>$vip_souce,
    			'jointdate'=>$jointdate,
    			'xf_issuestore'=>$xf_issuestore,
    			'xf_vipcodeprefix'=>$xf_vipcodeprefix,
    			'xf_issuestaffcode'=>$xf_issuestaffcode,
    	);
    
    	$request = array('Header'=>$Header,'Data'=>array('vip'=>$Data));
    	$return = $client->VipCreate(array('request'=>$request));
    	//echo '<pre>';print_R($request);
    	//echo '<pre>';print_R($return);
    	if($return->VipCreateResult->Header->ERRCODE==0){
    		return true;
    	}else{
    		return false;
    	}
    	 
    }
    
	public function api_member_edit($member_modify_info) {
		$client = new \SoapClient($this->crm_api);
		
		$REQDATE = date('Ymd');
		$REQTIME = date('his');
		
		$xf_vipcode = $member_modify_info['vipcode'];
		$surname = $member_modify_info['username'];
		$birthday = date('Y-m-d',$member_modify_info['birthday']);
		$address = $member_modify_info['address'];
		
		$Header = array(
				'SIGN'=>md5($REQDATE.$REQTIME.$xf_vipcode.$this->KEY),
				'REQDATE'=>$REQDATE,
				'REQTIME'=>$REQTIME,
				'USER'=>$this->USER,
		);
		$Data = array(
				'xf_vipcode'=>$this->encode($xf_vipcode),
				'surname'=>$this->encode($surname),
				'birthday'=>$birthday,
				'address'=>$address,
		);
		
		$request = array('Header'=>$Header,'Data'=>array('vip'=>$Data));
		$return = $client->VipModify(array('request'=>$request));
		//echo '<pre>';print_R($request);
		//echo '<pre>';print_R($return);
		if($return->VipModifyResult->Header->ERRCODE==0){
			return true;
		}else{
			return false;
		}
    }
    
    public function api_member_paylog($vipcode) {
        $client = new \SoapClient($this->crm_api);
        
        $REQDATE = date('Ymd');
        $REQTIME = date('his');
        
        $openid = '';
        $frmtxdate = '';
        $totxdate = '';
        $action = '';
        $remark = '';
        
        $Header = array(
            'SIGN'=>md5($REQDATE.$REQTIME.$vipcode.$this->KEY),
            'REQDATE'=>$REQDATE,
            'REQTIME'=>$REQTIME,
            'USER'=>$this->USER,
        );
        $Data = array(
            'vipcode'=>$this->encode($vipcode),
            'openid'=>$openid,
            'frmtxdate'=>$frmtxdate,
            'totxdate'=>$totxdate,
            'action'=>$action,
            'remark'=>$remark
        );
        $request = array('Header'=>$Header,'Data'=>$Data);
        $return = $client->GetBonusledgerRecord(array('request'=>$request));
        //echo '<pre>';print_R($request);
        //echo '<pre>';print_R($return);
        if($return->GetBonusledgerRecordResult->Header->ERRCODE==0){
            $log_list = [];
            
            if(is_array($return->GetBonusledgerRecordResult->DATA->xf_bonusledger)){
                foreach($return->GetBonusledgerRecordResult->DATA->xf_bonusledger as $bonusledger){
                    $log_list[$bonusledger->XF_TXDATE] = array(
                        'remark'=>$bonusledger->XF_REMARK ? $bonusledger->XF_REMARK : $bonusledger->XF_ACTION,
                        'score'=>$bonusledger->XF_BONUS,
                        'time'=>$bonusledger->XF_TXDATE,
                    );
                } 
            }else{
                $log_list[] = array(
                    'remark'=>$return->GetBonusledgerRecordResult->DATA->xf_bonusledger->XF_REMARK ? $return->GetBonusledgerRecordResult->DATA->xf_bonusledger->XF_REMARK : $return->GetBonusledgerRecordResult->DATA->xf_bonusledger->XF_ACTION,
                    'score'=>$return->GetBonusledgerRecordResult->DATA->xf_bonusledger->XF_BONUS,
                    'time'=>$return->GetBonusledgerRecordResult->DATA->xf_bonusledger->XF_TXDATE,
                );
            }
            krsort($log_list);
            return $log_list;
        }else{
            return false;
        }
    }
    
    public function api_member_bonus($member_bonus) {
    	$client = new \SoapClient($this->crm_api);
    	
    	$REQDATE = date('Ymd');
    	$REQTIME = date('his');
    	
    	$vipcode = $member_bonus['vipcode'];
    	$openid = '';
    	$expdate = date('Y-12-31');
    	$bonus = $member_bonus['bonus'];
    	$reasoncode = $member_bonus['reasoncode'];
    	$remark = $member_bonus['remark'];
    	
    	$Header = array(
    			'SIGN'=>md5($REQDATE.$REQTIME.$bonus.$this->KEY),
    			'REQDATE'=>$REQDATE,
    			'REQTIME'=>$REQTIME,
    			'USER'=>$this->USER,
    	);
    	
    	$Data = array(
    			'vipcode'=>$this->encode($vipcode),
    			'openid'=>$openid,
    			'expdate'=>$expdate,
    			'bonus'=>$this->encode($bonus),
    			'reasoncode'=>$reasoncode,
    			'remark'=>$remark
    	);
    	$request = array('Header'=>$Header,'Data'=>$Data);
    	$return = $client->BonusChange(array('request'=>$request));
    	//echo '<pre>';print_R($request);
    	//echo '<pre>';print_R($return);
    	if($return->BonusChangeResult->Header->ERRCODE==0){
    		return true;
    	}else{
    		return false;
    	}
    }
   
}
