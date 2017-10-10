#!/usr/bin/env python3
# -*- coding: utf-8 -*-

import urllib.request
import itertools

#连续最大的错误数
max_number = 5

error_num = 0

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

num = 0
for page in itertools.takewhile(lambda x: x<=20414400, itertools.count(1)):
	url = 'https://bbs.hupu.com/%d.html' % page
	html = download(url)
	if html is None:
		error_num += 1
		if error_num > max_number:
			break # 达到最大错误数
	else:
		error_num = 0
		print('success ', page)
		num += 1
		print(num)
		pass
#print(download("https://bbs.hupu.com/20405211.html"));


import re

def link_crawler(seed_url, link_regex):
	"""爬取页面中 我们要访问的链接"""
	crawl_queue = [seed_url]
	while crawl_queue:
		url = crawl_queue.pop()
		html = download(url)
		for link in get_links(html):
			if(re.match(link_regex, link)):
				crawl_queue.append(link)

def get_link(html):
	"""返回页面上的链接"""
	webpage_regex = re.compile('(as)')
	return webpage_regex.findall(html)

print(get_link("adfasdfsaer34255-325"))