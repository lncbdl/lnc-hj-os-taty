// JavaScript Document
$(function(){
	
	$('input:text:first').focus();
	
	$("input:text,textarea,input:password").focus(function() { 
	    $(this).addClass("cur_select"); 
	}); 
	$("input:text,textarea,input:password").blur(function() { 
	    $(this).removeClass("cur_select"); 
	}); 
});

/*
 *  创建依附小提示框
 *  param
 *     obj:  页面元素id 名称，e.g     <input type="text" name="user"/>  则参数为  "user"
 *     msg:  提示信息
 *	   action: 是否立即展现
 *  jquery 插件poshytip, 参考:http://vadikom.com/demos/poshytip/#
 *  使用此方法必须在页面加入 css js,如下:
 *  <link rel="stylesheet" type="text/css" href="{$smarty.const.IMG_SERVER}__PUBLIC__/css/tip-green/tip-green.css" />
 *  <script type="text/javascript" src="{$smarty.const.IMG_SERVER}__PUBLIC__/js/plugins/jquery.poshytip.min.js"></script>
 *  
 *  author:  lnc
 */
 
function makeTip(obj, msg, action) {

	if (obj) {
		$('#'+ obj).poshytip({
			content: msg,
			className: 'tip-green',
			showOn: 'focus',
			alignTo: 'target',
			alignX: 'inner-left',
			offsetX: 0,
			offsetY: 5
		});

		if (action) {
			$('#'+ obj).poshytip('show');
		}
	}

}