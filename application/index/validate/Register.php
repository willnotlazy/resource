<?php
/**
 * Created by PhpStorm.
 * User: 欢迎
 * Date: 2019/1/4
 * Time: 15:32
 */
namespace app\index\validate;

use think\Validate;
class Register extends Validate
{
    protected $rule = REGISTER_RULE;
}
?>