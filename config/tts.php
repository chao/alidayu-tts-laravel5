<?php
return [
  // 阿里大于的Key
  'key'       => env('ALIDAYU_TTS_KEY',null),
  // 阿里大于的密钥
  'secretKey' => env('ALIDAYU_TTS_SECRETKEY',null),
  // 是否假装发送TTS，如果设置为true则不会发送请求给阿里大于，可用于集成测试。
  'fake'      => env('ALIDAYU_TTS_FAKE', false),
];