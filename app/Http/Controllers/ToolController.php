<?php

namespace App\Http\Controllers;

use App\Application;
use Illuminate\Http\Request;

class ToolController extends Controller
{
    public function index(Request $request)
    {
        $callback = $request->callback;
        $appid = $request->appid;

        if (!$appid || !$callback) {
            $arr = array('status'=>'400', 'msg' => '请告诉我你的appid', 'domain' => 'appid-error.com');
            return response($callback.'('.json_encode($arr).')');
        }

        $app = Application::where('app_id', $appid)->first();

        if (!$app || !$app->status) {
            $arr = array('status'=>'400', 'msg' => '我无法为您提供服务', 'domain' => 'app-error.com');
            return response($callback.'('.json_encode($arr).')');
        }

        $domain = $app->domains()->where('status', 1)->first();

        if (!$domain) {
            $arr = array('status'=>'400', 'msg' => '没有为您找到正确域名', 'domain' => 'domain-error.com');
            return response($callback.'('.json_encode($arr).')');
        }

        $arr = array('status'=>'200', 'msg' => '正确域名', 'domain' =>http_format($domain->title));

        return response($callback.'('.json_encode($arr).')');
    }
}
