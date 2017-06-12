<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px } a,a:hover{color:blue;}</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p><br/>版本 V{$Think.version}</div><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_55e75dfae343f5a1"></thinkad><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
    }

    public function copy(){
    	// $this->curlPost1();
    	// $testurl = 'http://pan.baidu.com/share/link?shareid=3142223074&uk=1864945200';
    	$testurl = 'http://pan.baidu.com/share/link?shareid=220706&uk=4197775610';
    	$downurl = $this->baiduPan($testurl);
    	//这个就是文件的真实下载地址，可以用浏览器或者下载工具试试
    	echo $downurl; 
    }

    public function curlPost($url, $post='', $autoFollow=0){
        $ch = curl_init();
        $user_agent = "Safari Mozilla/5.0 (Macintosh; Intel Mac OS X 10'_9_1) AppleWebKit/537.73.11 (KHTML, like Gecko) Version/7.0.1 Safari/5";
        curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
        // 2. 设置选项，包括URL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($ch, CURLOPT_HEADER, 0); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-FORWARDED-FOR:61.135.169.125', 'CLIENT-IP:61.135.169.125'));  //构造IP
        curl_setopt($ch, CURLOPT_REFERER, "http://www.baidu.com/");   //构造来路
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_PROXY, $this->proxy); 
        if($autoFollow){
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);  //启动跳转链接
            curl_setopt($ch, CURLOPT_AUTOREFERER, true);  //多级自动跳转
        }   
        //  
        if($post!=''){
            curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }   
        // 3. 执行并获取HTML文档内容
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    public function curlPost1(){
    	$proxy = "80.25.198.25";  
    	$proxyport = "8080";  
    	$ch = curl_init("http://sis001.com/forum/forum-426-1.html"); 
    	// http://sis001.com/forum/forum-426-1.html 
    	  
    	curl_setopt($ch, curlOPT_RETURNTRANSFER,1);  
    	curl_setopt($ch,curlOPT_proxy,$proxy);  
    	curl_setopt($ch,curlOPT_proxyPORT,$proxyport);  
    	curl_setopt ($ch, CURLOPT_TIMEOUT, 120);  
    	  
    	  
    	  
    	$result = curl_exec($ch);  
    	echo $result;  
    	  
    	curl_close($ch); 
    }

    public function baiduPan($url) {
        if (strpos($url, 'pan.baidu.com') === false) return false;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_URL, $url);
        $html = curl_exec($ch);
        echo $html;
        if (preg_match('/bdstoken="(.*?)".*?fsId="(.*?)".*?share_uk="(.*?)".*?share_id="(.*?)"/i', $html, $matches)) {
            // http://pan.baidu.com/share/autoincre?type=1&uk=4197775610&shareid=220706&sign=91589f8e197a99964ff986f0943df3bc261e8dab&timestamp=1495597055&bdstoken=null&channel=chunlei&clienttype=0&web=1&app_id=250528&logid=MTQ5NTU5NzQ0OTQzODAuMDAzMzgwOTY3NzY5NzcxODE0Mw==
            $proxyUrl  = sprintf('http://pan.baidu.com/share/download?bdstoken=%s&uk=%s&shareid=%s&fid_list=%%5B%s%%5D', $matches[1], $matches[3], $matches[4], $matches[2]);
        	// https://d11.baidupcs.com/file/7190f58808b2aac894e38ba6ff232b6c?bkt=p3-0000d902f2b4d7275a77312ee6d28c03ba47&xcode=918690b62a0314a868b262746dd8a5e7e42929a02b9fdf8b9717ec4418c70769&fid=4197775610-250528-1412584333&time=1495597848&sign=FDTAXGERLBHS-DCb740ccc5511e5e8fedcff06b081203-2aj6YjEcttL00gI9zUBtcjv7xpQ%3D&to=d11&size=5433293&sta_dx=5433293&sta_cs=38530&sta_ft=pdf&sta_ct=7&sta_mt=7&fm2=MH,Nanjing,Netizen-anywhere,,hunan,ct&newver=1&newfm=1&secfm=1&flow_ver=3&pkey=0000d902f2b4d7275a77312ee6d28c03ba47&sl=83492943&expires=8h&rt=sh&r=723642140&mlogid=3328021941331653597&vuk=282335&vbdid=1642600045&fin=2012%E5%B9%B4%E7%A4%BE%E4%BC%9A%E5%8C%96%E8%90%A5%E9%94%80%E6%A1%88%E4%BE%8B%E7%B2%BE%E9%80%89.pdf&fn=2012%E5%B9%B4%E7%A4%BE%E4%BC%9A%E5%8C%96%E8%90%A5%E9%94%80%E6%A1%88%E4%BE%8B%E7%B2%BE%E9%80%89.pdf&rtype=1&iv=0&dp-logid=3328021941331653597&dp-callid=0.1.1&hps=1&csl=293&csign=%2FkzH3QKdnGVqPObjk4SaFZu3zoA%3D&by=themis
        	echo $proxyUrl;
            curl_setopt($ch, CURLOPT_URL, $proxyUrl);
            $proxyHtml = curl_exec($ch);
            $jsonObj   = json_decode($proxyHtml, true);
            $downloadButtonUrl = $jsonObj['dlink'];
            $downloadButtonUrl = str_replace("\\\\/", "/", $downloadButtonUrl);
            curl_setopt($ch, CURLOPT_URL, $downloadButtonUrl);
            curl_setopt($ch, CURLOPT_VERBOSE, 1);
            curl_setopt($ch, CURLOPT_HEADER, 1);
            $result = curl_exec($ch);
            list($header, $body) = explode("\r\n\r\n", $result, 2);
            if (preg_match('/Location: (.*?)(\r?\n)/is', $header, $matches)) {
                return $matches[1];
            }
        }
        return false;
    }

    public function getFreeIp(){
    	$url = 'http://api.xicidaili.com/free2016.txt';
    	$curlobj = curl_init();
    	curl_setopt($curlobj, CURLOPT_URL, $url);
    	curl_setopt($curlobj, CURLOPT_HEADER, 0);
    	curl_setopt($curlobj, CURLOPT_RETURNTRANSFER, 1);
    	curl_setopt($curlobj, CURLOPT_TIMEOUT, 300);
    	curl_setopt($curlobj, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.101 Safari/537.36');
    	$outfile = fopen(PUBLIC_PATH.'ip.txt', 'wb');
    	curl_setopt($curlobj, CURLOPT_FILE, $outfile);
    	$rtn = curl_exec($curlobj);
    	curl_close($curlobj);
    	fclose($outfile);
    	echo 'get success!';
    }

    public function getLocalIp(){
    	$outfile = fopen(PUBLIC_PATH.'ip.txt', 'r') or die("open file failure!");
    	 while (!feof($outfile)) {
            $buffer = fgets($outfile);
            list($ip , $port) = explode(':', trim($buffer));
            $ips[] = compact('ip','port');
        }
        fclose($outfile);
        return $ips;
    }

    public function getLungtan(){
    	$ips = $this->getLocalIp();
    	$length = count($ips);
    	$rand = rand(0,$length);
    	$ip = $ips[$rand];
    	$url = 'http://lungtan.com/portal.php';
    	$curlobj = curl_init();
    	curl_setopt($curlobj, CURLOPT_URL, $url);
    	curl_setopt($curlobj, CURLOPT_HEADER, FALSE);
    	curl_setopt($curlobj, CURLOPT_RETURNTRANSFER, 1);
    	curl_setopt($curlobj, CURLOPT_SSL_VERIFYPEER, FALSE);    
        curl_setopt($curlobj, CURLOPT_SSL_VERIFYHOST, FALSE);  
        curl_setopt($curlobj, CURLOPT_AUTOREFERER, 1);  
    	curl_setopt($curlobj, CURLOPT_TIMEOUT, 100);
    	curl_setopt($curlobj, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.101 Safari/537.36');
    	curl_setopt($curlobj, CURLOPT_PROXY , $ip['ip'] );
    	curl_setopt($curlobj, CURLOPT_PROXYPORT , intval($ip['port']) );
    	curl_setopt($curlobj, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
    	$rtn = curl_exec($curlobj);
    	if( $no = curl_errno($curlobj) ){
    		echo $no.":".curl_error($curlobj);
    	}else{
    		echo $rtn;
    	}
    	curl_close($curlobj);
    	exit;

    }


    /**
     * 发送HTTP请求方法
     * @param  string $url    请求URL
     * @param  array  $params 请求参数
     * @param  string $method 请求方法GET/POST
     * @return array  $data   响应数据
     */
     function http($url, $params, $method = 'GET', $header = array(), $multi = false){
        $opts = array(
                CURLOPT_TIMEOUT        => 30,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_HTTPHEADER     => $header
        );
        /* 根据请求类型设置特定参数 */
        switch(strtoupper($method)){
            case 'GET':
                $opts[CURLOPT_URL] = $url . '?' . http_build_query($params);
                break;
            case 'POST':
                //判断是否传输文件
                $params = $multi ? $params : http_build_query($params);
                $opts[CURLOPT_URL] = $url;
                $opts[CURLOPT_POST] = 1;
                $opts[CURLOPT_POSTFIELDS] = $params;
                break;
            default:
                throw new Exception('不支持的请求方式！');
        }
        /* 初始化并执行curl请求 */
        $ch = curl_init();
        curl_setopt_array($ch, $opts);
        $data  = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);
        if($error) throw new Exception('请求发生错误：' . $error);
        return  $data;
     }
}