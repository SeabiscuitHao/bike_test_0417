<?php
namespace app\admin\validate;
use think\Validate;
use think\Db;
class Article extends Validate
{
  protected $rule = [
      'title' => 'require|max:25',
      'cateid' => 'require'
  ];
  protected $message = [
      'title.require' => '文章标题必须填写',
      'title.max' => '文章标题长度不能超过25',
      'cateid.require' => '文章所属类别必须选择',
  ];
  protected $scene = [
      'add' => ['title','cateid'],//指定场景条件：'add' => ['title' => 'require','cateid'],
      'edit' => ['title','cateid'],
  ];
}
