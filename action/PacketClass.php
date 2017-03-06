<?php
/** 
*相当于mvc的 action 类
* @author   AndyYang 
* @more     www.webyang.net
*/  

class PacketClass{

	private $wxapi;
    //private $callback_url = 'http://m.yanghehong.cn/packet/index.php?param=access_token'; //remind modify here
    private $callback_url = 'http://www.webyang.net/download/index.php?param=access_token'; //remind modify here

    function _route($fun,$param = ''){
		include_once "./lib/WxApi.php";
		$this->wxapi = new WxApi();
		switch ($fun)
		{
			case 'userinfo':
				return $this->userinfo();
				break;
			case 'wxpacket':
				return $this->wxpacket($param);
				break;
			default:
				exit("Error_fun");
		}
    }	

    /**
     * 用户信息
     * just openid
     */	
	private function userinfo(){ 

        $callback_url = $this->callback_url;

		$get  = $_GET['param'];
		$code = $_GET['code'];	
		if($get=='access_token' && !empty($code)){
			$json = $this->wxapi->get_access_token($code);
            if(!empty($json)) {
                return $json['openid'];
            } else { //not subscribe user
			    $this->wxapi->get_authorize_url($callback_url);
            }
		}else{ //subscribe user
		    $this->wxapi->get_authorize_url($callback_url,'snsapi_base');
		}
	}

    /**
     * 微信红包
     */		
	private function wxpacket($openid){
		return $this->wxapi->pay($openid);
	}

}
