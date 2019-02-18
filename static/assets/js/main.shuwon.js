
var shuwon = {
	percent: 0,
	timers: "",
	init: function (e) {
		$("body").append('<div class="backTop animate"></div>');
		// // 加载动画
		this.common()
		this.backTop()
	},

	/**
	 * 页面加载完毕
	 */
	loaded: function () {
		
	},
	index:function(){

	},
	common:function(){
		// $('.header').load('header.html');
		// $('.footer').load('footer.html');
		f($('.menu .lists a.active'))
		function f(e){
			if(!e.hasClass('lists')){
				e.addClass('active')
				f(e.parent())
			}
		}
	},
    Secretary_mail: function (e) {
        var file_url = '',
            file_name = '',
            $text = $('#text'),
            $radioSelect = $('.radioSelect .radio')

        $radioSelect.click(function (e) {
            $(this).addClass('active').siblings().removeClass('active')
            console.log($('input[name="radio"]'))
            $('input[name="radio"]').val($(this).index())
        })
        layui.use('upload', function () {
            var $ = layui.jquery,
                upload = layui.upload;
            //指定允许上传的文件类型
            upload.render({
                elem: '#uploadWord',
                url: '/mail_file.html',
                accept: 'file', //普通文件
                exts: 'doc|docx|ppt|wps|rar|zip',
                done: function (res) {
                    console.log(res)
                    if (res.state === 'success') {
                        shuwon.toast("上传成功~")
                        file_name = res.original
                        file_url = res.url
                        $text.html(res.original)
                    } else {
                        shuwon.toast(res.msg)
                    }
                }
            });
        })


        var form = document.getElementById('categoryDirector'),
            $submit = $('.submit'),
            $cancle = $('.cancle')
        $submit.click(function (e) {
            if (form.title.value == '') {
                shuwon.toast('请填写信件主题')
                return
            } else if (form.username.value == '') {
                shuwon.toast('请填写姓名')
                return
            } else if (form.mobile.value == '') {
                shuwon.toast('请填写联系电话')
                return
            } else if (!shuwon.regPhone(form.mobile.value)) {
                shuwon.toast('请填写正确电话')
                return
            } else if (form.content.value == '') {
                shuwon.toast('请填写信件事项')
                return
            } else if (form.content.value.length<=10) {
                shuwon.toast('信件事项,不能少于10个字')
                return
            } else if ($('input[name="radio"]').val() == '') {
                shuwon.toast('是否公开?')
                return
            } else {
                shuwon.getDataForApi('/mail_post.html', {
                    category: form.id.value,
                    title: form.title.value,
                    name: form.username.value,
                    mobile: form.mobile.value,
                    isopen: $('input[name="radio"]').val(),
                    content: form.content.value,
                    file_url: file_url,
                    file_name: file_name,
                }, function (data) {
                    if (data.result) {
                        shuwon.toast('提交成功，我们会尽快回复您')
                        $cancle.click()

                    }
                })
            }
        })
        $cancle.click(function (e) {
            $radioSelect.removeClass('active')
            $text.html('未选择任何文件')
            $('input[name="radio"]').val('')
            file_url='',file_name=''
        })

    },
	/**
	 * 蜀美项目监控 
	 */
	shuwonProject: function () {
		if (/shuwon/.test(location.search) || sessionStorage.getItem('debugger') == '12345677') {
			sessionStorage.setItem("debugger", "12345677");
		} else {
			$.post("http://project.ishuwon.cn/api/project/stop", {
				url: location.origin
			}, function (data) {
				if (data.result) window.location.href = "http://www.shuwon.com/over/";
			})
		}
	},
	/**
	 * 返回顶部
	 */
	backTop: function () {
		var offset = 300,
			offset_opacity = 1200,
			scroll_top_duration = 500,
			$back_to_top = $('.backTop');
		$(window).scroll(function () {
			($(this).scrollTop() > offset) ? $back_to_top.addClass('active'): $back_to_top.removeClass('active');
			if ($(this).scrollTop() > offset_opacity) {
				$back_to_top.addClass('active')
			}
		});
		$back_to_top.on('click', function (event) {
			event.preventDefault();
			$('body,html').animate({
				scrollTop: 0
			}, scroll_top_duration)
		})
	},
	join:function(){
		$(".join_list ul li").click(function(){
			$(".lightBox").addClass("active");
		})
		$(".joinTipBoxTitle .close").click(function(){
			$(".lightBox").removeClass("active");
		})
	},
	/**
	* 加入我们弹出层
	*/
	join2:function(){
		$("._join2_list ul li .title").click(function(){
			if ($(this).hasClass("active")) {
				$(this).removeClass("active").next().slideUp();
			} else {
				$("._join2_list ul li .title").removeClass("active").next().slideUp();
				$(this).addClass("active").next().slideDown();	
			}
		})
		
	},
	/**
	 * 随机返回区间值
	 * min:最小值
	 * max:最大值
	 */
	rand: function (min, max) {
		return Math.random() * (max - min) + min;
	},
	/**
	 * 验证手机号码
	 * @param {obj}     传入的手机号码
	 * @return          正确返回true 错误返回false
	 */
	regPhone: function (obj) {
		reg = /^(13|15|17|18|14)[0-9]{9}$/;
		return reg.test(obj);
	},

	/**
	 * 判断验证码是否符合要求
	 */
	regCode: function (obj) {
		if (obj.length == 0 || obj.length != 6) {
			return true;
		}
		return false;
	},

	/**
	 * 只能输入中英文和数字
	 */
	regName: function (obj) {
		var reg = /^[\u4e00-\u9fa5]{2,20}$/;
		return reg.test(obj);
	},

	/**
	 * 姓名 || 只能输入中英文
	 * @param {obj}     传入的字符
	 * @return          正确返回true 错误返回false
	 */
	regName: function (obj) {
		reg = /^[\u4E00-\u9FA5A-Za-z]+$/;;
		return reg.test(obj);
	},

	/**
	 * 判断身份证号码是否符合要求
	 */
	regID: function (obj) {
		reg = /(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/;
		return reg.test(obj);
	},
	/**
	 * 提示信息
	 * @msg      	       提示的信息
	 * @success         true 成功 | false 失败
	 */
	toast: function (msg, sucess) {
		$(".toast").addClass("active").find("span").html(msg);
		if (!sucess) {
			$(".toast").addClass("warn");
		} else {
			$(".toast").removeClass("warn");
		}
		setTimeout(function () {
			$(".toast").removeClass("active")
		}, 1500)
	},
	/**
	 * 获取地址栏 
	 * @name         获取传入的参数
	 */
	getUrlParam: function (name) {
		var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
		var r = window.location.search.substr(1).match(reg);
		return r ? decodeURIComponent(r[2]) : null;
	},
	/**
	 * 倒计时
	 */
	countDownTime: function () {
		isClick = false;
		$('.yzmBtn').addClass("enable");
		$('.yzmBtn').addClass("active").html('60秒后重新获取')
		var waitTime, currTime = 59;
		var interval = setInterval(function () {
			shuwon.timeChange(currTime);
			currTime--;
			if (currTime < 0) {
				clearInterval(interval);
				currTime = waitTime;
			}
		}, 1000);
	},
	/**
	 * 时间戳转时间
	 * 
	 * @param {any} timer 
	 */
	Timer: function (timer) {
		var timeBpx = {
			Month: 0, //开始-月份
			Date: 0, //开始-号数
			Hours: 0, //开始-小时
			Minutes: 0, //开始-分钟
			day: 0, //剩余-天数
			hour: 0, //剩余-小时
			minute: 0, //剩余-分钟
			second: 0 //剩余-秒
		}
		var current = Math.floor(new Date().getTime() / 1000),
			TimeD = 0,
			time = new Date(timer * 1000);
		var dd_ = 0,
			hh_ = 0,
			mm_ = 0,
			ss_ = 0;
		TimeD = timer - current;
		dd_ = Math.floor(TimeD / (60 * 60 * 24)); //计算剩余的天数
		hh_ = Math.floor(TimeD / (60 * 60)) - (dd_ * 24) //计算剩余的小时数
		mm_ = Math.floor(TimeD / 60) - (dd_ * 24 * 60) - (hh_ * 60) //计算剩余的分钟数
		ss_ = Math.floor(TimeD) - (dd_ * 24 * 60 * 60) - (hh_ * 60 * 60) - (mm_ * 60) //计算剩余的秒数
		if (hh_ <= 9) hh_ = '0' + hh_;
		if (mm_ <= 9) mm_ = '0' + mm_;
		if (ss_ <= 9) ss_ = '0' + ss_;
		timeBpx.day = dd_ //天
		timeBpx.hour = hh_ //时
		timeBpx.minute = mm_ //分
		timeBpx.second = ss_ //秒
		timeBpx.Month = time.getMonth() + 1
		timeBpx.Date = time.getDate()
		timeBpx.Date = time.getHours()
		timeBpx.Date = time.getMinutes()

		return timeBpx
	},
	/**
	 * 获取数据
	 * @url      	       传入的数据接口
	 * @para      	       传入的参数
	 */
	getDataForApi: function (url, para, callback) {
		$.ajax({
			type: "post",
			data: para,
			url: location.origin + url,
			dataType: 'json',
			success: function (data) {
				callback(data)
			},
			error: function (e) {
				shuwon.toast("数据加载错误", false)
			}
		})
	}
}
shuwon.init()
// shuwon.shuwonProject()