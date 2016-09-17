<?php
namespace Chao\Tts;

use Illuminate\Support\Facades\Auth;
use Alibaba\Aliqin\Sdk\AlibabaAliqinFcTtsNumSinglecallRequest;
use Alibaba\Aliqin\Sdk\TopClient;

class SingleCallPusher implements SingleCallApi
{

  private $TopClient, $calledNum, $calledShowNum, $ttsCode, $ttsParam;

  /**
   * 注入框架
   * SingleCallPusher 构造函数，注入TopClient类.
   * @param TopClient $topClient
   */
  public function __construct(TopClient $topClient)
  {
    $this->TopClient            = $topClient;
    $this->TopClient->appkey    = config('tts.key');
    $this->TopClient->secretKey = config('tts.secretKey');
    $this->TopClient->format    = "json";
    $this->TopClient->simplify  = true;
  }

  /**
   * @param $calledNum 被叫号码 支持国内手机号与固话号码，
   *                          格式如下：057188773344，13911112222，
   *                                   4001112222，95500
   * @param $calledShowNum  被叫号显 传入的显示号码必须是阿里大于
   *                               “管理中心-号码管理”中申请或购买的号码
   * @param $ttsCode TTS模板ID 传入的模板必须是在阿里大于
   *                           “管理中心-语音TTS模板管理”中的可用模板
   * @param $ttsParam 文本转语音（TTS）模板变量 传参规则array(‘key’ => ‘value’)，
   *                                 其中key的名字须和TTS模板中的变量名一致
   * @return
   */
  public function tts($calledNum, $calledShowNum, $ttsCode, $ttsParam)
  {

    if(config('tts.fake'))
    {
      $resposne = array(
        "result" => [
            "err_code" => "0",
            "mode"     => rand(100000, 999999) . "^" . rand(100000, 999999),
            "success"  => true,
          ],
        "request_id" => uniqid()
      );
      $response = json_encode($resposne, JSON_FORCE_OBJECT);
      return json_decode($response);
    }
    $req = new AlibabaAliqinFcTtsNumSinglecallRequest();

    if (Auth::check() )
    {
      $req->setExtend(Auth::User()->id);
    }
    else
    {
      $req->setExtend(0);
    }

    if( !empty($ttsParam) && is_array($ttsParam))
    {
      $strTtsParam = json_encode($ttsParam,
                                    JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
      $req->setTtsParam($strTtsParam);
    }

    $req->setCalledNum($calledNum);
    $req->setCalledShowNum($calledShowNum);
    $req->setTtsCode($ttsCode);
    $resp = $this->TopClient->execute($req);
    return $resp;
  }
}