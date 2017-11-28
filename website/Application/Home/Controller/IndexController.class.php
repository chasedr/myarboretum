<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
	$this->display('Home:upload');
	echo "index function";
    }

	public function admin()
	{
		$this->display('Home:index');
	}
	public function uploadfile(){
		session('[destroy]');
		echo "post.sessionid=".I("post.sessionid");
		$sessionid=I("post.sessionid");
		session_id($sessionid);
		session_start();
		echo "uploadfile function";
		echo "useropenid=".session('useropenid');
		echo "test=".session('test');
		$useropenid = session('useropenid');
		$selfspace = M("selfspace");
		$data['selfspace_user_id'] = $useropenid;
		$data['selfspace_plantunit_name'] = I("post.plantname");
		$data['selfspace_inserttime']= I("post.submittime");
		$data['selfspace_describe'] = I("post.detail");
		$data['selfspace_picname'] = I("post.picnames");
		#print_r($data);
		#echo gettype($useropenid);
		$selfspace->add($data);

    $upload = new \Think\Upload();
    $upload->maxSize   =     3145728 ;
    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');
    $upload->rootPath  =     './Uploads/'; 
    #$upload->saveName  = array('uniqid','');
    $upload->saveName  = md5($_POST['picnames']);
    #$upload->savePath  =    "savePath";
    $upload->subName   =     md5(session('useropenid')).'/'.md5($_POST['plantname']);
    $upload->hash = false;
    $upload->thumb = false; //开启略所图
    $upload->thumbType = 0; //保持原始比例
    $info   =   $upload->upload();
	print_r($_POST);
	echo $upload->subName;
	$imagepath = './Uploads/'.$upload->subName.'/'.$upload->saveName.'.jpg';
	$image= new \Think\Image();
	$image->open($imagepath);
	$image->thumb(640,640)->save($imagepath);
    #if(!$info) {
    #    $this->error($upload->getError());
    #}else{
    #    $this->success('upload success');
    #}
	}
	public function getplants()
	{
		session('[destroy]');
		$sessionid=I("post.sessionid");
		session_id($sessionid);
		session_start();
		$selfspace = M("selfspace");
		$result = $selfspace->where('selfspace_user_id = \''.session('useropenid').'\'')->group('selfspace_plantunit_name')->select();
		#echo "return";
		#print_r(session('useropenid'));
		$plantlist = array();
		foreach($result as $item)
		{
			#print_r($item['selfspace_user_id']);
			$filename = explode('.',$item['selfspace_picname']);
			array_push($plantlist,md5($item['selfspace_user_id']).'/'.md5($item['selfspace_plantunit_name']).'/'.md5($item['selfspace_picname']).'.'.$filename[1]);
		}
		#var_dump($plantlist);
		$this->ajaxReturn($plantlist,'JSON');
	}
	
	public function login(){
		$APPID = 'wx609737a9f89b9dce';
		$AppSecret = 'aad6760983afe96bfc4ca75d4149d5f6';
		$code = I('get.js_code');
		$signature = I('get.signature');
		$rawData = I('get.rawData');//$_GET['rawData'];
		$iv = I('get.iv');
		$encryptedData = I('get.encryptedData');
		#echo "login function";	
		$response = $this->is_request("https://api.weixin.qq.com/sns/jscode2session?appid=".$APPID."&secret=".$AppSecret."&js_code=".$code.'&grant_type=authorization_code');
		if($response != false)
		{
			$response = json_decode($response,true);
			$openid = $response[openid];
			$session_key = $response[session_key];
			session('useropenid',$openid);
			session('test','login function');
			$sessionid = session_id();
			#print_r("sessionid = ".$sessionid);
			#$sessioncontent = session_id($sessionid);
			#print_r("session content = ".$sessioncontent);
			#session_start();
			#print_r($response);
			#echo "openid=".$openid;
			#echo "session_key=".$session_key;
			#echo "openid=".substr($openid, $start=0, 5);
			#print_r($_GET);
$data['sessionid'] = $sessionid;
$this->ajaxReturn($data,'JSON');
// 数字签名校验    
    $signature2 = sha1($rawData.$session_key);  
    if($signature != $signature2){  
        echo "数字签名失败";  
        die;  
    }  
    // 获取信息，对接口进行解密  
    Vendor("PHP.wxBizDataCrypt");  
    $encryptedData = $_GET['encryptedData'];  
    $iv = $_GET['iv'];  
    if(empty($signature) || empty($encryptedData) || empty($iv)){  
        echo "传递信息不全";  
    }  
    include_once "PHP/wxBizDataCrypt.php";  
    $pc = new \WXBizDataCrypt($APPID,$session_key);  
    $errCode = $pc->decryptData($encryptedData,$iv,$data);  
    if($errCode != 0){  
        echo "解密数据失败";  
        die;  
    }else {  
        $data = json_decode($data,true);  
        session('myinfo',$data);  
        $save['openid'] = $data['openId'];  
        $save['uname'] = $data['nickName'];  
        $save['unex'] = $data['gender'];  
        $save['address'] = $data['city'];  
        $save['time'] = time();  
        $map['openid'] = $data['openId'];  
        !empty($data['unionId']) && $save['unionId'] = $data['unionId'];  
 	echo "解密成功"; 
        }  
		}
		else
		{
			echo "cannot get openid";
		}
	}
    public function is_request($url, $ssl = true, $type = 'GET', $data = null)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        $user_agent = isset($_SERVER['HTTP_USERAGENT']) ? $_SERVER['HTTP_USERAGENT'] : 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36';
        curl_setopt($curl, CURLOPT_USERAGENT, $user_agent);//请求代理信息
        curl_setopt($curl, CURLOPT_AUTOREFERER, true);//referer头 请求来源
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);//请求超时
        curl_setopt($curl, CURLOPT_HEADER, false);//是否处理响应头
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);//curl_exec()是否返回响应
        if ($ssl) {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);//禁用后curl将终止从服务端进行验证
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);//检查服务器ssl证书中是否存在一个公用名（common name）
        }
        if ($type == "POST") {
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        //发出请求
        $response = curl_exec($curl);
        if ($response === false) {
            return false;
        }
        return $response;
    }

	public function showusers()
	{
		$User = M("user");
		$rows = $User->select();
		print_r($rows);
	}
	public function insertplant()
	{
		$selfspace = M("selfspace");
		$data['selfspace_plantunit_name'] = I("post.plantname");
		$data['selfspace_inserttime']= I("post.submittime");
		$data['selfspace_describe'] = I("post.detail");
		$data['selfspace_picname'] = I("post.picnames");
		print_r($data);
		$selfspace->add($data);
	}

}
