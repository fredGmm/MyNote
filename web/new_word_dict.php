<?php
/**
 * @see https://github.com/medcl/elasticsearch-analysis-ik
 **/

$s = <<<'EOF'
逼格
蓝瘦
EOF;
header('Last-Modified: '.gmdate('D, d M Y H:i:s', time()).' GMT', true, 200);
header('ETag: "5816f349-19"');
echo $s;