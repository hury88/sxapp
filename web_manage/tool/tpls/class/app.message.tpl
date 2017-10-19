<?php
/**
 * 留言类
 * 使用方法 Message::form();
 */
class Message
{
	const TABLE = 'message';

	public function index()
	{
		$verify = [
			'realname' => ['required', config('tips.name')],
			// 'sex' => ['required', config('tips.qq')],
			// 'phone'  => ['telphone', config('tips.telphone')],
			'email' => ['email', config('tips.mailbox')],
			'message' => ['need', config('tips.message')],
		];

		$form = new VerifyForm($verify, 'post');
		#验证不通过
		if ($form->result()) {
			returnJson(-100, $form->error, $form->field);
		}
		#更新密码

		$insert = $this->insert([
		    'realname' => $form->realname,
			// 'qq' => $form->qq,
			'email' => $form->email,
			// 'phone'  => $form->phone,
			'message' => cutstr($form->message, 500),
			'ip' => $form->ip(),
			'sendtime' => $form->time(),
		]);

		if ($insert) {
			returnJson(200, config('tips.message_success'));
		} else {
			returnJson(-100, config('tips.message_failed'));
		}
	}

	public static function form()
	{
		$U = U('ModelForm/?csrf=' . Csrf::get());
		return <<<T
<form name="" action="$U" method="post" class="form" >
  <div class="input-wrapper">
    <label for="full-name">姓名</label>
    <span class="wpcf7-form-control-wrap full-name">
      <input type="text" name="realname" value="" size="40" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required"/>
    </span></div>
    <div class="input-wrapper">
      <label for="email-address">Email</label>
      <span class="wpcf7-form-control-wrap email-address">
        <input type="text" name="email" value="" size="40" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required"/>
      </span></div>
      <div class="input-wrapper">
        <label for="message">留言信息</label>
        <span class="wpcf7-form-control-wrap message">
          <textarea name="message" cols="40" rows="10" class="wpcf7-form-control wpcf7-textarea" ></textarea>
        </span></div>
        <div class="input-wrapper">
          <input type="submit" onclick="return model(this, '$U');" value="发送" />
        </div>
      </form>
<script type="text/javascript" src="/public/tools/js/jquery.js"></script>
<script>
	$("#message").click(function(){
		return model(this, "$U");
	})
</script>
T;
	}


	public function insert($data)
	{
		return M(self::TABLE)->insert($data);
	}

	public function update($data, $where='')
	{
		return M(self::TABLE)->where($where)->update($data);
	}

}
