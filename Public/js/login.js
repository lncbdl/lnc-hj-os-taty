$(function() { 
	
	$("#login_btn").live('click',function() {
		var username = $("#username").val().replace(/(^\s*)|(\s*$)/g, "");
		var password = $("#password").val().replace(/(^\s*)|(\s*$)/g, "");
		var app = $("#app").val();
		if(username == "") {
			makeTip('username', '请输入帐号或者手机号', false);
			$("#username").focus();
			return false;
		}
		if(password == "") {
			makeTip('password', '请输入密码', false);
			$("#password").focus();
			return false;
		}

		password = $.md5(password);
		$.ajax({
			type: "POST",
			url: "/ucenter/login_api/login",
			dataType: "json",
			data: {"grant_type":"password", "client_id":1, "username":username, "password":password},
			success: function(json) {
				if(json.status == 1){
					makeTip('username', json.info, true);
					return false;
				} else {
					makeTip('username', json.info, true);
					return false;
				}
			}
		});
	});
	
});