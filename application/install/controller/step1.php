<?php

namespace app\install\controller;

use gophp\request;
use gophp\response;

class step1 extends auth {

    public function index(){

        if(request::isAjax()){

            if(!session('step')){

                response::ajax(['code' => 300, 'msg' => '非法请求']);

            }

            $step1 = request::post('step1');

            if($step1){

                foreach ($step1 as $k => $v) {

                    response::ajax(['code' => 301, 'msg' => $v]);

                }

            }

            session('step', 2);

            response::ajax(['code' => 200, 'msg' => '提交成功']);

        }else{

            dump(PHP_SAPI);

            echo $_SERVER['SERVER_SOFTWARE'];

            session('step', 1);

            if(PHP_SAPI == 'apache2handler'){

                $server_env = 'apache';

            }elseif (PHP_SAPI == 'cgi-fcgi'){

                $server_env = 'nginx';

            }

            $system = [
                'php_os' => PHP_OS,
                'php_version' => PHP_VERSION,
                'server_env'  => $server_env
            ];

            $chmod['runtime'] = get_dir_chmod(ROOT_PATH.'/runtime/');
            $chmod['compile']      = get_dir_chmod(RUNTIME_PATH.'/compile');
            $chmod['config'] = get_dir_chmod(RUNTIME_PATH.'/config/');
            $chmod['log'] = get_dir_chmod(RUNTIME_PATH.'/log/');

            $this->assign('system', $system);
            $this->assign('chmod', $chmod);
            $this->display('step1');

        }

    }

}