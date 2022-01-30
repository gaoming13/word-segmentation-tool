<?php
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
