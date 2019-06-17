<?php
    ini_set('display_errors', '0');
	if (PHP_OS == "WINNT"){
		system('CHCP 65001');
	}

	if (count($argv) <= 1){
		echo <<<EOF
		获取文件内域名请求状态码
			参数1： 文件（每个域名之间使用换行符隔开，不得有其他特殊字符;
			参数ok: 即使状态码是200也会输出;
			参数title: 是否输出是否输出访问成功后的页面标题, 输出标题的域名请求状态码必须为200;
			参数num: 每个标题截取长度，默认为30, 如果有，必须要作为最后一个参数;
				其他参数位置任意\r\n
EOF;
		exit;
	}

	@$urlList = fopen($argv[1], 'r');
	if (!$urlList) die ("read file error!\r\n");

	$num = 1;
	$sub = preg_grep('/\d{1,2}$/', $argv);
	if (count($sub)) $sub = end($sub);
	else $sub = 30;

	while (!feof($urlList)) {
		$url = [];
		// 这里过滤网址
		preg_match('/^w{0,3}\.?[A-Za-z0-9]+\.[A-Za-z0-9]+\b/', trim(fgets($urlList)), $url);
		if (count($url)) $url = reset($url);
		else continue;

		$result = '';
		$result .= $num ++ . "\t" . $url;
		$response = @get_headers('http://' . $url, 1)[0];
		if ($response){
			if (stripos($response, '200')){
				if (array_search('ok', $argv))
					$result .= "\t -> OK";
				if (array_search('title', $argv)) {
					$getTitle = @fopen('https://' . $url, 'r');
					if ($getTitle) {
						$title = '';
						$searchTitleNum = 0;
						while (!feof($getTitle)) {
							$loop = trim(fgets($getTitle));
							// 取页面标题
							preg_match('/<title>(.*)<\/title>/', $loop, $title);
							if (count($title)){
								// 数量暂定为30
								$result .= "\t-> " . mb_substr(end($title), 0, $sub);
								break;
							}elseif ( ++ $searchTitleNum > 80) break;
						}
						fclose($getTitle);
					}
				}
			}else // 其他状态
				$result .= "\t -> " . $response;
		}elseif (!stripos($response, '200'))
			$result .= "\t -> not find ip";
		// 一行内容执行完毕
		if ($result != ($num - 1 . "\t$url"))
			echo $result . PHP_EOL;
	}
	fclose($urlList);
	echo PHP_EOL . "---executed---" . PHP_EOL;