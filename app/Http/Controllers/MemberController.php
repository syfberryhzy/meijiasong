<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class MemberController extends Controller
{
    //个人中心首页
    public function register(Request $request)
    {
        $data = $this->getUserInfo($request);
        $user = User::firstOrNew([
            'openid' => $data['openid']
        ]);

        $user->save();
        // return response()->json([ 'data' => $user, 'info' => '登录成功！', 'status' => 1], 201);
        return $user;
    }

    /**
     * [update description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function getUserInfo($request)
    {
        $appid = config('miniprogram.program.appid');
        $secret = config('miniprogram.program.appsecret');
        $code = $request->code;

        $client = new \GuzzleHttp\Client();
        $url = 'https://api.weixin.qq.com/sns/jscode2session'
                 . "?appid={$appid}"
                 . "&secret={$secret}"
                 . "&js_code={$code}"
                 . '&grant_type=authorization_code';
        $res = $client->request('GET', $url);
        $data = json_decode($res->getBody(), true);

        if (isset($data['errcode'])) {
            return response()->json(['info' => $data['errmsg']], 403);
        }

        return $data;
    }

    /**
     * 个人编辑
     * @param  Request $request [description]
     * @param  User    $user    [description]
     * @return [type]           [description]
     */
    public function update(Request $request)
    {
        $user = \Auth::user();
        if ($request->avatar) {
            $user->avatar = $request->avatar;
        }

        if ($request->name) {
            $user->name = $request->name;
        }

        if ($request->gender) {
            $user->gender = $request->gender;
        }

        // if ($user->save()) {
        //     return response()->json([ 'data' => $user, 'info' => '修改完成', 'status' => 1], 201);
        // }
        // return response()->json([ 'data' => $user, 'info' => '修改失败', 'status' => 0], 201);
        $user->save();
        return $user;
    }
}
