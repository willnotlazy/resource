<?php
/**
 * Created by PhpStorm.
 * User: 欢迎
 * Date: 2018/11/28
 * Time: 9:02
 */

/*
 *  index 的验证规则和返回信息
 */
define('REGISTER_RULE', [
    ['username', 'require|min:5|token', "{code:".USERNAME_NOTNULL.",msg:'". map[USERNAME_NOTNULL] ."',token:'".\think\Request::instance()->token()."'}| {code:".USERNAME_TOSHORT.",msg:'".map[USERNAME_TOSHORT]."',token:'".\think\Request::instance()->token()."'}|{code:".TOKEN_ERROR.",msg:'".map[TOKEN_ERROR]."',token:'".\think\Request::instance()->token()."'}"],
    ['email', 'require|email', "{code:".EMAIL_NOTNULL.",msg:'".map[EMAIL_NOTNULL]."'}|{code:". EMAIL_ERROR.",msg:'".map[EMAIL_ERROR]."'}"],
    ['password', 'require|min:6', "{code:".PASSWORD_NOTNULL.",msg:'".map[PASSWORD_NOTNULL]."'}|{code:".PASSWORD_TOSHORT.",msg:'".map[PASSWORD_TOSHORT]."'}"],
]);

define('LAYOUT_RULE',[
   ['username','require|token',"{code:".UNLAWFUL_ACTION.",mag:'".map[UNLAWFUL_ACTION]."',token:'".\think\Request::instance()->token()."'}|{code:".TOKEN_ERROR.",msg:'".map[TOKEN_ERROR]."',token:'".\think\Request::instance()->token()."'}"]
]);
?>