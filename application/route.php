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
    'group/classify/:classify/[:second_classify]'       => 'index/Index/groupByClassify'
    ,'newLeast'                                         => 'index/Index/index'
    ,'reply'                                            => 'index/Index/getReply'
    ,'vigor'                                            => 'index/Index/getVigor'
    ,'top10'                                            => 'index/Index/getTop10'
    ,'compass'                                          => 'index/Index/showPostCompass'
    ,'level'                                            => 'index/Index/showLevelList'
    ,'viewpost/postid/:postid$'                         => 'index/Index/viewPost'
    ,'selfpost'                                         => 'index/User/viewMyPost'
    ,'selfcontent/postId/:postId$'                     => 'index/User/viewSelfPost'
]);

Route::post([
    'viewtimes'                     => 'index/Action/ajaxGetPostViewTimes'
    ,'indexviewtimes'               => 'index/Action/ajaxGetAllViewTimes'
    ,'layout'                       => 'index/User/layout'
    ,'addpost'                      => 'index/Action/addPost'
    ,'register'                     => 'index/User/register'
    ,'addreply'                     => 'index/Action/addReply'
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
