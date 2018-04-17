<?php
namespace app\Admin\controller;
use think\Db;
use app\admin\model\Article as ArticleModel;
use app\admin\controller\Base;
class Article extends Base
{
    public function lst()
    {
        $list = ArticleModel::paginate(3);
        // $list = Db::name('article') -> alias('a') -> join('cate c','c.id = a.cateid') -> field('a.title,a.author,a.cateid,a.pic,a.state,c.catename,c.id') -> paginate(3);
        $this -> assign('list',$list);
        //分配到模板中
        return $this -> fetch();
    }

    // 添加

    public function add()
    {
        if (request() -> isPost()) {
          $data=[
            'title' => input('title'),
            'author' => input('author'),
            'desc' => input('desc'),
            'keywords' => str_replace('，',',',input('keywords')),
            'content' => input('content'),
            'cateid' => input('cateid'),
            'time' => time(),
            'state' => input('state'),
            'click' => ''
          ];
          if ($data['click'] == '') {
            $data['click'] = 0;
          }
          //自己加的一个判断 点击次数默认为空 然后赋值为0
          if ($_FILES['pic']['tmp_name']) {
            $file = request() -> file('pic');//获取到图片
            $info = $file -> move(ROOT_PATH . 'public' . DS . 'static/uploads');
            $data['pic'] = '/uploads/'.$info -> getSaveName();
          }
          if (input('state') == 'on') {
            $data['state'] = 1;
          }else {
            $data['state'] = 0;
          }
          $validate = \think\Loader::validate('Article');
          if (!$validate -> scene('add') -> check($data)) {//->scene('add')验证场景
            $this -> error($validate->getError());
            die;
          }
          if (Db::name('Article')->insert($data)) {
            return $this -> success('添加文章成功！','lst');
          }else{
            return $this -> error('添加文章失败！');
          }
          return;
        }
        $cateres = DB::name('cate') -> select();
        $this -> assign('cateres',$cateres);
        return $this -> fetch();
    }


    // 修改管理员信息

    public function edit(){
        $id = input('id');
        $articles = Db::name('Article') -> find($id);
        if (request() -> isPost()) {
          $data=[
            // 左侧和数据表的内容对应，右侧的和表单的内容对应
            'id' => input('id'),
            'title' => input('title'),
            'author' => input('author'),
            'desc' => input('desc'),
            'keywords' => str_replace('，',',',input('keywords')),
            'content' => input('content'),
            'cateid' => input('cateid'),
          ];
          if (input('state') == 'on') {
            $data['state'] = 1;
          }else {
            $data['state'] = 0;
          }

          if ($_FILES['pic']['tmp_name']) {
            @unlink(SITE_URL.'/public/static'.$articles['pic']);//删除缩略图
            $file = request() -> file('pic');
            $info = $file -> move(ROOT_PATH . 'public' . DS . 'static/uploads');
            $data['pic'] = '/uploads/'.$info -> getSaveName();
          }
          // 如果修改密码处填写了密码，则密码修改为新的，否则不重新填写或修改的话，密码还是为原来的密码

          $validate = \think\Loader::validate('Article');
          if (!$validate -> scene('edit') -> check($data)) {//->scene('add')验证场景
            $this -> error($validate->getError());
            die;
          }

          if (db('Article') -> update($data)) {
            $this -> success('文章信息修改成功！','lst');
          }else {
            $this -> error('文章信息修改失败！');
          }
        }
        // 使用助手函数：db('Article') -> find($id);
        $cateres = DB::name('cate') -> select();
        $this -> assign('cateres',$cateres);
        $this -> assign('articles',$articles);
        return $this -> fetch();
    }

    // 删除

    public function del(){
      $id = input('id');
        if (db('Article')->delete(input('id'))) {
            $this -> success('删除文章成功!','lst');
        }else {
            $this -> error('删除文章失败！');
        }
    }
}
