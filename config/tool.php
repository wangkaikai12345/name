<?php

return [
    //微信账号
    //格式：[{"app_id":"wx124d8952d3123456","app_secret":"8cd0b6f79d8008d0d265e5b0e3123456"}]
    'wechat_account' => json_decode(env('WECAHT_ACCOUNT'), true),
];
