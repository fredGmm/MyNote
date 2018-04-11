<?php
/** 无用文件 */
//<input type="hidden" name="<?php echo $this->security->get_csrf_token_name()?>" value="<?php echo $this->security->get_csrf_hash()?>" />

<!--//csrf 验证-->
<!--$this->security->csrf_verify();-->
<!---->
<!--// 如果不是ajax,post,无来源验证直接返回-->
<!--if (strtolower($_SERVER['REQUEST_METHOD']) != 'post' || !$this->input->is_ajax_request() || !\Library\Tools::checkReferer()) {-->
<!--    throw new UserException('REQUEST_ERROR');-->
<!--}-->
<!---->
<!--//$this->security->xss_clean($array[$index]);-->