$(".inputname").click(function() {
	$("#inputname").show();
	$(".blackbox").show();
});
$(".redio").click(function() {
	$("#inputsex").show();
	$(".blackbox").show();
})
$(".inputpic").click(function() {
	$("#inputpic").show();
	$(".blackbox").show();
})
$(document).scroll(function() {
	var zhi = $(document).scrollTop();
	if(zhi > 80) {
		$(".top_menu").addClass("top_menufiex")
	} else {
		$(".top_menu").removeClass("top_menufiex")
	}
})
$("#clrean").click(function() {
	$(".blackbox").show();
	$("#clr").show();
});

$(".sure").click(function() {
	$(".blackbox").hide();
	$(".clreann").hide();
})
$(".return").click(function() {
	$(".blackbox").hide();
	$(".clreann").hide();
})

$("#returnn").click(function() {
	$(".blackbox").show();
	$(".returnn").show();
})

$("#ym").click(function() {
	if($(this).hasClass("addym")) {
		$(this).removeClass("addym");
		$(this).children("img").show();
		$(".yanma").show();
		$(".xianma").hide();

	} else {

		$(".yanma").hide();
		$(".xianma").show();
		$(this).children("img").hide();
		$(this).addClass("addym")
	}

})

$(".xuanzhong").click(function() {

	var thisimg = $(this).find('.img2');
	if(thisimg.css('display') == 'block') {
		thisimg.hide();
	} else {
		$(this).find(".img2").show();
	}

});
$(".shan").click(function() {
	if($(this).find('.img3').css('display') == 'block') {
		$(".img3").hide();
		$(".xuanzhong").find(".img2").hide();
	} else {
		$(".img3").show();
		$(".xuanzhong").find(".img2").show();
	}
})
$(".subbav").slideUp();
$(".i2").css("display", "none");
$(".mainbav").click(function() {
	if($(this).children('div').css('display') == 'block') {
		$(this).children(".i2").slideToggle(300);
		$(this).children("div").slideToggle(300);
	} else {
		$(".i2").slideUp(5);
		$(".subbav").slideUp(300);
		$(this).children(".i2").slideToggle(300);
		$(this).children("div").slideToggle(300);
	}
});
$(document).ready(function() {
	var add, reduce, num, num_txt;
	add = $(".J_jia"); //添加数量
	reduce = $(".J_jian"); //减少数量
	num = ""; //数量初始值
	num_txt = $(".num"); //接受数量的文本框

	/*添加数量的方法*/
	add.click(function() {

		num =  $(this).prev("label").children(".num").val();
		num++;
		$(this).prev("label").children(".num").val(num);

	});

	/*减少数量的方法*/
	reduce.click(function() {
		//如果文本框的值大于0才执行减去方法
		num = $(this).next("label").children(".num").val();
		if(num > 0) {
			//并且当文本框的值为1的时候，减去后文本框直接清空值，不显示0
			if(num == 1) {
				num--;
				$(this).next("label").children(".num").val("0");
			}
			//否则就执行减减方法
			else {
				num--;
				$(this).next("label").children(".num").val(num);
			}

		}
	});
})

$(".blackbox").click(function() {
	$(".blackbox").hide();
	$("#time").attr('style', 'bottom:-100%');
	$("#inputname").hide();
	$("#inputpic").hide();
	$("#inputsex").hide();
	$(".clreann").hide();

});

$(".xz li").click(function() {

	var thiss = $(this);
	if(thiss.hasClass('xzz')) {
		thiss.removeClass("xzz");
	} else {
		$(".xz li").removeClass("xzz");
		$(this).addClass("xzz");
	}
})
$(".xs li").click(function() {

	var thisx = $(this);
	if(thisx.hasClass('xzz')) {
		thisx.removeClass("xzz");
	} else {
		$(".xs li").removeClass("xzz");
		$(this).addClass("xzz");
	}
})

$(".time").click(function() {
	$(".blackbox").show();
	$("#time").attr('style', 'bottom:0');
})
$(".btn").click(function() {
	$(".blackbox").hide();
	$("#time").attr('style', 'bottom:-100%');

})

//$(".xz li").click(function() {
//
//	var thiss = $(this);
//	if(thiss.hasClass('xzz')) {
//		thiss.removeClass("xzz");
//	} else {
//		$(".xz li").removeClass("xzz");
//		$(this).addClass("xzz");
//	}
//})
//$(".xs li").click(function() {
//
//	var thisx = $(this);
//	if(thisx.hasClass('xzz')) {
//		thisx.removeClass("xzz");
//	} else {
//		$(".xs li").removeClass("xzz");
//		$(this).addClass("xzz");
//	}
//})