<?php
namespace app\index\controller;
use think\Controller;
use think\Loader;
use think\Request;

class Index extends Controller {
	public function _initialize() {
		Loader::import('qq_ai.sdk.API');
		Loader::import('qq_ai.sdk.Configer');
		Loader::import('qq_ai.sdk.HttpUtil');
		Loader::import('qq_ai.sdk.Signature');
		//请在此填入AppID与AppKey
		$app_id = '1106878837';
		$app_key = '3Rj7EszbrLTAxTCf';
		//设置AppID与AppKey
		Configer::setAppInfo($app_id, $app_key);
	}
	public function index() {
		$app_id = '1106878837';
		$app_key = '3Rj7EszbrLTAxTCf';
		$configer = Configer::setAppInfo($app_id, $app_key);
		if ($configer) {
			return 'OK';
		} else {
			return 'ERROR';
		}
	}
	// 人脸融合接口
	public function facemerge() {
		$params = [];
		$response = API::ptu_facemerge($params);
		$arr = json_decode($response, 1);
		$img_name = time();
		$out_img = ROOT_PATH . 'public' . DS . 'uploads' . DS . $img_name . ".jpg";
		$res = file_put_contents($out_img, base64_decode($arr['data']['image']));
		$request = Request::instance();

		$domain = $request->domain();
		if ($res) {
			$data = array(
				'code' => 200200,
				'image' => $domain . '/uploads/' . $img_name . ".jpg",
				'msg' => '融合成功',
			);
		} else {
			$data = array(
				'code' => 200400,
				'msg' => '融合失败',
			);
		}
		exit(json_encode($data));
	}
}
