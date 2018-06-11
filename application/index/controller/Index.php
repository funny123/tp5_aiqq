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
	// 人脸融合图片上传
	public function upload_face() {
		$request = Request::instance();
		// print_r($request);exit;
		$params = Request::instance()->param();
		$file = request()->file('file');
		$img_name = time();
		$domain = $request->domain();
		// 移动到框架应用根目录/public/uploads/ 目录下
		if ($file) {
			$info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
			if ($info) {
				// 成功上传后 获取上传信息
				// 输出 jpg
				// echo $info->getExtension();
				// 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
				// echo $info->getSaveName();
				// 输出 42a79759f284b767dfcb2a0197904287.jpg
				// echo $info->getFilename();
				// $params['image'] = ROOT_PATH . 'public' . DS . 'uploads' . DS . $info->getSaveName();
				//
				$img_path = $info->getSaveName();
				$data = array(
					'code' => 200201,
					'image' => $domain . '/uploads/' . $img_path,
					'msg' => '图片上传成功',
				);
			} else {
				// 上传失败获取错误信息
				$data = array(
					'code' => 200400,
					'msg' => '图片上传失败',
				);

			}
			exit(json_encode($data));
		}
		// $response = API::ptu_facemerge($params);
		// $arr = json_decode($response, 1);
		// $img_name = time();
		// $out_img = ROOT_PATH . 'public' . DS . 'uploads' . DS . $img_name . ".jpg";
		// $res = file_put_contents($out_img, base64_decode($arr['data']['image']));
		$img_name = time();
		// $domain = $request->domain();
		// if ($res) {
		// 	$data = array(
		// 		'code' => 200200,
		// 		'image' => $domain . '/uploads/' . $img_name . ".jpg",
		// 		'msg' => '融合成功',
		// 	);
		// } else {
		// 	$data = array(
		// 		'code' => 200400,
		// 		'msg' => '融合失败',
		// 	);
		// }
		// exit(json_encode($data));
	}
	// 人脸融合接口
	public function facemerge() {
		$request = Request::instance();
		// print_r($request);exit;
		$params = Request::instance()->param(true);
		// $file = request()->file('file');
		// 移动到框架应用根目录/public/uploads/ 目录下
		// if ($file) {
		// 	$info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
		// 	if ($info) {
		// 成功上传后 获取上传信息
		// 输出 jpg
		// echo $info->getExtension();
		// 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
		// echo $info->getSaveName();
		// 输出 42a79759f284b767dfcb2a0197904287.jpg
		// echo $info->getFilename();
		// $params['image'] = ROOT_PATH . 'public' . DS . 'uploads' . DS . $info->getSaveName();
		// } else {
		// 	// 上传失败获取错误信息
		// 	$data = array(
		// 		'code' => 200400,
		// 		'msg' => '图片上传失败',
		// 	);
		// 	exit(json_encode($data));
		// }
		// }
		$response = API::ptu_facemerge($params);
		$arr = json_decode($response, 1);
		$img_name = time();
		$out_img = ROOT_PATH . 'public' . DS . 'uploads' . DS . $img_name . ".jpg";
		$res = file_put_contents($out_img, base64_decode($arr['data']['image']));

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
	// 大头贴接口
	public function facesticker() {
		$request = Request::instance();
		// print_r($request);exit;
		$params = Request::instance()->param(true);
		$response = API::ptu_facemerge($params);
		$arr = json_decode($response, 1);
		$img_name = time();
		$out_img = ROOT_PATH . 'public' . DS . 'uploads' . DS . $img_name . ".jpg";
		$res = file_put_contents($out_img, base64_decode($arr['data']['image']));

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
