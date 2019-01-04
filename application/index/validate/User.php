<?php
/**
 * Created by PhpStorm.
 * User: 欢迎
 * Date: 2019/1/4
 * Time: 15:32
 */
namespace app\index\validate;

use think\Validate;
class User extends Validate
{
    protected $rule = [
        ['username', 'require|min:5', "{code:".USERNAME_NOTNULL.",msg:'". map[USERNAME_NOTNULL] ."'}| {code:".USERNAME_TOSHORT.",msg:'".map[USERNAME_TOSHORT]."'}"],
        ['email', 'require|email', "{code:".EMAIL_NOTNULL.",msg:'".map[EMAIL_NOTNULL]."'}|{code:". EMAIL_ERROR.",msg:'".map[EMAIL_ERROR]."'}"],
        ['password', 'require|min:6', "{code:".PASSWORD_NOTNULL.",msg:'".map[PASSWORD_NOTNULL]."'}|{code:".PASSWORD_TOSHORT.",msg:'".map[PASSWORD_TOSHORT]."'}"],
    ];
}
?>