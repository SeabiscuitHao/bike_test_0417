<?php
namespace app\Admin\controller;
use think\Db;
use app\admin\model\Links as LinksModel;
use app\admin\controller\Base;
class Links extends Base
{
    public function lst()
    {
        $list = LinksModel::paginate(3);
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
            'url' => input('url'),
            'desc' => input('desc'),
          ];
          $validate = \think\Loader::validate('Links');
          if (!$validate -> scene('add') -> check($data)) {//->scene('add')验证场景
            $this -> error($validate->getError());
            die;
          }
          if (Db::name('Links')->insert($data)) {
            return $this -> success('添加链接成功！','lst');
          }else{
            return $this -> error('添加链接失败！');
          }
          return;
        }
        return $this -> fetch();
    }


    // 修改管理员信息

    public function edit(){
        $id = input('id');
        $Links = Db::name('Links') -> find($id);
        if (request() -> isPost()) {
          $data=[
            // 左侧和数据表的内容对应，右侧的和表单的内容对应
            'id' => input('id'),
            'title' => input('title'),
            'url' => input('url'),
            'desc' => input('desc'),
          ];

          // 如果修改密码处填写了密码，则密码修改为新的，否则不重新填写或修改的话，密码还是为原来的密码

          $validate = \think\Loader::validate('Links');
          if (!$validate -> scene('edit') -> check($data)) {//->scene('add')验证场景
            $this -> error($validate->getError());
            die;
          }

          if (db('Links') -> update($data)) {
            $this -> success('链接信息修改成功！','lst');
          }else {
            $this -> error('链接信息修改失败！');
          }
        }
        // 使用助手函数：db('Links') -> find($id);
        $this -> assign('Links',$Links);
        return $this -> fetch();
    }

    // 删除

    public function del(){
      $id = input('id');
        if (db('Links')->delete(input('id'))) {
            $this -> success('删除链接成功!','lst');
        }else {
            $this -> error('删除链接失败！');
        }
    }
}
