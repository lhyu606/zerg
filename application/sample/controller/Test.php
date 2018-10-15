<?php
namespace app\sample\controller;

use think\Request;

class Test
{
    // public function aloha($id, $name, $age)

	// 依赖注入
    // public function aloha(Request $request){
    // 	$id = request->param('id');
    // }

    public function aloha()
    {
    	$id = Request::instance()->param('id');
    	$name = Request::instance()->param('name');
    	$age = Request::instance()->param('age');
    	echo $id;
    	echo '<br>';
    	echo $name;
    	echo '<br>';
    	echo $age;
    	echo '<br>所有：<br>';
    	var_dump(Request::instance()->param()) ;
    	echo '<br>路径 ？ 以后的值<br>';
    	var_dump(Request::instance()->get()) ;
    	echo '<br>路径 ？ 以内的值<br>';
    	var_dump(Request::instance()->route()) ;
    	echo '<br>post body 里的值<br>';
    	var_dump(Request::instance()->post()) ;

    	echo '<br>使用 input() 方法取值：<br>';
    	$all = input('param');
    	// $all = input('get');
    	// $all = input('post');
    	$all1 = input('param.name');
    	var_dump($all);

    	echo '<br>使用 input() 方法取单个值：<br>';
    	$all1 = input('param.name');
    	var_dump($all1);
        // return 'aloha war....';
    }
}