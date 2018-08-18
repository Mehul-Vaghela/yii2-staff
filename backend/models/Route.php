<?php
namespace backend\models;

use Yii;
use yii\base\Model;

class Route extends Model
{
	/*
    This class contains the STATELESS routes used by the website.
    'Stateless' means that the generated links are not dependent to any user-specific information such as id, username, etc.
    */

	public static function getRoute($params){
    	$data = NULL;
        $route = array();

        if(!empty($params['route'])){
            if($params['route'] == 'site-login'){
                $route[] = '/site';
            	$route[] = 'login';
            }
            else if($params['route'] == 'site-signup'){
                $route[] = '/site';
            	$route[] = 'signup';
            }else if($params['route'] == '/'){
                $route[] = '/';
            }else if($params['route'] == 'staff-index'){
                $route[] = '/staff';
                $route[] = 'index';
            }else if($params['route'] == 'staff-create'){
                $route[] = '/staff';
                $route[] = 'create';
            }else if($params['route'] == 'subject-index'){
                $route[] = '/subject';
                $route[] = 'index';
            }else if($params['route'] == 'subject-create'){
                $route[] = '/subject';
                $route[] = 'create';
            }else if($params['route'] == 'link-staff-subject-index'){
                $route[] = '/link-staff-subject';
                $route[] = 'index';
            }else if($params['route'] == 'link-staff-subject-create'){
                $route[] = '/link-staff-subject';
                $route[] = 'create';
            }else if($params['route'] == 'change-password'){
                $route[] = '/account';
                $route[] = 'change-password';
            }
            else if($params['route'] == 'update-image'){
                $route[] = '/account';
                $route[] = 'update-image';
            }


        }
        else{
            $route[] = '/site';
            $route[] = 'login';
        }

        $route = implode('/', $route);

        if(!empty($params['data'])){
            foreach($params['data'] as $k => $v){
                if(!empty($v)) $data[urlencode($k)] = urlencode((string)$v);
            }
        }        
        if(!empty($data)){
            $data = \common\models\System::getify($data);
            $route.='?'.$data;
        }
        return $route;
    }
}
