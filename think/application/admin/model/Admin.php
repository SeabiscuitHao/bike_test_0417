<?php
namespace app\admin\model;
use think\Model;
use think\Db;
class Admin extends Model
{
  public function login($data)
  {
    $captcha = new \think\captcha\Captcha();//完全限定的方式将验证码类实例化一个对象 $captcha
    if (!$captcha -> check($data['code'])) {
      return 4;
    }
    $user = Db::name('admin') -> where('username','=',$data['username'])->find();
    if ($user) {
      if ($user['password'] == $data['password']) {
        session('username',$user['username']);
        session('id',$user['id']);
        return 3;
      }else {
        return 2;
      }
    }else {
      return 1;
    }
  }
}
