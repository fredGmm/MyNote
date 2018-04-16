<?php
/**
 * @see https://github.com/medcl/elasticsearch-analysis-ik
 **/

$s = <<<'EOF'
逼格
韦德
詹姆斯
科比
女朋友
女jr
拉文
格力芬
给力芬
快递员
吹牛逼
比尔吉沃特
纳尔
卡萨丁
杰斯
宅男
素觉
性骚扰
皮蓬
神龟
假日
隆多
不服就干
涨粉
孰强孰弱
排行榜
正负值
爆发
女生节
哈登
丑恩
大帝
恩比德
贾森基德
泰伦卢
一米九八
库兹马
保罗
阿德
德罗赞
流言板
路人王
唐斯
蒂格
虎扑
帝格
EOF;
header('Last-Modified: '.gmdate('D, d M Y H:i:s', time()).' GMT', true, 200);
header('ETag: "5816f349-19"');
echo $s;