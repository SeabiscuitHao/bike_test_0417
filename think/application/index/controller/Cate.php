<?php
namespace app\index\controller;
use app\index\controller\Base;
use think\Db;
class Cate extends Base
{
    public function index()
    {
        $cateid = input('cateid');
        // 查询当前栏目名称
        //查询当前栏目下的文章
        $cates = Db::name('cate') -> find($cateid);
        $this -> assign('cates',$cates);
        $articleres = Db::name('article') -> where(array('cateid'=>$cateid)) -> paginate(4);
        $this -> assign('articleres',$articleres);
        return $this -> fetch('cate');
    }
}
