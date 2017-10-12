#!/usr/bin/env python3
# -*- coding: utf-8 -*-

import urllib.request
import itertools
import re

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

# num = 0
# for page in itertools.takewhile(lambda x: x<=20414400, itertools.count(1)):
# 	url = 'https://bbs.hupu.com/%d.html' % page
# 	html = download(url)
# 	if html is None:
# 		error_num += 1
# 		if error_num > max_number:
# 			break # 达到最大错误数
# 	else:
# 		error_num = 0
# 		print('success ', page)
# 		num += 1
# 		print(num)
# 		pass
#print(download("https://bbs.hupu.com/20405211.html"));


def link_crawler(seed_url, link_regex = ''):
	"""爬取页面中 我们要访问的链接"""
	crawl_queue = [seed_url]
	while crawl_queue:
		url = crawl_queue.pop()
		html = download(url).decode('utf-8')
		print(len(get_links(html)))
		exit(0)
		for link in get_links(html):
			print(link)

			# if(re.match(link_regex, link)):
			# 	crawl_queue.append(link)

def get_links(html):
	"""返回页面上的链接"""
	webpage_regex = re.compile(r'<div class="titlelink box" style="width:645px;">\n<a\s+href="/(\d{1,10}).html"')
	return webpage_regex.findall(html)

#print(get_link("<div class=\"titlelink box\" style=\"width:645px;\"><a  href=\"/20415650.html\" >回顾人民的民义，大家觉得哪个画面或者场景或者哪句话最令你感到为之震撼？</a><span class=\"light_r\">"))
link_crawler('https://bbs.hupu.com/bxj')