<?php
namespace app\index\controller;
use app\index\controller\Base;
use think\Db;
class Search extends Base
{
    public function index()
    {
        $keywords = input('keywords');
        if ($keywords) {
          $map['title'] = ['like','%'.$keywords.'%'];
          $searchres = Db::name('article') -> where($map) -> order('id desc') -> paginate($listRows = 3,$simple = false,$config = [
            'query' => array('keywords' => $keywords),
          ]);
          $this -> assign(array(
            'searchres' => $searchres,
            'keywords' => $keywords
          ));
        }else{
          $this -> assign(array(
            'searchres' => null,
            'keywords' => '暂无数据',
          ));
        }
        return $this -> fetch('search');
        // dump($_GET);
        // return $this -> fetch('search');
    }
}
