#!/usr/bin/env python
#-*- coding:UTF-8 -*-
import urllib.request
import http.cookiejar
import random
import time

class BaiduTongji:
	referer = 'http://data.kinggui.com/index/test'
	targetPage = 'data.kinggui.com'
	BaiduID='d6e45f606eb597494e19dc2c3eefb6c7'
	Hjs='http://hm.baidu.com/h.js?'
	Hgif='http://hm.baidu.com/hm.gif?'
	UserAgent='Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36' #IE9
	MyData={'cc':'0','ck':'1','cl':'24-bit','ds':'1440x900','et':'3','ep':'2790352,2930','fl':'11.0','ja':'0','ln':'zh-cn','lo':'0','lv':'2','st':'3','v':'1.2.24'}

	def __init__(self,baiduID,targetPage=None,refererPage=None):
		self.targetPage = targetPage or self.targetPage
		self.refererPage = refererPage or self.referer
		self.BaiduID = baiduID
		self.MyData['si']=self.BaiduID
		self.MyData['su']=urllib.request.quote(self.referer)
		pass

	def run(self, timeout = 15):
		cj = http.cookiejar.CookieJar()
		opener = urllib.request.build_opener(urllib.request.HTTPCookieProcessor(cj))
		opener.addheaders=[("Referer",self.targetPage),("User-Agent",self.UserAgent)]
		try:
			response = opener.open(self.Hjs+self.BaiduID).info()
			print(self.Hjs+self.BaiduID,response)
			self.MyData['rnd'] = int(random.random()*2147483647)
			self.MyData['lt'] = int(time.time())
			fullurl=self.Hgif + urllib.parse.urlencode(self.MyData)
			response2=opener.open(fullurl,timeout=timeout).info()
			print(fullurl + '\r\r', response2)
			self.MyData['rnd'] = int(random.random()*2147483647)
			self.MyData['et'] = 3
			self.MyData['ep'] = '2000,100'
			response3=opener.open(self.Hgif+urllib.parse.urlencode(self.MyData),timeout=timeout).info()
			pass
			print(response3)
		except urllib.request.HTTPError as ex:
			print(ex.code)
			pass

if __name__ == "__main__":
	n = 1
	while n < 2:
		a = BaiduTongji('d6e45f606eb597494e19dc2c3eefb6c7','http://data.kinggui.com/index/test','http://data.kinggui.com/')
		a.run()
		time.sleep(1)
		n += 1