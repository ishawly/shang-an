<?php

namespace App\Http\Controllers\Wechat;

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
                return $this->error($data['errmsg'], Response::HTTP_SERVICE_UNAVAILABLE);
            }

            return $this->success($response->toArray());
        } catch (\Throwable $throwable) {
            return $this->error($throwable->getMessage(), Response::HTTP_SERVICE_UNAVAILABLE);
        }
    }
}
