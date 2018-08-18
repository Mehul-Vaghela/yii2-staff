<?php
namespace frontend\models;

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

            }else if($params['route'] == 'site-signup'){ 

                $route[] = '/site';
            	$route[] = 'signup';

            }
            else if($params['route'] == 'site-contact'){ 

                $route[] = '/site';
                $route[] = 'contact';

            }
            else if($params['route'] == 'site-request-password-reset'){ 

                $route[] = '/site';
                $route[] = 'request-password-reset';

            }

            //backend routes that are used in the frontend - end here*/

        }
        else{ 

            $route[] = '/site';
            $route[] = 'login';

        }

        $route = implode('/', $route);

        if(!empty($params['data'])){

            foreach($params['data'] as $k => $v){

                $data[$k] = (string)$v;

            }

        }        

        if(!empty($data)){

            $data = \common\models\System::getify($data);

            $route.='?'.$data;

        }

        return $route;

    }

}
