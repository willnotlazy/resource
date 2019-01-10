<?php
/**
 * Created by PhpStorm.
 * User: 欢迎
 * Date: 2019/1/10
 * Time: 15:25
 */
namespace app\index\validate;

use think\Validate;
class Layout extends Validate
{
    protected $rule = LAYOUT_RULE;
}
?>