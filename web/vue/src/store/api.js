import axios from 'axios'
var qs = require('qs')


/*axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';*/


Object.assign(axios.defaults, axios.defaults.headers.post['Content-Type'])


/*搜索列表接口*/
export const getSearchList = (keyword,page,limit) => {
  return axios.get('/cover/index/search',{params:{keyword:keyword,page:1,limit:10}})
}

/*企业司法诉讼*/
export const getLegalList =(id) => {
  return axios.get('/cover/index/legal-info',{params:{id:id}})
}

/*企业基本信息接口*/
export const getInfoList =(id) => {
  return axios.get('/cover/index/get-info',{params:{id:id}})
}

/*企业年报*/
export const getReportList =(com_id) => {
  return axios.get('/cover/data/report',{params:{com_id:com_id}})
}

/*企业信息*/
export const getTopInfo =(id) => {
  return axios.get('/cover/index/top-info',{params:{id:id}})
}

/*热词*/
export const getHotList =() => {
  return axios.get('/cover/index/hot-key')
}

/*输出文本*/
export const getMatch = (text,property_id) =>{
	return axios.post('/index/home/text-match', qs.stringify({text:text,property_id:property_id}))
}


