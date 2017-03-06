<?php
/** 
*微信红包用到的额外类
* @author   AndyYang 
* @more     www.webyang.net
 */ 

/*异常类*/
class  SDKException extends Exception {

	public function errorMessage() {
		return $this->getMessage();
	}

}

/*加密类*/
class MD5SignUtil {
	
	function sign($content, $key) {

	    try {
		    if (null == $key || null == $content) {
			   throw new SDKException("param error!");
		    }

		    $signStr = $content . "&key=" . $key;
		    return strtoupper(md5($signStr));

		}catch (SDKException $e) {
			die($e->errorMessage());
		}

	}
	
	function verifySignature($content, $sign, $md5Key) {

		$signStr       = $content . "&key=" . $md5Key;
		$calculateSign = strtolower(md5($signStr));
		$tenpaySign    = strtolower($sign);
		return $calculateSign == $tenpaySign;

	}
	
}

/*一些封装的公共方法类*/
class CommonUtil{
	
	function genAllUrl($toURL, $paras) {
		$allUrl = null;
		if(null == $toURL){
			die("toURL is null");
		}

		if (strripos($toURL,"?") =="") {
			$allUrl = $toURL . "?" . $paras;
		}else {
			$allUrl = $toURL . "&" . $paras;
		}

		return $allUrl;
	}

	function splitParaStr($src, $token) {
		$resMap = array();
		$items = explode($token,$src);
		foreach ($items as $item){
			$paraAndValue = explode("=",$item);
			if ($paraAndValue != "") {
				$resMap[$paraAndValue[0]] = $parameterValue[1];
			}
		}
		return $resMap;
	}
	
	static function trimString($value){
		$ret = null;
		if (null != $value) {
			$ret = $value;
			if (strlen($ret) == 0) {
				$ret = null;
			}
		}
		return $ret;
	}
	
	function formatQueryParaMap($paraMap, $urlencode){
		$buff = "";
		ksort($paraMap);
		foreach ($paraMap as $k => $v){
			if (null != $v && "null" != $v && "sign" != $k) {
			    if($urlencode){
				   $v = urlencode($v);
				}
				$buff .= $k . "=" . $v . "&";
			}
		}
		$reqPar;
		if (strlen($buff) > 0) {
			$reqPar = substr($buff, 0, strlen($buff)-1);
		}
		return $reqPar;
	}

	function formatBizQueryParaMap($paraMap, $urlencode){
		$buff = "";
		ksort($paraMap);
		foreach ($paraMap as $k => $v){
		//	if (null != $v && "null" != $v && "sign" != $k) {
			    if($urlencode){
				   $v = urlencode($v);
				}
				$buff .= strtolower($k) . "=" . $v . "&";
			//}
		}
		$reqPar;
		if (strlen($buff) > 0) {
			$reqPar = substr($buff, 0, strlen($buff)-1);
		}
		return $reqPar;
	}

	function arrayToXml($arr) {
        $xml = "<xml>";
        foreach ($arr as $key=>$val)
        {
        	 if (is_numeric($val))
        	 {
        	 	$xml.="<".$key.">".$val."</".$key.">"; 

        	 }
        	 else{
        	 	$xml.="<".$key."><![CDATA[".$val."]]></".$key.">";  
        	 } 
        }
        $xml.="</xml>";
        return $xml; 
    }
	
}
