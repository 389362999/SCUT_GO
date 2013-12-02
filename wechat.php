<?php

define("TOKEN", "xcamel");
$wechatObj = new wechatCallbackapiTest();
if (isset($_GET['echostr'])) 
{
    $wechatObj->valid();
}
else
{
    $wechatObj->responseMsg();
}

class wechatCallbackapiTest
{
    public function valid()
    {
        $echoStr = $_GET["echostr"];
        if($this->checkSignature())
		{
            echo $echoStr;
            exit;
        }
    }

    private function checkSignature()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature )
		{
            return true;
        }
		else
		{
            return false;
        }
    }

    public function responseMsg()
    {
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

        if (!empty($postStr))
		{
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $fromUsername = $postObj->FromUserName;
            $toUsername = $postObj->ToUserName;
			$RmsgType = $postObj->MsgType;
			$event = $postObj->Event;
            $keyword = trim($postObj->Content);
			date_default_timezone_set (PRC);
            $time = time();
            $textTpl = "<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[%s]]></MsgType>
                        <Content><![CDATA[%s]]></Content>
                        </xml>";
			$TimeTable_1 = "<xml>
						 <ToUserName><![CDATA[%s]]></ToUserName>
						 <FromUserName><![CDATA[%s]]></FromUserName>
						 <CreateTime>%s</CreateTime>
						 <MsgType><![CDATA[news]]></MsgType>
						 <ArticleCount>2</ArticleCount>
						 <Articles>
						 <item>
						 <Title><![CDATA[%s]]></Title> 
						 <Description><![CDATA[]]></Description>
						 <PicUrl><![CDATA[]]></PicUrl>
						 <Url><![CDATA[]]></Url>
						 </item>
						 <item>
						 <Title><![CDATA[%s]]></Title>
						 <Description><![CDATA[]]></Description>
						 <PicUrl><![CDATA[]]></PicUrl>
						 <Url><![CDATA[]]></Url>
						 </item>
						 </xml> ";
		   $TimeTable_2 = "<xml>
						 <ToUserName><![CDATA[%s]]></ToUserName>
						 <FromUserName><![CDATA[%s]]></FromUserName>
						 <CreateTime>%s</CreateTime>
						 <MsgType><![CDATA[news]]></MsgType>
						 <ArticleCount>3</ArticleCount>
						 <Articles>
						 <item>
						 <Title><![CDATA[%s]]></Title> 
						 <Description><![CDATA[]]></Description>
						 <PicUrl><![CDATA[]]></PicUrl>
						 <Url><![CDATA[]]></Url>
						 </item>
						 <item>
						 <Title><![CDATA[%s]]></Title>
						 <Description><![CDATA[]]></Description>
						 <PicUrl><![CDATA[]]></PicUrl>
						 <Url><![CDATA[]]></Url>
						 </item>
						 <item>
						 <Title><![CDATA[%s]]></Title>
						 <Description><![CDATA[]]></Description>
						 <PicUrl><![CDATA[]]></PicUrl>
						 <Url><![CDATA[]]></Url>
						 </item>
						 </xml> ";
			$TimeTable_3 = "<xml>
						 <ToUserName><![CDATA[%s]]></ToUserName>
						 <FromUserName><![CDATA[%s]]></FromUserName>
						 <CreateTime>%s</CreateTime>
						 <MsgType><![CDATA[news]]></MsgType>
						 <ArticleCount>4</ArticleCount>
						 <Articles>
						 <item>
						 <Title><![CDATA[%s]]></Title> 
						 <Description><![CDATA[]]></Description>
						 <PicUrl><![CDATA[]]></PicUrl>
						 <Url><![CDATA[]]></Url>
						 </item>
						 <item>
						 <Title><![CDATA[%s]]></Title>
						 <Description><![CDATA[]]></Description>
						 <PicUrl><![CDATA[]]></PicUrl>
						 <Url><![CDATA[]]></Url>
						 </item>
						 <item>
						 <Title><![CDATA[%s]]></Title>
						 <Description><![CDATA[]]></Description>
						 <PicUrl><![CDATA[]]></PicUrl>
						 <Url><![CDATA[]]></Url>
						 </item>
						 <item>
						 <Title><![CDATA[%s]]></Title>
						 <Description><![CDATA[]]></Description>
						 <PicUrl><![CDATA[]]></PicUrl>
						 <Url><![CDATA[]]></Url>
						 </item>
						 </xml> ";
			if($RmsgType == "text")
			{
            if($keyword == "?" || $keyword == "t")
            {
                $msgType = "text";
                $contentStr = date("Y-m-d H:i:s",time());
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo $resultStr;
            }
			if($keyword == "你好")
			{
				$msgType = "text";
				$contentStr = "呵呵，大家都好啦\n";
				$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo $resultStr;
			}
			if($keyword == "周一课表")
			{
				$title = "周一课表";
				$title1 = "数电实验(双周8:30开始) \n课室:030406";
				$title2 = "大物实验(单周下午)  \n课室:26号楼";
				$resultStr = sprintf($TimeTable_2,$fromUsername,$toUsername,$time,$title,$title1,$title2);
				echo $resultStr;
			}
			if($keyword == "周二课表")
			{
				$title = "周二课表";
				$title1 = "大物(一二节)   课室:340404";
				$title2 = "模电(三四节)   课室:340603";
				$title3 = "毛概(晚上)     课室:330203";
				$resultStr = sprintf($TimeTable_3,$fromUsername,$toUsername,$time,$title,$title1,$title2,$title3);
				echo $resultStr;
			}
			if($keyword == "周三课表")
			{
				$title = "周三课表";
				$title1 = "复变函数(一二节)   课室:340402";
				$resultStr = sprintf($TimeTable_1,$fromUsername,$toUsername,$time,$title,$title1);
				echo $resultStr;
			}
			if($keyword == "周四课表")
			{
				$title = "周四课表";
				$title1 = "模电(一二节)    课室:330302";
				$title2 = "大物(三四节)    课室:340304";
				$title3 = "数电(五六节)    课室:340302";
				$resultStr = sprintf($TimeTable_3,$fromUsername,$toUsername,$time,$title,$title1,$title2,$title3);
				echo $resultStr;
			}
			if($keyword == "周五课表")
			{
				$title = "周五课表";
				$title1 = "电工实践(8:30上课)  \n课室:030402";
				$title2 = "体育(五六节)";
				$resultStr = sprintf($TimeTable_2,$fromUsername,$toUsername,$time,$title,$title1,$title2);
				echo $resultStr;
			}
			}
			if($RmsgType == "event")
			{
				if($event == "subscribe")
				{
					$msgType = "text";
					$contentStr = "欢迎关注我哦,Tuzki竭诚为一班的同学们提供服务（目前只实现了查询课表的功能,后续功能将陆续添加，大家有什么好的建议也可以向我提出哦）。  \n\n输入:周一课表  试试吧！";
					$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                	echo $resultStr;
				}
			}
			}
		else
		{
            echo "";
            exit;
        }
    }
}
?>