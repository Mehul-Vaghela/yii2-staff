<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class System extends Model
{

	const tz_offset = 0;

	public static function getRandomHash($params = NULL){
		$hash = sha1(System::rand_int(1, 99999999).microtime().System::rand_int(1, 99999999).System::rand_int(1, 99999999));
		if(!empty($params['length']) && is_numeric($params['length'])){
			$params['length'] = (int)$params['length'];
			$hash = substr($hash, 0, $params['length']);
		}
		return $hash;
	}
	
	public static function getTabAnchorText($data, $readOnly){
		if($readOnly == 1){
			return '#'.$data;
		}else{
			return 'javascript:void(0)';
		}
	}

    public static function getSystemDateTime(){
        return date('Y-m-d H:i:s');
    }

    public static function getDateTime(){
        return date('Y-m-d H:i:s');
    }

    public static function getDate(){
        return date('Y-m-d');
    }

    public static function getYear(){
        return date('Y');
    }

    public static function getFirstDayOfMonth($params=NULL){
	    if(empty($params)){
            return date('Y-m-01');
        }else{
	        return date('Y-m-01',strtotime($params['date']));
        }
    }

    public static function removeEmailPostFix($email){
    	$email = explode("@", trim($email));
		return $email[0];
    }

    public static function removeWhiteSpaces($string){
		return trim(preg_replace('/\s+/', ' ',$string));
	}

    public static function aliasify($string){
    	$string = trim($string);

		$replace = array();
    	$delimiter = '-';

		if(!empty($replace)){
			$string = str_replace((array)$replace, ' ', $string);
		}

		$string = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
		$string = preg_replace("/[^a-zA-Z0-9\/_.|+ -]/", '', $string);
		$string = strtolower(trim($string, '-'));
		$string = preg_replace("/[\/_.|+ -]+/", $delimiter, $string);

		return $string;
	}

	public static function rand_int($min, $max){
		$min = (int)$min;
		$max = (int)$max;
	
		return mt_rand($min,$max);
	}

	public static function cutStringWithEllipsis($string, $length){
		if(strlen($string) < $length){
			return $string;
		}
		
		$string_words = explode(' ', $string);
		$out = NULL;
		
		foreach ($string_words as $word){
			if((strlen($word) > $length) && $out == NULL){
				return substr($word, 0, $length)."...";
			}
		
			if((strlen($out) + strlen($word)) > $length){
				return $out."...";
			}
			
			$out.=" ".$word;
		}
		
		return trim($out);
	}

	public static function formatDateTime($datetime){
		$formatter = \Yii::$app->formatter;
		return $formatter->asDate($datetime, 'medium');
	}

	public static function formatDateTimeToDate($datetime){
		if(empty($datetime) || $datetime=="0000-00-00 00:00:00" || $datetime=="0000-00-00") return NULL;

		$datetime = strtotime($datetime);
		$datetime = date('Y-m-d', $datetime);

		return $datetime;
	}

	public static function formatDateTimeToDateTime($datetime){

		//database format to preview format

		if(empty($datetime) || $datetime=="0000-00-00 00:00:00" || $datetime=="0000-00-00")
			return NULL;

		/*$formatter = \Yii::$app->formatter;

		return $formatter->asDate($datetime, 'long');*/

		return date('F j, Y, g:i a', strtotime($datetime)); 

	}

	public static function formatDateTimeAgo($datetime){

		$datetime = strtotime($datetime);

	    $estimate_time = time() - $datetime;

	    if( $estimate_time < 1 )
	    {
	        return 'less than 1 second ago';
	    }

	    $condition = array( 
	                12 * 30 * 24 * 60 * 60  =>  'year',
	                30 * 24 * 60 * 60       =>  'month',
	                24 * 60 * 60            =>  'day',
	                60 * 60                 =>  'hour',
	                60                      =>  'minute',
	                1                       =>  'second'
	    );

	    foreach( $condition as $secs => $str )
	    {
	        $d = $estimate_time / $secs;

	        if( $d >= 1 )
	        {
	            $r = round( $d );
	            return 'about ' . $r . ' ' . $str . ( $r > 1 ? 's' : '' ) . ' ago';
	        }
	    }

	}	

	public function formatNumber($num){
        return empty((float)$num) ? 0 : \common\models\System::floatify($num);
    }

    public static function getSystemDomain(){

		return Yii::$app->params['system']['domainSystem'];

	}

	public static function getDomain(){

		return Yii::$app->params['system']['domainFrontend'];

	}

	public static function getDomainAsLink(){

		return Yii::$app->params['system']['domainFrontendAsLink'];

	}

	public static function getBackendDomain(){

		return Yii::$app->params['system']['domainBackend'];

	}

	public static function getBackendDomainAsLink(){

		return Yii::$app->params['system']['domainBackendAsLink'];

	}

	public static function getURL($params = NULL){

		if(!empty($params['type']) && $params['type']=="web") return "http://".System::getDomain();
		else if(!empty($params['type']) && $params['type']=="web-secure") return "https://".System::getDomain();
		else if(!empty($params['type']) && $params['type']=="domain-only") return System::getDomain();

		return System::getDomainAsLink();

	}

	public static function tabber($tab, $tab_set){

		if($tab==$tab_set)
			return 'active';
		else 
			return '';

	}

	public static function Array2DSearch($haystack, $field, $needle){

		foreach($haystack as $key => $row)
	   {
	      if($row[$field] === $needle) return $key;
	   }
	   
	   return false;

	}

	public static function concat($array, $concatenator = NULL){

		if(!empty($array) && is_array($array)){

			$array = implode($concatenator, $array);

			return $array;

		}

		return (string)$array;

	}

	public function getMetaData($index = NULL){

		$meta = array();

		$meta['keywords'] 				= ['name'=>'keywords', 'content'=>'']; 
		$meta['description'] 			= ['name'=>'description', 'content'=>''];
		$meta['og:image'] 				= ['property'=>'og:image', 'content'=>''];
		$meta['og:image:secure_url'] 	= ['property'=>'og:image:secure_url', 'content'=>''];
		$meta['og:image:width'] 		= ['property'=>'og:image:width', 'content'=>'1200'];
		$meta['og:image:height']		= ['property'=>'og:image:height', 'content'=>'630'];
		$meta['fb:app_id'] 				= ['property'=>'fb:app_id', 'content'=>''];
		$meta['og:url'] 				= ['property'=>'og:url', 'content'=>''];
		$meta['og:type'] 				= ['property'=>'og:type', 'content'=>''];
		$meta['og:title'] 				= ['property'=>'og:title', 'content'=>''];
		$meta['og:description'] 		= ['property'=>'og:description', 'content'=>''];

		$index = (string)$index;

		if(isset($meta[$index])){

			return $meta[$index];

		}

		return NULL;

	}

	public static function strip_tags($str){

		return strip_tags($str);

	}

	public static function titleCase($title) {
        
		//original Title Case script © John Gruber <daringfireball.net>
		//javascript port © David Gouch <individed.com>
		//PHP port of the above by Kroc Camen <camendesign.com>

        //remove HTML, storing it for later
        //       HTML elements to ignore    | tags  | entities
        $regx = '/<(code|var)[^>]*>.*?<\/\1>|<[^>]+>|&\S+;/';
        preg_match_all ($regx, $title, $html, PREG_OFFSET_CAPTURE);
        $title = preg_replace ($regx, '', $title);
        
        //find each word (including punctuation attached)
        preg_match_all ('/[\w\p{L}&`\'‘’"“\.@:\/\{\(\[<>_]+-? */u', $title, $m1, PREG_OFFSET_CAPTURE);
        foreach ($m1[0] as &$m2) {
            //shorthand these- "match" and "index"
            list ($m, $i) = $m2;
            
            //correct offsets for multi-byte characters (`PREG_OFFSET_CAPTURE` returns *byte*-offset)
            //we fix this by recounting the text before the offset using multi-byte aware `strlen`
            $i = mb_strlen (substr ($title, 0, $i), 'UTF-8');
            
            //find words that should always be lowercase…
            //(never on the first word, and never if preceded by a colon)
            $m = $i>0 && mb_substr ($title, max (0, $i-2), 1, 'UTF-8') !== ':' && 
                !preg_match ('/[\x{2014}\x{2013}] ?/u', mb_substr ($title, max (0, $i-2), 2, 'UTF-8')) && 
                 preg_match ('/^(a(nd?|s|t)?|b(ut|y)|en|for|i[fn]|o[fnr]|t(he|o)|vs?\.?|via)[ \-]/i', $m)
            ?   //…and convert them to lowercase
                mb_strtolower ($m, 'UTF-8')
                
            //else: brackets and other wrappers
            : ( preg_match ('/[\'"_{(\[‘“]/u', mb_substr ($title, max (0, $i-1), 3, 'UTF-8'))
            ?   //convert first letter within wrapper to uppercase
                mb_substr ($m, 0, 1, 'UTF-8').
                mb_strtoupper (mb_substr ($m, 1, 1, 'UTF-8'), 'UTF-8').
                mb_substr ($m, 2, mb_strlen ($m, 'UTF-8')-2, 'UTF-8')
                
            //else: do not uppercase these cases
            : ( preg_match ('/[\])}]/', mb_substr ($title, max (0, $i-1), 3, 'UTF-8')) ||
                preg_match ('/[A-Z]+|&|\w+[._]\w+/u', mb_substr ($m, 1, mb_strlen ($m, 'UTF-8')-1, 'UTF-8'))
            ?   $m
                //if all else fails, then no more fringe-cases; uppercase the word
            :   mb_strtoupper (mb_substr ($m, 0, 1, 'UTF-8'), 'UTF-8').
                mb_substr ($m, 1, mb_strlen ($m, 'UTF-8'), 'UTF-8')
            ));
            
            //resplice the title with the change (`substr_replace` is not multi-byte aware)
            $title = mb_substr ($title, 0, $i, 'UTF-8').$m.
                 mb_substr ($title, $i+mb_strlen ($m, 'UTF-8'), mb_strlen ($title, 'UTF-8'), 'UTF-8')
            ;
        }
        
        //restore the HTML
        foreach ($html[0] as &$tag) $title = substr_replace ($title, $tag[0], $tag[1], 0);
        return $title;
    }

    public static function getify($data){

    	$get = array();

    	if(!empty($data) && is_array($data)){

    		foreach($data as $k => $v){

	            $get[] = $k.'='.$v;

	        }

    	}

        $get = implode('&', $get);

        if(empty($get))
        	return '';
        else
        	return $get;

    }

    public static function getConstant($key){

    	$data = array();

    	if(defined('YII_ENV') && YII_ENV == 'prod'){
    	//production mode

    		$data['business_email'] = '';
    		$data['paypal_send_target'] = '';
    		$data['logo_docs'] = '';

    	}
    	else{
    	//dev mode

    		$data['business_email'] = '';
    		$data['paypal_send_target'] = '';
    		$data['logo_docs'] = '';

    	}

    	if(isset($data[$key])) return $data[$key];
    	else return NULL;

    }
    
    public static function getNumbersOnly($string){

    	return preg_replace("/[^0-9]/","",$string);

    }
    
    public static function getTimeStamp($datetime = NULL){

    	$datetime = empty($datetime) ? self::getDateTime() : $datetime;

    	$date = new \DateTime($datetime);
		
		return $date->format('U');
		
    }

    public static function getEmailsByRole($role){

    	$email_address = array(); # container of email addresses to receive the email

        # get the id's of users who have the HR role
        $ids = Yii::$app->authManager->getUserIdsByRole($role);

        foreach($ids as $k => $v){
        # just make sure id's are integers

            $ids[$k] = (int)$v; # typecast

        }

        if(!empty($ids)){
        # if there are user id's

            # find their user records
            $userModels = \common\models\User::find()->where(['id' => $ids])->all();

            $ids = NULL; # clear ids from memory

            # if user records found
            if(!empty($userModels)){

                foreach($userModels as $userModel) {
                # foreach item in the loop

                    # store the email address
                    $email_address[] = $userModel->email;

                }

            }

        }

        return $email_address;

    }

    public static function floatify($input){
    	$input = (float)$input; # typecast to float
    	return $input;
    }

    public static function monefy($input){
    	$input = '$'.number_format((float)$input,2); # typecast to float
    	return $input;
    }

    public static function getFlags(){
    	$flags = [1 => 'Yes', 0 => 'No'];
    	return $flags;
    }

    public static function getFlagAsText($value){
    	if($value === NULL){
    		return NULL;
    	}
    	else if($value) return 'Yes';
    	return 'No';
    }

}
