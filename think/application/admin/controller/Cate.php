<?php
namespace app\admin\controller;
use think\Db;
use app\admin\model\Cate as CateModel;
use app\admin\controller\Base;
class Cate extends Base
{
    public function lst()
    {
        $list = CateModel::paginate(3);
        $this -> assign('list',$list);
        //分配到模板中
        return $this -> fetch();
    }

    // 添加

    public function add()
    {
        if (request() -> isPost()) {
          $data=[
            'catename' => input('catename'),
            
          $validate = \think\Loader::validate('Cate');
          if (!$validate -> scene('add') -> check($data)) {//->scene('add')验证场景
            $this -> error($validate->getError());
            die;
          }
          if (Db::name('cate')->insert($data)) {
            return $this -> success('添加栏目成功！','lst');
          }else{
            return $this -> error('添加栏目失败！');
          }
          return;
        }
        return $this -> fetch();
    }


    // 修改栏目信息

    public function edit(){
        $id = input('id');
        $cates = Db::name('cate') -> find($id);
        if (request() -> isPost()) {
          $data=[
            // 左侧和数据表的内容对应，右侧的和表单的内容对应
            'id' => input('id'),
            'catename' => input('catename'),
          ];
          
          // 如果修改密码处填写了密码，则密码修改为新的，否则不重新填写或修改的话，密码还是为原来的密码

          $validate = \think\Loader::validate('cate');
          if (!$validate -> scene('edit') -> check($data)) {//->scene('add')验证场景
            $this -> error($validate->getError());
            die;
          }
          $save = db('cate') -> update($data);

          if ($save !== false) {
            $this -> success('修改栏目信息成功！','lst');
          }else {
            $this -> error('修改栏目信息失败！');
          }
        }
        // 使用助手函数：db('cate') -> find($id);
        $this -> assign('cates',$cates);
        return $this -> fetch();
    }

    // 删除

    public function del(){
      $id = input('id');
      if ($id != 1) {
        if (db('cate')->delete(input('id'))) {
            $this -> success('删除栏目成功!','lst');
        }else {
            $this -> error('删除栏目失败！');
        }
      }else {
          $this -> error('初始化栏目不能删除！');
      }
    }
}
