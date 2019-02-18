<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\widgets;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\base\Widget;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\widgets\LinkPager;

/**
 * Alert widget renders a message from session flash. All flash messages are displayed
 * in the sequence they were assigned using setFlash. You can set message as following:
 *
 * ```php
 * \Yii::$app->session->setFlash('error', 'This is the message');
 * \Yii::$app->session->setFlash('success', 'This is the message');
 * \Yii::$app->session->setFlash('info', 'This is the message');
 * ```
 *
 * Multiple messages could be set as follows:
 *
 * ```php
 * \Yii::$app->session->setFlash('error', ['Error 1', 'Error 2']);
 * ```
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @author Alexander Makarov <sam@rmcreative.ru>
 */
class ListView extends Widget
{
    public $style;//单独判断样式，默认不填，
    
	public $provider;
	
	public $id;
	
	public $models;
	
	public $listType = 'Table';			// ImgList: 图片列表处理  Table: 默认表格列表处理
	
	public $options = [];				// 选项处理
	
	public $item = [];					// 属性参数
	
	public $action = '';				// 编辑控制器
	
	public function init(){
		if($this->models === null){
			$this->models = $this->provider->models;
		}
		if($this->options === null){
			throw new InvalidConfigException('The "options" not site.');
		}
	}
	
	/*
	* 运行该部件
	*/
	public function run(){
		$type = 'get'.$this->listType.'View';		// 调用对应的生成方法
		echo $this->$type();
	}
	
	/**
	* 生成列表类控件
	*/
	protected function getTableView(){
		$itemlist = [];
		$filed = $this->item;

		$theadHtml = '<thead><tr>';
		foreach($filed as $k => $v){
			$theadHtml .= '<th>'.$v['value'].'</th>';
		}
		$theadHtml .= '<th>操作</th></tr></thead>';
		$id = $this->id;
		foreach($this->models as $k => $v){
			$itemlistText  = '<tr>';
			foreach($filed as $key => $value){
				$itemlistText .= '<td class="center">';
				$itemlistText .= $this->getItemtext($key,$value,$v);
				$itemlistText .= '</td>';
			}
			$itemlistText .= '<td class="center">';

			$itemlistText .= '<a class="btn btn-info" href="'.Url::toRoute([$this->action,'id' => $v->$id,'type'=>Yii::$app->request->get('type')]).'">';
			$itemlistText .= '<i class="glyphicon glyphicon-edit icon-white"></i>编辑</a>'."\n";
			$itemlistText .= '<a class="btn btn-danger" href="javascript:void(0);" onclick="del('.$v->$id.')">';
			$itemlistText .= '<i class="glyphicon glyphicon-trash icon-white"></i>删除</a>';
			$itemlistText .= '</td></tr>';
			$itemlist[] = $itemlistText;
		}
		$htmlContent = $theadHtml."<tbody>".implode("\n", $itemlist).$this->getTfoot().'</tbody>';
		//$htmlContent = "<tbody>".implode("\n", $itemlist).$this->getTfoot().'</tbody>';
		return Html::tag('table',$htmlContent,['class' => 'table table-striped table-bordered responsive']);
	}
	/*
	* 获取td数据
	*/
	protected function getItemtext($key,$value,$model){
	    //VarDumper::dump($content=$value['dataArr']);exit;
		$content = '';
		switch($value['type']){
			case 'text': $content=Html::encode($model->$key);break;
			case 'dropDown': empty($content=$value['dataArr'][$model->$key])?'---':$content=$value['dataArr'][$model->$key];break;
			case 'image': !empty($model->$key)?$content='<img src="'.Yii::getAlias('@static').'/'.Html::encode($model->$key).'" height="50">':'';break;
		}
		return $content;
	}
	
	/*
	* 生成图片类控件处理
	*/
	protected function getImgListView(){
		$itemlist = [];
		$filed = $this->item;
		$id = $this->id;
		foreach($this->models as $k => $v){
		    $face = $filed['face'];
		    $title = $filed['title'];
            $height = $filed['height']??140;
            $width = $filed['width']??170;
			$itemlistText  = '<tr style="width: 300px;float: left; margin: 10px;background-color: #fff"><td class="center"><div style="max-width: '.$width.'px;max-height: '.$height.'px; overflow: hidden;"><img src="'.Yii::getAlias('@static').'/'.Html::encode($v->$face).'" width="100%"></div>';
			$itemlistText .= '<div style="padding: 10px 0;">'.Html::encode(mb_strlen($v->$title,'utf-8')>19?mb_substr($v->$title,0,19,'utf-8').'...':$v->$title).'</div>';
			$itemlistText .= '<div style="padding-top:10px;">';
			$itemlistText .= '<a class="btn btn-info" href="'.Url::toRoute([$this->action,'id' => $v->$id,'type'=>Yii::$app->request->get('type')]).'">';
			$itemlistText .= '<i class="glyphicon glyphicon-edit icon-white"></i>编辑</a>'."\n";
			$itemlistText .= '<a class="btn btn-danger" href="javascript:void(0);" onclick="del('.$v->$id.')">';
			$itemlistText .= '<i class="glyphicon glyphicon-trash icon-white"></i>删除</a>';
			$itemlistText .= '</div></td></tr>';
			$itemlist[] = $itemlistText;
		}
		$htmlContent = "<tbody>".implode("\n", $itemlist).$this->getTfoot().'</tbody>';
		return Html::tag('table',$htmlContent,['class' => 'table table-striped table-bordered responsive']);
	}
	
	/*
	* 获取底部页脚信息
	*
	*/
	protected function getTfoot(){
		$tfootHtml = '<tfoot><tr>';
		$tfootHtml .= '<td colspan="20"><button class="btn btn-default pull-left" style="display: inline-block" disabled="disabled">(当前'.$this->provider->count.'条/共'.$this->provider->totalCount.'条)</button>';
        $tfootHtml .= LinkPager::widget([
                'pagination' => $this->provider->pagination,
                'linkOptions' => ['onclick' => 'return goPage(this)'],
                'options' => ['class' => 'pagination pull-right', 'style' => 'margin:0px']
            ]);
		$tfootHtml .= '</td></tr></tfoot>';
		return $tfootHtml;
	}

    /*
    * 生成信访类控件处理
    */
    protected function getLetterListView(){
        $itemlist = [];
        $filed = $this->item;

        $theadHtml = '<thead><tr>';
        foreach($filed as $k => $v){
            $theadHtml .= '<th>'.$v['value'].'</th>';
        }
        $theadHtml .= '<th>操作</th></tr></thead>';
        $id = $this->id;
        foreach($this->models as $k => $v){
            $itemlistText  = '<tr>';
            foreach($filed as $key => $value){
                $itemlistText .= '<td class="center">';
                $itemlistText .= $this->getItemtext($key,$value,$v);
                $itemlistText .= '</td>';
            }
            $itemlistText .= '<td class="center">';
            if($this->style == 'survey'){
                $itemlistText .= '<a class="btn btn-info" href="'.Url::toRoute(['question/index','cate_id' => $v->$id]).'">';
                $itemlistText .= '<i class="glyphicon glyphicon-edit icon-white"></i>问题列表</a>'."\n";
            }
            if($this->style == 'opinion'){
                $itemlistText .= '<a class="btn btn-info" href="'.Url::toRoute(['feedback/index','cate_id' => $v->$id]).'">';
                $itemlistText .= '<i class="glyphicon glyphicon-edit icon-white"></i>反馈列表</a>'."\n";
            }
            $itemlistText .= '<a class="btn btn-info" href="'.Url::toRoute([$this->action,'id' => $v->$id,'cate_id'=>Yii::$app->request->get('cate_id')]).'">';
            $itemlistText .= '<i class="glyphicon glyphicon-edit icon-white"></i>编辑</a>'."\n";
            $itemlistText .= '<a class="btn btn-danger" href="javascript:void(0);" onclick="del('.$v->$id.')">';
            $itemlistText .= '<i class="glyphicon glyphicon-trash icon-white"></i>删除</a>';
            $itemlistText .= '</td></tr>';
            $itemlist[] = $itemlistText;
        }
        $htmlContent = $theadHtml."<tbody>".implode("\n", $itemlist).$this->getTfoot().'</tbody>';
        //$htmlContent = "<tbody>".implode("\n", $itemlist).$this->getTfoot().'</tbody>';
        return Html::tag('table',$htmlContent,['class' => 'table table-striped table-bordered responsive']);
    }
}
