<?php

namespace App\Http\Controllers\Wechat;

use App\Models\ThirdApp;
use App\Models\User;
use Illuminate\Http\Request;
use Overtrue\LaravelWeChat\EasyWeChat;
use Symfony\Component\HttpFoundation\Response;

class MiniAppController extends BaseController
{
    public function login(Request $request)
    {
        $code = $request->get('code', '');
        if (empty($code)) {
            return $this->error('code 不能为空', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $app     = EasyWeChat::miniApp();
        $account = $app->getAccount();

        $client = $app->getClient();
        try {
            $response = $client->get('/sns/jscode2session', [
                'query' => [
                    'appid'      => $account->getAppId(),
                    'secret'     => $account->getSecret(),
                    'js_code'    => $code,
                    'grant_type' => 'authorization_code',
                ],
            ]);
            $data = $response->toArray();
            if (empty($data['openid'])) {
                throw new \Exception($data['errmsg']);
            }

            $thirdApp = ThirdApp::query()->firstOrCreate([
                'openid'   => $data['openid'],
                'app_type' => ThirdApp::APP_TYPE_WECHAT_MINI_APP,
            ], [
                'unionid'     => empty($data['unionid']) ? '' : $data['unionid'],
                'session_key' => $data['session_key'],
            ]);
            if (empty($thirdApp->user_id)) {
                $user = User::create([
                    'name'     => '',
                    'email'    => md5($data['openid']) . '@shang-an.shawly.cn',
                    'password' => '',
                ]);
                $thirdApp->user_id = $user->id;
                $thirdApp->update();
            }

            auth()->login($thirdApp->user);
            $user  = auth()->user();
            $token = $user->createToken('api');

            return $this->success([
                'access_token' => $token->plainTextToken,
                'token_type'   => 'bearer',
                // 'expires_in' => 60, // TODO:: fill right expire time
            ]);
        } catch (\Throwable $throwable) {
            return $this->error($throwable->getMessage(), Response::HTTP_SERVICE_UNAVAILABLE);
        }
    }
}
