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
    ['username', 'require|min:5|token', "{code:".USERNAME_NOTNULL.",msg:'". map[USERNAME_NOTNULL] ."'}| {code:".USERNAME_TOSHORT.",msg:'".map[USERNAME_TOSHORT]."'}|{code:".TOKEN_ERROR.",msg:'".map[TOKEN_ERROR]."'}"],
    ['email', 'require|email', "{code:".EMAIL_NOTNULL.",msg:'".map[EMAIL_NOTNULL]."'}|{code:". EMAIL_ERROR.",msg:'".map[EMAIL_ERROR]."'}"],
    ['password', 'require|min:6', "{code:".PASSWORD_NOTNULL.",msg:'".map[PASSWORD_NOTNULL]."'}|{code:".PASSWORD_TOSHORT.",msg:'".map[PASSWORD_TOSHORT]."'}"],
]);

define('LAYOUT_RULE',[
   ['token','token',"{code:".TOKEN_ERROR.",msg:'".map[TOKEN_ERROR]."'}"]
]);


define('ADDPOST_RULE',[
    ['title','require|token',"{code:".EMPTY_TITLE.",msg:'".addpostMap[EMPTY_TITLE]."'}|{code:".TOKEN_ERROR.",msg:'".map[TOKEN_ERROR]."'}"],
    ['classify','require',"{code:".EMPTY_CLASSIFY.",msg:'".addpostMap[EMPTY_CLASSIFY]."'}"],
    ['editorValue','require',"{code:".EMPTY_CONTENT.",msg:'".addpostMap[EMPTY_CONTENT]."'}"],
]);
?>