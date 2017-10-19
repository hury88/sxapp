  function checkGoods(){
    var arr = getCheckedIds()
     if(arr.length == 0){
      //未选商品 提示 选择
      $('#delGoods').find('.tip-box').html(' <span class="warn-icon m-icon"></span> <div class="item-fore"> <h3 class="ftx-04">请至少选中一件商品！</h3> </div>')
      $('#delGoods').show();
      $('body').click(function(){$('#delGoods').hide()})
      //
     }else{
      $('input[name=goodspids]').val(arr.join(','))
      $('#myform').submit()
     }
  }

  //商品加减算总数-->
  function delMulti(){
    $('#delGoods').show()
    $('#delSure').click(function(){
      var arr  = getCheckedIds();
      var pids = arr.join(',');
      location.href = "{:U('Cart/del',array('pid'=>_pids_))}".replace(/_pids_/i,pids)
      setCheckedNum();
    })
    //隐藏
    $('#delCancel').click(function(){
      $('#delGoods').hide()
    })

  }

  function getCheckedIds(){
    var arr = new Array()
    $('.p-checkbox input:checkbox:checked').each(function(i,thisobj){
      arr[i] = thisobj.value
    })
    return arr;

  }
  //计算 选中的 商品个数
  function setCheckedNum(){
    $('.amount-sum em').html($('.p-checkbox input:checkbox:checked').length)
  }

  //计算 选中的 商品总价格
  function setTotal() {
    var total = 0;
    $('.p-checkbox input:checkbox:checked').each(function(){
        var index = $('.p-checkbox input:checkbox').index(this)

        str_sum = $('.itxt').eq(index).parents('.cell').siblings('.cell.p-sum').children('strong').html()
        total += parseFloat(str_sum.substr(1));

    })

    $('.sumPrice').children('em').html('¥'+total.toFixed(2))
  }

  function toggleCheckbox(){
    $('.p-checkbox input:checkbox').each(function(){
      thisParent = $(this).parents('.item-last');
      // if(!this.checked)
    })
  }

  function checkStatus(){
    var flag = true;
    $('.p-checkbox input:checkbox').each(function(i){
        if(!this.checked){
          flag = false;
          $('#toggle-checkboxes_down,#toggle-checkboxes_up').prop('checked',false);
          $(this).parents('.item-last').removeClass('item-selected');
        }else{
          $(this).parents('.item-last').addClass('item-selected');
        }
    })
    //商品全选 状态
    if(flag){
        $('.p-checkbox input:checkbox').parents('.item-last').addClass('item-selected');
        $('#toggle-checkboxes_down,#toggle-checkboxes_up').prop('checked',true);
    }
  }


  $(function () {
    //单选触发
    $('.p-checkbox input:checkbox').click(function(){
      checkStatus();setCheckedNum();setTotal();
    })
  //全选功能
  $('#toggle-checkboxes_down,#toggle-checkboxes_up').click(function(){
    checkstatus = this.checked
    $('.p-checkbox input:checkbox').prop('checked',checkstatus)
    setCheckedNum();setTotal();checkStatus();
  })

    //增加
    $('.increment').click(function(){
      t = $(this).prev('.itxt');
      $(this).prev().prev().removeClass('disabled');
      t.val(parseInt(t.val()) + 1)
      if(t.val() > t.parent().next().data('stock')){t.val(t.parent().next().data('stock'));
      $(this).addClass('disabled')
    }

    setPnumAjax(t);

    return false;
          })
    //减少
    $('.decrement').click(function(){
      t = $(this).next('.itxt');
      t.val(parseInt(t.val()) - 1)
      $(this).next().next().removeClass('disabled');
      if(t.val() <= 1){t.val(1); $(this).addClass('disabled');}

      setPnumAjax(t);

      return false;
          })
    //键盘输入
    $('.itxt').keyup(function(){
     var num = parseInt($(this).val());
     if(isNaN(num))$(this).val(1);
     else if(num < 1)$(this).val(1);
     else if(num > $(this).parent().next().data('stock'))$(this).val($(this).parent().next().data('stock'));
     else{
      $(this).val(num);
    }
       })

    $('.itxt').blur(function(){
      setPnumAjax($(this));
   })

    //提交商品数量
    function setPnumAjax(obj){
      $.ajax({
        url : "{:U('Cart/setAjax')}",
        type: "post",
        data: {
          'pid' : obj.data('id'),
          'goodsNum' : obj.val()
        },
        dataType:'json',
        success:function(_json_){
          obj.parents('.cell').siblings('.cell.p-price').children('strong').html('¥'+_json_.price)
          obj.parents('.cell').siblings('.cell.p-sum').children('strong').html('¥'+_json_.sum)
          obj.parent('.quantity-form').next('.quantity-txt').html(_json_.stock_status)
          setTotal()
        }
      })
    }
})
