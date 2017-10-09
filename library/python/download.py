#!/usr/bin/env python3
# -*- coding: utf-8 -*-

import urllib.request
def download(url, user_agent = 'fred_spider', retry = 3):
	print('下载如下链接：',url)
	headers = {'User-agent' : user_agent}
	try:
		req = urllib.request.Request(url,headers = headers)
		html = urllib.request.urlopen(req).read()
	except urllib.request.URLError as e:
		print('下载遇到错误：', e.reason)
		html = None
		if retry > 0:
			if hasattr(e, 'code') and 400 <= e.code <= 600:
				
				return download(url, retry - 1)
	return html


print(download("http://data.kinggui.com/index-test.php"));