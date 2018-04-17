<?php
namespace app\admin\validate;
use think\Validate;
use think\Db;
class Admin extends Validate
{
  protected $rule = [
      'username' => 'require|max:25|unique:admin',
      'password' => 'require'
  ];
  protected $message = [
      'username.require' => '管理员名称必须填写',
      'username.max' => '管理员名称长度不能超过25',
      'username.unique' => '管理员名称不能重复',
      'password.require' => '管理员密码必须填写',
  ];
  protected $scene = [
      'add' => ['username','password'],//指定场景条件：'add' => ['username' => 'require','password'],
      'edit' => ['username' => 'require|unique:admin'],
  ];
}
