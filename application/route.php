<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\Route;

Route::get([
    'group'                                             => 'index/Index/groupByClassify'
    ,'newLeast'                                         => 'index/Index/index'
    ,'reply'                                            => 'index/Index/getReply'
    ,'vigor'                                            => 'index/Index/showVigor'
    ,'compass'                                          => 'index/Index/showPostCompass'
    ,'level'                                            => 'index/Index/showLevelList'
    ,'viewpost/postid/:postid$'                         => 'index/Index/viewPost'
    ,'selfpost'                                         => 'index/User/viewMyPost'
    ,'selfcontent/postId/:postId$'                      => 'index/User/viewSelfPost'
    ,'active/:email/:activation_key'                    => 'index/User/activeCheck'
    ,'editSpace'                                        => 'index/User/editSelfSpace'
    ,'showuser'                                         => 'index/User/showUserInfo'
    ,'darkroom'                                         => 'index/User/darkRoom'
    ,'search'                                           => 'index/Index/search'
    ,'msg'                                              => 'index/User/showMsg'
]);

Route::post([
    'viewtimes'                     => 'index/Action/ajaxGetPostViewTimes'
    ,'indexviewtimes'               => 'index/Action/ajaxGetAllViewTimes'
    ,'layout'                       => 'index/User/layout'
    ,'addpost'                      => 'index/Action/addPost'
    ,'register'                     => 'index/User/register'
    ,'addreply'                     => 'index/Action/addReply'
    ,'editMySpace'                  => 'index/Action/editMySpace'
    ,'replyDialog'                  => 'index/User/ajaxGetReplyDialog'
    ,'getReplyNum'                  => 'index/User/ajaxGetReplyNum'
    ,'updateRange'                  => 'index/Range/ajaxGetNewRange'
]);

Route::rule([
    'checkLogin'                    => 'index/User/checkLogin'
    ,'login'                        => 'index/User/login'
    ,'info'                         => 'index/user/info'
    ,'createpost'                   => 'index/Action/postSomething'
    ,'/'                            => 'index/Index/index'
]);

return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],
];
