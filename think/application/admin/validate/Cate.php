<?php
namespace app\admin\validate;
use think\Validate;
use think\Db;
class Cate extends Validate
{
  protected $rule = [
      'catename' => 'require|max:25|unique:cate',
  ];
  protected $message = [
      'catename.require' => '栏目名称必须填写',
      'catename.max' => '栏目名称长度不能超过25',
      'catename.unique' => '栏目名称不能重复',
  ];
  protected $scene = [
      'add' => ['catename'],//指定场景条件：'add' => ['catename' => 'require','password'],
      'edit' => ['catename'],
  ];
}
