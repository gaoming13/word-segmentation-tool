<?php
class Cut {
  private $dictLangCn = [];
  private $dictLangJa = [];
  private $dictLangKr = [];

  private $dictStopCn = [];
  private $dictStopJa = [];
  private $dictStopKr = [];
  private $dictStopEn = [];

  public function __construct()
  {
    // 词库
    $useDict = ['cn', 'ja', 'kr'];
    foreach ($useDict as $dict) {
      $f = fopen('./dict/lang-'.$dict.'.txt', 'r');
      while (! feof($f)) {
        $line = preg_replace('/[\n\r]/', '', fgets($f));
        if ($dict == 'cn') {
          $this->dictLangCn[$line] = 1;
        } else if ($dict == 'ja') {
          $this->dictLangJa[$line] = 1;
        } else if ($dict == 'kr') {
          $this->dictLangKr[$line] = 1;
        }
      }
      fclose($f);
    }
    // 停止词
    $useDict = ['cn', 'ja', 'kr', 'en'];
    foreach ($useDict as $dict) {
      $f = fopen('./dict/stop-'.$dict.'.txt', 'r');
      while (! feof($f)) {
        $line = preg_replace('/[\n\r]/', '', fgets($f));
        if ($dict == 'cn') {
          $this->dictStopCn[$line] = 1;
        } else if ($dict == 'ja') {
          $this->dictStopJa[$line] = 1;
        } else if ($dict == 'kr') {
          $this->dictStopKr[$line] = 1;
        } else if ($dict == 'en') {
          $this->dictStopEn[$line] = 1;
        }
      }
      fclose($f);
    }
  }

  // 分词
  public function cut($str) {
    // 过滤特殊符号
    $str = preg_replace('/[【】#!！$%&"()*+,:;＂＃＄％＆@<>、。〃〄々〆〇〈〉《》「」『』【】〒〓〔〕〖〗〘〙〚〛〜〝〞〟＇－｜｝～｟｠｡｢｣､･（＠）｛｀＾＿［］＼＝，．：？；＜＞＊／＋=`_^\\\~\|{\}\[\]\?\/\.\-\']/u', ' ', $str);
    // 转小写
    $str = strtolower($str);
    // 按空格切分成短语
    $phraseArr = explode(' ', $str);
    $tagArr = [];
    foreach ($phraseArr as $phrase) {
      if ($phrase == '') continue;
      // 开始执行分词
      $findTagArr = $this->cutPhrase($phrase);
      // 停止词过滤
      foreach ($findTagArr as $tag) {
        if (! $this->isInDictStop($tag)) {
          $tagArr[] = $tag;
        }
      }
    }
    return $tagArr;
  }

  // 小段文字分词
  public function cutPhrase($str) {
    $len = mb_strlen($str);
    // 字符为1个
    if ($len <= 1) {
      return [];
    }
    // 纯字母类判断(channel、china)
    if (preg_match('/^[a-z]*$/u', $str)) {
      return $len < 16 ? [$str] : [];
    }
    // 纯数字
    if (preg_match('/^[0-9]*$/u', $str)) {
      // 年份(1980、2050)
      if (preg_match('/^[1|2][0-9]{3}$/u', $str)) {
        return [$str];
      }
      return [];
    }
    // 英文+数字标识类(1080p、720p)
    if (preg_match('/^[a-z0-9]*$/u', $str)) {
      return $len < 10 ? [$str] : [];
    }
    // 词库匹配(先匹配远距离的，逐步收紧)
    $tagArr = [];
    $maxLen = 8;
    for ($i = 0; $i < $len;) {
      $cutAway = $maxLen > $len ? $len : $maxLen;
      $nowCutAway = $cutAway;
      $isFind = false;
      while ($nowCutAway >= 1) {
        $tag = mb_substr($str, $i, $nowCutAway);
        if ($this->isInDictLang($tag)) {
          $tagArr[] = $tag;
          $isFind = true;
          break;
        } else {
          $nowCutAway--;
        }
      }
      if ($isFind) {
        $i += $nowCutAway;
      } else {
        $i++;
      }
    }
    // 没有匹配到一个，且是其它语言(Превосходство)
    // if (count($tagArr) == 0 && $len < 16) {
    //   $tagArr = [$str];
    // }
    return $tagArr;
  }

  // 是否在词库中
  public function isInDictLang($tag) {
    // 中 日
    if (preg_match('/[\x{4e00}-\x{9fa5}]+/u', $tag) || preg_match('/[\x{0800}-\x{4e00}]+/u', $tag)) {
      if (isset($this->dictLangCn[$tag])) return true;
      if (isset($this->dictLangJa[$tag])) return true;
    }
    // 韩
    if (preg_match('/[\x{ac00}-\x{d7a3}]+/u', $tag) && isset($this->dictLangKr[$tag])) {
      return true;
    }
    return false;
  }

  // 是否在停止词中
  public function isInDictStop($tag) {
    if (isset($this->dictStopCn[$tag])) return true;
    if (isset($this->dictStopJa[$tag])) return true;
    if (isset($this->dictStopKr[$tag])) return true;
    if (isset($this->dictStopEn[$tag])) return true;
    return false;
  }
}
