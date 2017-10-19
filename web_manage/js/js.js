// JavaScript Document

$(function(){
	//导航切换
	$(".erji>li").click(function(){
		$(".erji>li.erji_hover").removeClass("erji_hover")
		$(this).addClass("erji_hover");
	});


	$('.yiji_a').click(function(){
		var $ul = $(this).next(".erji");
		$(this).parents(".yiji_li").find(".erji").slideUp();
		if($ul.is(':visible')){
			$(this).next(".erji").slideUp();
		}else{
			$('.erji').slideUp();
			$(this).next(".erji").slideDown();
		}
	});

	$('.table tr:odd').addClass("odd");

	$(".xuanhuan>a").click(function(){
		var index = $(this).index(".xuanhuan>a");
		$(this).addClass("zai").siblings().removeClass("zai");
		$(".miaoshu").eq(index).show().siblings(".miaoshu").hide();
	});



	$("#selectAll").click(function() {
		  if ($(this).attr("checked") == "checked") {
			  $("#selectAll").prop('checked', true);
			  $("#selectAll").attr("checked");
			  $(".zhengwen").find(".checked").prop('checked', false);
			  $(".zhengwen").find(".checked").attr('checked','checked');
		  } else {
			  $("#selectAll").prop('checked', false);//这个属性如果不加，只能执行一次全选功能
			  $("#selectAll").removeAttr("checked", "checked");// 如果之前没有选中，则，给他添加一个选中 属性  attr
			  $(".zhengwen").find(".checked").prop('checked', true);
			  $(".zhengwen").find(".checked").removeAttr("checked");

		  }
	  })
  })
