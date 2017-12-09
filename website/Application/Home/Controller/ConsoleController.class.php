<?php
namespace Home\Controller;
use Think\Controller;
class ConsoleController extends Controller {
	public function index(){
		$this->display('Home:index');
	}

	public function initMaintainplan(){
		$this->display('Home:insert_maintainplan');
	}
}