console.log('%c WWW.SHUWON.COM', 'font-size:40px;font-weight:700;-webkit-user-select: none;background-image: -webkit-gradient(linear, 0 0, right bottom, from(rgba(203, 0, 0, 1)), to(rgba(37, 220, 222, 1)));-webkit-background-clip: text;-webkit-text-fill-color: transparent;');
var shuwon = {
	percent: 0,
	timers: "",
	ishome: false,
	init: function (e) {
		// $(".header").load("header.html",function(){

		// })
		// $(".footer").load("footer.html",function(){

		// })
		// 输入框提示
		$("body").append('<div class="toast"><span></span></div>');
		// 返回到顶部
		$("body").append('<div class="backTop animate"></div>');
		// 加载动画
		// $("body").append("<div class='loading'><span></span></div>")

		shuwon.timers = setInterval(function () {
			shuwon.percent = ++shuwon.percent >= 99 ? 99 : shuwon.percent;
			$(".loading span").css({
				width: shuwon.percent + "%"
			});
			$(".loading b").html(shuwon.percent + "%");
		}, 50)
		shuwon.backTop();

		$('.menu-btn').click(function () {
			if ($('.menu').hasClass('active')) {
				$('.menu').removeClass('active')
				$(this).removeClass('active')
			} else {
				$('.menu').addClass('active')
				$(this).addClass('active')
			}
		})

		$('.contact h2,.footer_box .footer_tel b').click(function () {
			window.location.href = 'tel:' + $(this).text()
		})
		console.log(window.location.pathname)
		
		if(window.location.pathname=='/contact/'|| (window.location.pathname.indexOf('/newsinfo/')==0)){

		}else{
			if (!shuwon.ishome) {
				$(window).scroll(function (e) {
					$(".sub_banner img").css({
						"top": $(this).scrollTop() * .5
					})
				})
			}
		}
		
		AOS.init({
			easing: 'ease-in-out-sine',
			duration: 600,
			once:true
		});
	},

	/**
	 * 页面加载完毕
	 */
	loaded: function () {
		$(".loading span").css({
			width: 100 + "%"
		});
		$(".loading b").html(100 + "%");
		clearInterval(shuwon.timers);
		setTimeout(function () {
			$(".loading,.container,.nav,#navScroll").addClass("active");
		}, 500)
	},

	home: function () {
		$(".loading span").css({
			width: 100 + "%"
		})
		clearInterval(shuwon.timers);
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
			url:  url,
			dataType: 'json',
			success: function (data) {
				if (data.result) {
					callback(data)
				} else {
					shuwon.toast(data.msg);
				}
			},
			error: function (e) {
				shuwon.toast("数据加载错误", false)
			}
		})
	},
	getDataForApis: function (url, para, callback) {
		$.ajax({
			type: "post",
			data: para,
			url:  url,
			dataType: 'json',
			success: function (data) {
				callback(data)
			},
			error: function (e) {
				shuwon.toast("数据加载错误", false)
			}
		})
	},
	regEmail: function (obj) {
		reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((.[a-zA-Z0-9_-]{2,3}){1,2})$/
		return reg.test(obj);
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
	}
}
shuwon.init()