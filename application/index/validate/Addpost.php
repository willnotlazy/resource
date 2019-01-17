<?php
/**
 * Created by PhpStorm.
 * User: 欢迎
 * Date: 2019/1/17
 * Time: 9:17
 */
namespace app\index\validate;

use think\Validate;
class Addpost extends Validate
{
    protected $rule = ADDPOST_RULE;
}
?>