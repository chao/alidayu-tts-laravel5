#阿里大于文本转语音通知 Laravel5支持库

#＃ 安装和配置


### 1、使用Composer进行安装，在您工程目录下执行

```shell
composer require chao/alidayu-tts-laravel5
```

### 2、增加Service Provider

请将以下代码增加到您的<code>config/app.php</code>文件的<code>providers</code>数组中。

```php
Chao\Tts\AlidayuServiceProvider::class
```

完成后您的代码将类似下面：


```php
        ...
        /*
         * Application Service Providers...
        */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
        ...
        Chao\Tts\AlidayuServiceProvider::class,
```

### 3、配置

请先执行以下命令生成配置文件：

```shell
php artisan vendor:publish
```

该命令将会把<code>tts.php</code>配置文件增加到您的配置文件目录<code>config</code>下。

修改项目环境变量增加阿里大于密钥配置。修改您的<code>.env</code>文件，并增加以下两个变量：

```php
ALIDAYU_TTS_KEY=YOUR_KEY
ALIDAYU_TTS_SECRETKEY=YOUR_SECRETKEY
ALIDAYU_TTS_FAKE=false
```

**注意：** 当<code>ALIDAYU_TTS_FAKE</code>设置为<code>true</code>的时候，程序将模拟发送文本转语音通知（不调用阿里大于），并一律返回发送成功的消息体。该功能主要用于集成测试。在测试环境下设置为<code>true</code>可有效避免程序员半夜被骚扰。

以上配置文件请从[阿里大于](http://www.alidayu.com)网站获得。


---

## 开始使用

### 1、程序调用

在您需要调用语音通知的控制器中引用本函数库。

```php
  use Chao\Tts\SingleCallPusher as SingleCall;
```

在需要调用的函数中：

```php

  public function postCall(SingleCall $singleCall)
  {
    $result = $singleCall->tts($calledNum, $calledShowNum, $ttsCode, $ttsParam);
  }
```

该<code>call</code>方法一共调用了4个参数。含义如下：

名称              | 类型         | 是否必须        | 示例         |  说明
:-----------     | :----------- | :-----------: | :----------- | :-----------
$calledNum       | 字符串        | 必须           | 13700000000  | 被叫号码，支持国内手机号与固话号码，格式如下：057188773344，13911112222，4001112222，95500
$calledShowNum   | 字符串        | 必须           | 4001112222   | 被叫号显，传入的显示号码必须是阿里大于“管理中心-号码管理”中申请或购买的号码
$ttsCode         | 字符串        | 必须           | TTS_10001    | TTS模板ID，传入的模板必须是在阿里大于“管理中心-语音TTS模板管理”中的可用模板
$ttsParam        | 数组          | 可选           | ［'key' => 'val'］  | 文本转语音（TTS）模板变量，传参规则array('key' => 'value')，其中key的名字须和TTS模板中的变量名一致

**注意：** <code>$ttsParam</code>中的数组应为一维数组，并且元素的值仅支持字符串类型。

参数具体使用请参见[阿里大于API文档](https://api.alidayu.com/doc2/apiDetail.htm?spm=a3142.8062534.3.2.aExnLt&apiId=25444)

### 返回执行发送的结果

发送成功后程序将会返回以下对象（示例）：

```json
{
  "result": {
    "err_code": "0",
    "mode": "237791^671231",
    "success": true,
  },
  "request_id": "57dcd4b5c0c6c",
}
```

调用失败将返回以下对象（示例）：

```json
{
  "code": 15,
  "msg": "Remote service error",
  "sub_code": "isv.INVALID_PARAMETERS",
  "sub_msg": "ttsParam invalid",
  "request_id": "qm4fd9jxe1xi",
}
```

详细返回结果请查询[阿里大于API](https://api.alidayu.com/doc2/apiDetail.htm?spm=a3142.8062534.3.2.aExnLt&apiId=25444)及相关文档。
## 鸣谢

>本项目参考了[AliSMS - For Laravel5](https://github.com/ISCLOUDX/alisms)代码。鸣谢 秋綾 （yoruchiaki@foxmail.com）所提供的短信部分功能。

## 作者

周超 <chao@zhou.fr>