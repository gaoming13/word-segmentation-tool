# word-segmentation-tool

PHP版简单分词工具，支持中、繁、日、韩

PHP version of simple word segmentation tool, supporting Chinese, Chinese, Japanese and Korean.

## 示例用法

```php
require('Cut.php');

$startAt = microtime(true);

$cut = new Cut();

$tagArr = $cut->cut('1080p【.渠道手续费设置\:;】-#!/@<?_`~!！＃＂＄％＆＇（）＊＋，．＝＾｛＜＠＼＞｀＿？－／：；综合业务平台重构{优化|}^=*+*,([Channel fee setting] Reconfiguration and optimization of integrated business platform 【チャネル手数料設定】総合業務プラットフォームの再構築最適化 [채널 수수료 설정] 통합 비즈니스 플랫폼 재구성 및 최적화');
echo implode(' ', $tagArr).PHP_EOL;

$tagArr = $cut->cut("RARBG1936m-Cum4K.20.10.13.Jessie.Saint.Creampie.Booty.Call");
echo implode(' ', $tagArr).PHP_EOL;

$tagArr = $cut->cut("Превосходство-Transcendence.(2014).BDRip.[1080p].mkv");
echo implode(' ', $tagArr).PHP_EOL;

$tagArr = $cut->cut("徐州丰县被链子像狗一样拴住的女人生八个孩子的事引起公众强烈质疑，那些质疑无疑是有道理的");
echo implode(' ', $tagArr).PHP_EOL;

echo '=> 耗时：'.(microtime(true) - $startAt).'s'.PHP_EOL;
```

输出结果

```
1080p 渠道 手续费 设置 综合 业务 平台 重构 优化 channel fee setting reconfiguration optimization integrated business platform
手数料 設定 総合 業務 再構築 最適化 채널 수수료 설정 통합 비즈니스 플랫폼 재구성 최적화
cum4k jessie saint creampie booty
transcendence 2014 bdrip 1080p mkv
徐州 丰县 链子 狗 拴住 女人 生 八个 孩子 引起 公众 强烈 质疑 质疑 无疑 道理
=> 耗时：0.46238112449646s
```