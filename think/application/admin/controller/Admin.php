  <?php
namespace app\admin\controller;
use think\Db;
use app\admin\model\Admin as AdminModel;
use app\admin\controller\Base;
class Admin extends Base
{
    public function lst()
    {
        $list = AdminModel::paginate(3);
        $this -> assign('list',$list);
        //分配到模板中
        return $this -> fetch();
    }

    // 添加

    public function add()
    {
        if (request() -> isPost()) {
          $data=[
            'username' => input('username'),
            'password' => input('password'),
          ];
          $validate = \think\Loader::validate('Admin');
          if (!$validate -> scene('add') -> check($data)) {//->scene('add')验证场景
            $this -> error($validate->getError());
            die;
          }
          if (Db::name('admin')->insert($data)) {
            return $this -> success('添加管理员成功！','lst');
          }else{
            return $this -> error('添加管理员失败！');
          }
          return;
        }
        return $this -> fetch();
    }


    // 修改管理员信息

    public function edit(){
        $id = input('id');
        $admins = Db::name('admin') -> find($id);
        if (request() -> isPost()) {
          $data=[
            // 左侧和数据表的内容对应，右侧的和表单的内容对应
            'id' => input('id'),
            'username' => input('username'),
          ];

          // 如果修改密码处填写了密码，则密码修改为新的，否则不重新填写或修改的话，密码还是为原来的密码

          if (input('password')) {
            $data['password'] = input('password');
          }else {
            $data['password'] = $admins['password'];
          }

          $validate = \think\Loader::validate('Admin');
          if (!$validate -> scene('edit') -> check($data)) {//->scene('add')验证场景
            $this -> error($validate->getError());
            die;
          }
          $save = db('admin') -> update($data);
          if ($save !== false) {
            $this -> success('修改管理员信息成功！','lst');
          }else {
            $this -> error('修改管理员信息失败！');
          }
        }
        // 使用助手函数：db('admin') -> find($id);
        $this -> assign('admins',$admins);
        return $this -> fetch();
    }

    // 删除

    public function del(){
      $id = input('id');
      if ($id != 1) {
        if (db('admin')->delete(input('id'))) {
            $this -> success('删除管理员成功!','lst');
        }else {
            $this -> error('删除管理员失败！');
        }
      }else {
          $this -> error('初始化管理员不能删除！');
      }
    }

    public function logout(){
      session(null);
      $this -> success('退出成功！','Login/index');
    }
}
