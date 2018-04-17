<?php
namespace app\admin\validate;
use think\Validate;
use think\Db;
class Tags extends Validate
{
  protected $rule = [
      'tagname' => 'require|max:25|unique:tags',
  ];
  protected $message = [
      'tagname.require' => 'Tag标签必须填写',
      'tagname.max' => 'Tag标签长度不能超过25',
      'tagname.unique' => 'Tag标签不能重复',
  ];
  protected $scene = [
      'add' => ['tagname'],//指定场景条件：'add' => ['username' => 'require','password'],
      'edit' => ['tagname'],
  ];
}
