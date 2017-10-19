/*******************************************************************************
* KindEditor - WYSIWYG HTML Editor for Internet
* Copyright (C) 2006-2011 kindsoft.net
*
* @author Roddy <luolonghao@gmail.com>
* @site http://www.kindsoft.net/
* @licence http://www.kindsoft.net/license.php
*******************************************************************************/

KindEditor.plugin('flv', function(K) {
	var self = this, name = 'flv', lang = self.lang(name + '.'),
		allowFlashUpload = K.undef(self.allowFlashUpload, true),
		allowFileManager = K.undef(self.allowFileManager, false),
		formatUploadUrl = K.undef(self.formatUploadUrl, true),
		uploadJson = K.undef(self.uploadJson, self.basePath + 'php/upload_json.php');
	self.plugin.flv = {
		edit : function() {
			var html = [
				'<div style="padding:20px;">',
				'<div class="ke-dialog-row">方法一、上传本机FLV视频文件：</div>',
				//url
				'<div class="ke-dialog-row">',
				'<label for="keUrl" style="width:60px;">' + lang.url + '</label>',
				'<input class="ke-input-text" type="text" id="keUrl" name="url" value="" style="width:160px;" /> &nbsp;',
				'<input type="button" class="ke-upload-button" value="' + lang.upload + '" /> &nbsp;',
				'<span class="ke-button-common ke-button-outer">',
				'<input type="button" class="ke-button-common ke-button" name="viewServer" value="' + lang.viewServer + '" />',
				'</span>',
				'</div>',
				//width
				'<div class="ke-dialog-row">',
				'<label for="keWidth" style="width:60px;">' + lang.width + '</label>',
				'<input type="text" id="keWidth" class="ke-input-text ke-input-number" name="width" value="600" maxlength="4" /> ',
				'</div>',
				//height
				'<div class="ke-dialog-row">',
				'<label for="keHeight" style="width:60px;">' + lang.height + '</label>',
				'<input type="text" id="keHeight" class="ke-input-text ke-input-number" name="height" value="400" maxlength="4" /> ',
				'</div>',

				'<div class="ke-dialog-row">方法二、插入其他网站视频代码(如土豆、优酷、酷六等)：</div>',
				'<textarea class="ke-textarea" style="width:408px;height:100px;" name="video_code"></textarea>',
				'</div>'
			].join('');
			var dialog = self.createDialog({
				name : name,
				width : 450,
				title : self.lang(name),
				body : html,
				yesBtn : {
					name : self.lang('yes'),
					click : function(e) {
						var url = K.trim(urlBox.val()),
							width = widthBox.val(),
							height = heightBox.val(),
							video_code = video_codeBox.val();


						if(video_code!=""){

						var html = '<p style="text-align:center;">'+video_code+'</p>';
	
						}else{

						
							
						if (url == 'http://' || K.invalidUrl(url)) {
							alert(self.lang('invalidUrl'));
							urlBox[0].focus();
							return;
						} 


						if (!/^\d*$/.test(width)) {
							alert(self.lang('invalidWidth'));
							widthBox[0].focus();
							return;
						}
						if (!/^\d*$/.test(height)) {
							alert(self.lang('invalidHeight'));
							heightBox[0].focus();
							return;
						}
						var html = 
						'<script type="text/javascript" src="'+K.basePath+'/plugins/ckplayer/ckplayer.js" charset="utf-8"></script>\r\n'
						+'<div id="a1" style="width:100%;margin:0 auto;text-align:center">正在加载播放器...</div>\r\n'
						+'<script type="text/javascript">\r\n'
						
						+'var s1=new swfupload();\r\n'
						+'s1.ckplayer_url="'+K.basePath+'plugins/ckplayer/ckplayer.swf";\r\n'
						+'s1.ckplayer_flv="'+url+'";\r\n'
						+'s1.ckplayer_pat="2";\r\n'
						+'s1.ckplayer_style=0;\r\n'
						+'s1.ckplayer_default=0;\r\n'
						+'s1.ckplayer_endstatus=2;\r\n'
						+'s1.ckplayer_volume=40;\r\n'
						+'s1.ckplayer_play=0;\r\n'
						+'s1.ckplayer_width='+width+';\r\n'
						+'s1.ckplayer_height='+height+';\r\n'
						+'s1.ckplayer_bgcolor="#000000";\r\n'
						+'s1.ckplayer_allowFullScreen=true;\r\n'
						+'s1.swfwrite("a1");\r\n'
						+'</script>\r\n';
						}
						//alert(video_code);
						self.insertHtml(html).hideDialog().focus();
					}
				}
			}),
			div = dialog.div,
			urlBox = K('[name="url"]', div),
			viewServerBtn = K('[name="viewServer"]', div),
			widthBox = K('[name="width"]', div),
			heightBox = K('[name="height"]', div);
			video_codeBox = K('[name="video_code"]', div);
			//urlBox.val('http://');

			if (allowFlashUpload) {
				var uploadbutton = K.uploadbutton({
					button : K('.ke-upload-button', div)[0],
					fieldName : 'imgFile',
					url : K.addParam(uploadJson, 'dir=flash'),
					afterUpload : function(data) {
						dialog.hideLoading();
						if (data.error === 0) {
							var url = data.url;
							if (formatUploadUrl) {
								url = K.formatUrl(url, 'absolute');
							}
							urlBox.val(url);
							if (self.afterUpload) {
								self.afterUpload.call(self, url);
							}
							alert(self.lang('uploadSuccess'));
						} else {
							alert(data.message);
						}
					},
					afterError : function(html) {
						dialog.hideLoading();
						self.errorDialog(html);
					}
				});
				uploadbutton.fileBox.change(function(e) {
					dialog.showLoading(self.lang('uploadLoading'));
					uploadbutton.submit();
				});
			} else {
				K('.ke-upload-button', div).hide();
			}

			if (allowFileManager) {
				viewServerBtn.click(function(e) {
					self.loadPlugin('filemanager', function() {
						self.plugin.filemanagerDialog({
							viewType : 'LIST',
							dirName : 'flash',
							clickFn : function(url, title) {
								if (self.dialogs.length > 1) {
									K('[name="url"]', div).val(url);
									self.hideDialog();
								}
							}
						});
					});
				});
			} else {
				viewServerBtn.hide();
			}

			
		},
		'delete' : function() {
			self.plugin.getSelectedFlv().remove();
		}
	};
	self.clickToolbar(name, self.plugin.flv.edit);
});
