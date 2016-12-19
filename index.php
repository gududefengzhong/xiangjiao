<?php
/**
  * wechat php test
  */

//define your token
define("TOKEN", "mudiWeChat");
define("APIKEY", "bb0b38c903472f5db29687173664fcbb");
define("APIURL", "http://www.tuling123.com/openapi/api?key=KEY&info=INFO");
//define("BAIDU_AK","vopwCOgn1SLB7xtYIUDs0g16");

$wechatObj = new wechatCallbackapiTest();
$wechatObj->valid();
$wechatObj->responseMsg();

class wechatCallbackapiTest
{
	public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
        	echo $echoStr;
        	exit;
        }
    }
    
    //总开关,分配任务
    public function responseMsg() {
        
		//get post data, May be due to the different environments
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

      	//extract post data
		if (!empty($postStr)){
                
              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
		
                $RX_type = trim($postObj->MsgType);
                switch ($RX_type) {
                    case "text" :
                        $resultStr = $this->handleText($postObj);
                        break;
                    case "event" :
                        $resultStr = $this->handleEvent($postObj);
                        break;
                    case "image" :
                        $resultStr = $this->handleImage($postObj);
                        break;
                    case "location" :
                        $resultStr = $this->handleLocation($postObj);
                        break;
                    case "voice" :
                        $resultStr = $this->handleEvent($postObj);
                        break;
                    case "video" :
                        $resultStr = $this->handleEvent($postObj);
                        break;
                    case "link" :
                        $resultStr = $this->handleLink($postObj);
                        break;
                    default :
                        $resultStr = "unknown msg type : " . $RX_type;
                        break;
                }
                echo $resultStr;
        }else {
        	echo "";
        	exit;
        }
    }
    
    //处理文本
    public function handleText($postObj) {
        
        $keyword = trim($postObj->Content);
        
        //拦截用户输入的内容,兵做出适当的恢复,可以增加if else来分类处理
        if ( !empty($keyword) ) {
            $msgType = "text";
            
            //租房
            
            //相亲;
            if( $keyword == "男神" || $keyword == "女神" ) {
                $girl_arr = array(array('Title'=>'','Description'=>'我想有个TA','PicUrl'=>'http://fd.topit.me/d/31/be/1186697052985be31do.jpg','Url'=>'xunta6.duapp.com/findher/index.html'));
                $contentStr = $this->responseNews($postObj, $girl_arr);
                echo $contentStr;exit;
            }elseif( $keyword == '西岳旅游'){
		$girl_arr = array(array('Title'=>'','Description'=>'世界那么大，我想去看看','PicUrl'=>'http://pic64.nipic.com/file/20150417/9448607_090931516000_2.jpg','Url'=>'xunta6.duapp.com/mom/index.html'));
                $contentStr = $this->responseNews($postObj, $girl_arr);
                echo $contentStr;exit;
		}elseif(strstr($keyword, "天气")) {     //天气
//                 $str = mb_substr($keyword, -2, 2, "UTF-8");
                $city = mb_substr($keyword, 0, -2, "UTF-8");
                if (!empty($city)) {
                    $weather_arr = $this->get_weather_info($city);
                    if ($weather_arr && is_array( $weather_arr )) {
                        $contentStr = $this->responseNews($postObj, $weather_arr);
                        echo $contentStr;exit;
                    } else {
                        $contentStr = "抱歉，没有查到\"" . $city . "\"的天气信息！请查询他的上一级城市";
                    }
                }
            }elseif( $keyword == "你好") {
                $contentStr = "雷猴啊";
            }elseif( $keyword == "张宇飞" ) {
                $contentStr = "奥，他是傻屌，卡杂费!!";
            }elseif( $keyword == "傻逼" || $keyword == "sb" || $keyword == "傻吊") {
                $contentStr = "你他妈才是$keyword";
            }else{     //剩下的全用机器人来回答
                    $url = str_replace("INFO", $keyword, str_replace("KEY", APIKEY, APIURL));
                    /** 方法一、用file_get_contents 以get方式获取内容 */
                    $res = json_decode( file_get_contents($url) ,TRUE);
                    
                    //如果是菜谱,视频,小说
                    if( $res['code'] == 308000 ) {
                        foreach( $res['list'] as $k => $v ) {
                            if($k > 4) break;
                              $content_arr[$k]['Title'] = $v['name'];
                              $content_arr[$k]['Description'] = $v['info'];
                              $content_arr[$k]['PicUrl'] = $v['icon'];
                              $content_arr[$k]['Url'] = $v['detailurl'];
                            }
                            $contentStr = $this->responseNews($postObj, $content_arr);
                            echo $contentStr;
                    }elseif( $res['code'] == 200000 ) {   //如果是链接类的
                        $contentStr = $res['text']."\n".$res['url'];
                    }elseif( $res['code'] == 302000 ) {  //如果是新闻类的
                        foreach( $res['list'] as $k => $v ) {
                            if($k > 4) break;
                              $content_arr[$k]['Title'] = $keyword;
                              $content_arr[$k]['Description'] = "";
                              $content_arr[$k]['PicUrl'] = "";
                              $content_arr[$k]['Url'] = $v['url'];
                            }
                            $contentStr = $this->responseNews($postObj, $content_arr);
                            echo $contentStr;
                    }elseif( $res['code'] == 305000 ) {  //如果是列车类的
                        foreach( $res['list'] as $k => $v ) {
                            if($k > 4) break;
                              $content_arr[$k]['Title'] = $v['trainnum']." {$v['start']}-".$v['terminal'];
                              $content_arr[$k]['Description'] = $v['starttime']."-{$v['endtime']}";
                              $content_arr[$k]['PicUrl'] = $v['icon'];
                              $content_arr[$k]['Url'] = $v['detailurl'];
                            }
                            $contentStr = $this->responseNews($postObj, $content_arr);
                            echo $contentStr;
                    }elseif( $res['code'] == 100000 ) {
                        $contentStr = $res['text'];
                    }else {
                        $contentStr = "这个我还不会";
                    }
            }
        } else {
            $contentStr = "to get information, please input something...";
        }
        $contentStr = $this->responseText($postObj, $contentStr);
        echo $contentStr;
    }
    
    //处理事件
    public function handleEvent($object) {

        switch ($object->Event) {
            case "subscribe":
                $contentStr = "感谢您关注【我想有个Ta】" . "\n" . "微信号：live2solve" . "\n" . "目前平台功能如下:" . "\n" . "【1】 查天气，如输入：北京天气" . "\n" ."【2】寻找我的Ta，请输入：男神或者女神" . "\n" . "更多内容，敬请期待...";
                break;
            default :
                $contentStr = "Unknow Event: " . $object->Event;
                break;
        }
        $resultStr = $this->responseText($object, $contentStr);
        return $resultStr;
    }
    
    //处理图片消息
    private function handleImage($object) {
        
        $content = array("MediaId" => $object->MediaId);
        $result = $this->responseImage($object, $content);
        return $result;
    }
    
    //处理位置消息
    private function handleLocation($object) {
        
        $content = "哦！原来你也在这！你的位置是纬度为：".$object->Location_X."；经度为：".$object->Location_Y."；缩放级别为：".$object->Scale."；位置为：".$object->Label;
        $result = $this->responseText($object, $content);
        return $result;
    }
    
    //处理链接消息
    private function handleLink($object) {
        $content = "你发送的是链接，标题为：".$object->Title."；内容为：".$object->Description."；链接地址为：".$object->Url;
        $result = $this->responseText($object, $content);
        return $result;
    }
    
    //回复文本消息
    public function responseText($object, $content, $flag=0) {
        //文本模板
        $textTpl = "<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[text]]></MsgType>
                    <Content><![CDATA[%s]]></Content>
                    <FuncFlag>%d</FuncFlag>
                    </xml>";
        $resultStr = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $content, $flag);
        return $resultStr;
    }
    
    //回复图文消息
    /**
     * @param type $object   post对象
     * @param type $content  news数组
     * @return string
     */
    public function responseNews($object, $content) {
        
        $resultStr = '';
        //news模板
        $newsTplHead = "<xml>
                <ToUserName><![CDATA[%s]]></ToUserName>
                <FromUserName><![CDATA[%s]]></FromUserName>
                <CreateTime>%s</CreateTime>
                <MsgType><![CDATA[news]]></MsgType>
                <ArticleCount>%s</ArticleCount>
                <Articles>";
        $newsTplBody = "<item>
                <Title><![CDATA[%s]]></Title> 
                <Description><![CDATA[%s]]></Description>
                <PicUrl><![CDATA[%s]]></PicUrl>
                <Url><![CDATA[%s]]></Url>
                </item>";
        $newsTplFoot = "</Articles>
                <FuncFlag>0</FuncFlag>
                </xml>";
        foreach( $content as $k => $v ) {
            $resultStr .= sprintf($newsTplBody, $v['Title'], $v['Description'],$v['PicUrl'],$v['Url']);
        }
        $final_template = $newsTplHead.$resultStr.$newsTplFoot;
        return sprintf($final_template,$object->FromUserName, $object->ToUserName, time(), count($content));
    }
    
    private function responseImage($object, $imageArray) {
        
        $itemTpl = "<Image>
                    <MediaId><![CDATA[%s]]></MediaId>
                    </Image>";
        $item_str = sprintf($itemTpl, $imageArray['MediaId']);
        $imageTpl = "<xml>
                <ToUserName><![CDATA[%s]]></ToUserName>
                <FromUserName><![CDATA[%s]]></FromUserName>
                <CreateTime>%s</CreateTime>
                <MsgType><![CDATA[image]]></MsgType>
                $item_str
                </xml>";
        $result = sprintf($imageTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    public function get_weather_info($city) {
        
        $my_ak = 'vopwCOgn1SLB7xtYIUDs0g16';
        $result_arr = array();
        if ( $city ) {
            $str = file_get_contents("http://api.map.baidu.com/telematics/v3/weather?location=".$city."&output=json&ak=$my_ak");
            //解码json格式字符串
            $arr = json_decode($str,TRUE);
            if( $arr['status'] == 'success') {
//                $res = $arr['results'][0]['currentCity']."天气预报"."\n";
                $result_arr[0]['Title'] = $arr['results'][0]['currentCity']."天气预报";
                $result_arr[0]['Description'] = '';
                $result_arr[0]['PicUrl'] = '';
                $result_arr[0]['Url'] = '';
                foreach($arr['results'][0]['weather_data'] as $k => $v)
                    {
                        $tmp =  date('Y年n月d日', strtotime("+$k day"));
                        $tmp .=  " {$v['weather']}";
                        $tmp .=  " {$v['wind']}";
                        $tmp .=  " {$v['temperature']}";
                        $result_arr[$k + 1]['Title'] = $tmp;
                        $result_arr[$k + 1]['PicUrl'] = " {$v['dayPictureUrl']}";
                        $result_arr[$k + 1]['Description'] = '';
                        $result_arr[$k + 1]['Url'] = '';
                        $tmp = '';
    //                    $res .=  " {$v['dayPictureUrl']}";
                    }
                return $result_arr;
            }
            return "";
        } else {
            return "";
        }
    }
        
	private function checkSignature() {
            
            $signature = $_GET["signature"];
            $timestamp = $_GET["timestamp"];
            $nonce = $_GET["nonce"];	

            $token = TOKEN;
            $tmpArr = array($token, $timestamp, $nonce);
            sort($tmpArr);
            $tmpStr = implode( $tmpArr );
            $tmpStr = sha1( $tmpStr );

            if( $tmpStr == $signature ){
                    return true;
            }else{
                    return false;
            }
        }
}

?>
