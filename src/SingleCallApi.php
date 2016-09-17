<?php
namespace Chao\Tts;

interface SingleCallApi
{
  public function tts($calledNum, $calledShowNum, $ttsCode, $ttsParam);
}