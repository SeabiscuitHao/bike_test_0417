<?php
namespace app\index\controller;
use app\index\controller\Base;
use think\Db;
class Article extends Base
{
    public function index()
    {
        $arid = input('arid');
        $articles = Db::name('article') -> find($arid);
        $ralateres = $this -> ralat($articles['keywords'],$articles['id']);
        Db::name('article') -> where('id','=',$arid) -> setInc('click',1);
        $cates = Db::name('cate') -> find($articles['cateid']);
        // $this -> assign('articles',$articles);
        $recres = Db::name('article') -> where(array('cateid' => $cates['id'],'state' => 1)) -> limit(8) -> select();
        $this -> assign(array(
          'articles' => $articles,
          'cates' => $cates,
          'recres' => $recres,
          'ralateres' => $ralateres,
        ));
        return $this -> fetch('article');
    }

    public function ralat($keywords,$id)
    {
      $arr = explode(',',$keywords);
      static $ralateres = array();
      foreach($arr as $k => $v){
        $map['keywords'] = ['like','%'.$v.'%'];
        $map['id'] = ['neq',$id];
        $artres = Db::name('article') -> where($map) -> order('id desc') -> limit(8) -> select();
        $ralateres = array_merge($ralateres,$artres);
      }
      if ($ralateres) {
          $ralateres = arr_unique($ralateres);
          return $ralateres;
      }
    }
    
}
