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
			'email' => ['email', config('tips.mailbox')],
			'phone'  => ['telphone', config('tips.telphone')],
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
			'phone'  => $form->phone,
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
		$contact_copy = config('translator.contact');
		return <<<T
<form action="" method="post" class="form">
	<div class="contactsBom">
		<ul>
			<li class="first">$contact_copy</li>
			<li class="two">
				<span><input type="text" name="realname" placeholder="Name"/></span>
				<span><input type="text" name="email" placeholder="Email"/></span>
				<span style="padding-right: 0;"><input type="text" name="phone" placeholder="Phone"/></span>
			</li>
			<li class="three"><textarea name="message" rows="" cols="" placeholder="Message"></textarea></li>
			<li class="four"><a onclick="return model(this, '$U');" ><img src="/style/images/submit.jpg"/></a></li>
		</ul>
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

	public function model_download_form()
	{
		$verify = [
			// 'realname' => ['required', config('tips.name')],
			'firstName' => ['required', config('tips.firstName')],
			'lastName' => ['required', config('tips.lastName')],
			'email' => ['email', config('tips.mailbox')],
			'phone'  => ['telphone', config('tips.telphone')],
			'message' => ['need', config('tips.message')],
			'message' => ['need', config('tips.message')],
		];

		$form = new VerifyForm($verify, 'post');
		#验证不通过
		if ($form->result()) {
			returnJson(-100, $form->error, $form->field);
		}
		#更新密码

		$insert = $this->insert([
		    'realname' => $form->firstName . ' ' . $form->lastName,
			// 'qq' => $form->qq,
			'email' => $form->email,
			'phone'  => $form->phone,
			'message' => cutstr($form->message, 500),
			'ip' => $form->ip(),
			'type' => 1,
			'relate' => $form->fileid,
			'sendtime' => $form->time(),
		]);

		if ($insert) {
			returnJson(200, config('tips.message_success'));
		} else {
			returnJson(-100, config('tips.message_failed'));
		}
	}

	public static function download_form()
	{
		$U = '/ModelForm/?action=model_'.__FUNCTION__.'&csrf=' . Csrf::get();
		$download_alert1 = config('translator.download_alert1');
		$download_alert2 = config('translator.download_alert2');
		return <<<T
<div class="tipinfo form">
	<div>$download_alert1</div>
	<div>$download_alert2</div>
	<div>
		<input type="text" name="firstName" placeholder="First Name" class="first" />
		<input type="text" name="lastName" placeholder="Last Name" />

	</div>
	<div>
		<input type="text" name="email" placeholder="Email" class="first" />
		<input type="text" name="phone" placeholder="Phone number" />
	</div>
	<div>
		<input type="text" name="message" placeholder="Message" />
		<input id="saveFileIDInput" type="hidden" name="fileid" value="0" />
	</div>
	<div>
		<a href="#" onclick="return model(this, '$U');"><img src="/style/images/submit.png" /></a>
	</div>
</div>
<script type="text/javascript" src="/public/tools/js/jquery.js"></script>
<script>
	$("#message").click(function(){
		return model(this, "$U");
	})
</script>
T;
	}


	public function model_index_form()
	{
		$verify = [
			'email' => ['email', config('tips.mailbox')],
		];

		$form = new VerifyForm($verify, 'post');
		#验证不通过
		if ($form->result()) {
			returnJson(-100, $form->error, $form->field);
		}
		#更新密码

		$insert = $this->insert([
			'email' => $form->email,
			'ip' => $form->ip(),
			'type' => 2,
			'sendtime' => $form->time(),
		]);

		if ($insert) {
			returnJson(200, config('tips.message_success'));
		} else {
			returnJson(-100, config('tips.message_failed'));
		}
	}

	public static function index_form()
	{
		$U = '/ModelForm/?action=model_'.__FUNCTION__.'&csrf=' . Csrf::get();
		return <<<T
<p style="padding-top:20px;position: relative;" class="form">
	<input type="text" name="email" style="width: 231px;background: #323334;height: 54px;border-radius: 30px;border: navajowhite;padding-left: 15px;outline:none;" placeholder="Email Address"/>
	<input type="button" onclick="return model(this, '$U');" value="Subscribe" style="width:160px;background: #ec1b24;height: 54px;border-radius: 30px;border: navajowhite;position: absolute;left: 200px;padding-left: 15px;outline:none;"/>
</p>
<script type="text/javascript" src="/public/tools/js/jquery.js"></script>
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
