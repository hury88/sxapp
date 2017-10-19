(function(o){
if(!o || o.MHeader){ return; }

//header class
var MHeader = {
	ids: {'headerbox': 'mheader_box'},
	dropmenuGroup: null,
	node: null,
	jsres: typeof(mheaderjs) == 'object' ? mheaderjs : null,
	ready: false,
	status: 'fixed',
	rule: 'fixed',
	init: function(){
		this.headerbox = document.getElementById(this.ids.headerbox);
		this.headercss = document.getElementById('headercss');
		var csslink = document.createElement('link');
		if(csslink){
			csslink.type = 'text/css';
			csslink.rel = 'stylesheet';
			csslink.href = this.headercss.href;
			document.getElementsByTagName('head')[0].appendChild(csslink);
		}
		this.bind();
		//优先执行的功能不依赖资源加载
		this.Nav.init();
		//依赖打印代码中的资源声明打印
		if(!this.jsres){ return; }
		var _this = this, canrun = false, runed = false;;
		
		//运行时检测依赖脚本, 如加载立即运行
		var timer = setInterval(function(){
			if(_this.chkres('relyon')){ 
				canrun = true; 
				clearInterval(timer); 
				if(!runed){ _this.bindfns(); runed = true; }
			}
		}, 10);
		//domready后检测依赖脚本, 添加未包含的脚本, 并加载附加功能
		domReady(function(){
			clearInterval(timer); timer = null;
			canrun = canrun || _this.chkres('relyon');
			var addons = function(){
				_this.chkres('addons');
				_this.loadres('addons');	
			}
			if(!canrun){
				_this.loadres('relyon', function(){
					var relyon = _this.jsres.relyon;
					for(var i=0; i<relyon.length; i++){
						if(relyon[i].ready !== true){ return; }
					}
					if(!runed){ _this.bindfns(); runed = true; }
					addons();
				});
			}else{
				if(!runed){ _this.bindfns(); runed = true; }
				addons();	
			}
			
		});
	},
	bind: function(){
		var _this = this;
		domReady(function(){
			var timer = setInterval(function(){
				if(_this.ready){
					var t = null;
					var selector = 'textarea,input[txtfor!=headersearch],select';
					$(document)
					.on('focus', selector, function(){
						t = $(this);	
						_this.unfix();
					})
					.on('blur', selector, function(){
						var n = $(this);//失焦获焦UI处理延时
						setTimeout(function(){
							//不是通过另一域获焦而失焦
							if(n.get(0) == t.get(0)){ _this.dofix(); }
						}, 50)
					});
					clearInterval(timer);	
				}	
			}, 25);	
		});
	},
	bindfns: function(){
		this.ready = true;
		this.dropmenuGroup = new DropmenuGroup();
	},
	dofix: function(){
		return this.changeRule('fixed');
	},
	unfix: function(){
		return this.changeRule('static');
	},
	changeRule: function(rule){
		if(rule != this.rule){
			this.rule = rule;
			this.changePos('setrule');
		}
		return this;	
	},
	changePos: function(type){//@param type 按规则设置'setrule'，滚动中频发 'scroll'		
		var ready = typeof($) == 'function' ? true : false;//jquery ready
		var headerbox = ready ? $(this.headerbox) : this.headerbox;
		
		if(this.rule == 'fixed' && this.status != 'fixed'){
			if(ready){ headerbox.css({'position': 'fixed'}); }
			else{ headerbox.style.position = 'fixed'; }
			this.status = 'fixed';
		}else if(this.rule == 'static' && this.status != 'static'){
			if(ready){ headerbox.css({'position': 'relative'});}
			else{ headerbox.style.position = 'relative';	}
			this.status = 'static';		
		}

		return this;
	},
	loadres: function(key, callback){
		var res = this.jsres[key];
		var _this = this;
		var callback = typeof(callback) == 'function' ? callback : function(){};
		for(var i=0; i<res.length; i++){
			(function(i){
				if(res[i].ready === false){
					_this.jsres[key][i].ready = 'loading';
					addScript(_this.jsres[key][i].src, function(){
						_this.jsres[key][i].ready = true;
						callback();
					});	
				}
			})(i);
		}
	},
	chkres: function(key){//同步加载状态下 检测依赖的JS资源
		var res = this.jsres[key];
		if(!res){ return true; }
		var _this = this;
		var scripts = document.getElementsByTagName('script');
		for(var i=0; i<scripts.length; i++){
			var script = scripts[i];
			for(var j=0; j<res.length; j++){
				if(script.src && script.src == res[j].src){

					(function(script, key, j){
						if(!_this.jsres[key][j].ready && eval(_this.jsres[key][j].condition)){
							_this.jsres[key][j].ready = true;	
						}
					})(script, key, j);
				}
			}	 	
		}
		for(var i=0; i<this.jsres[key].length; i++){
			if(this.jsres[key][i].ready !== true){
				return false;
			}
		}
		return true;
	}
}

MHeader.Nav = {
	scroller: null,
	init: function(){
		var nav = document.getElementById('mheader_nav');
		if(!nav){ return; }
		this.bind();	
	},
	bind: function(){
		var _this = this;
		
		this.initScroller();
		var box = document.getElementById('mheader_navbox')
		var cur = this.findCurrent();
		var inview = true;
		if(cur){
			var posbox = getElementPos(box).x
				,poscur = getElementPos(cur).x
				,wbox = box.offsetWidth;
			
			if( poscur >= (posbox + wbox)  //整个溢出
				|| (poscur+cur.offsetWidth) > (posbox + wbox) //半截不可见
			){
				inview = false;	
			}
		}
		if(!inview){
			//居中
			var x = cur.offsetLeft + cur.offsetWidth/2 - box.offsetWidth/2;
			this.scroller.scrollTo(-x, 0, 0);
		}
		
		var en = 'onorientationchange' in window ? 'orientationchange' : 'resize';
		addEvent(window, en, function(){
			if(_this.scroller){
				var getWidth = function(){
					var w = 0;
					for(var i=0; i<lis.length; i++){
						w += (lis[i].offsetWidth + parseInt(getStyle(lis[i], 'marginRight')));
					}
					return w+100;
				}
				var ul = document.getElementById('mheader_navbox').getElementsByTagName('ul')[0]
					,lis = ul.getElementsByTagName('li');
				ul.style.width = getWidth() + 'px';
				_this.scroller.refresh();		
			}	
		});
		
	},
	initScroller: function(){
		var box = document.getElementById('mheader_navbox')
			,mr = 48
			,ul = box.getElementsByTagName('ul')[0]
			,lis = ul.getElementsByTagName('li');
		
		//margin-right 定义不同
		var getWidth = function(){
			var w = 0;
			for(var i=0; i<lis.length; i++){
				w += (lis[i].offsetWidth + parseInt(getStyle(lis[i], 'marginRight')));
			}
			return w+10;
		}
		
		ul.style.width = getWidth() + 'px';
		
		this.scroller = new iScroll('mheader_navbox', {
			bounce:true,
			vScroll:false,
			hScrollbar:false,
			vScrollbar:false
		});
		
	},
	findCurrent: function(){
		var box = document.getElementById('mheader_navbox')
			,ul = box.getElementsByTagName('ul')[0]
			,lis = ul.getElementsByTagName('li');
		var li = null;
		for(var i=0; i<lis.length; i++){
			var l = lis[i];
			if(l.className && l.className == 'current'){
				li = l;
				break;
			}
		}
		return li;	
	}
}

var DropmenuGroup = function(){
	this.coll = [];	
	this.bind();
}
DropmenuGroup.prototype = {
	bind: function(){
		var _this = this;
		var y0 = 0, y1 = 0;
		$(document).bind(isTouch ? 'touchstart' : 'click', function(e){ 
			_this.hideAll();	
		});
	},
	getLength: function(){
		return this.coll.length;
	},
	isExist: function(dropmenu){
		var len = this.getLength();
		for(var i=0; i<len; i++){
			if(this.coll[i] == dropmenu){
				return true;
			}
		}
		return false;	
	},
	add: function(dropmenu){
		if(dropmenu instanceof Dropmenu && !this.isExist(dropmenu)){
			this.coll.push(dropmenu);
		}
		return this;
	},
	remove: function(dropmenu){
		var len = this.getLength();
		for(var i=0; i<len; i++){
			if(this.coll[i] == dropmenu){
				this.coll.splice(i, 1);
				break;	
			}
		}
		return true;
	},
	hideAll: function(){
		var len = this.getLength();
		for(var i=0; i<len; i++){
			this.coll[i].hide();
		}
		return this;
	},
	hideOther: function(dropmenu){
		var len = this.getLength();
		for(var i=0; i<len; i++){
			if(this.coll[i] != dropmenu){
				this.coll[i].hide();	
			}
		}
		return this;
	}
}

//private method
var domReady = function(callback){
	var timer = null;
	var isready = false;
	var callback = typeof(callback) == 'function' ? callback : function(){};
	if(document.addEventListener){
		document.addEventListener("DOMContentLoaded", function(){ 
			if(!isready){ isready = true; callback(); }
		}, false);
	}else if(document.attachEvent){
		document.attachEvent("onreadystatechange", function(){
			if((/loaded|complete/).test(document.readyState)){
				if(!isready){ isready = true; callback(); }
			}
		});
		if(window == window.top){
			timer = setInterval(function(){
				if(isready){ clearInterval(timer); timer=null; return; }
				try{
					document.documentElement.doScroll('left');	
				}catch(e){
					return;
				}
				if(!isready){ isready = true; callback(); }
			},5);
		}
	}
}

var addScript = function(src, callback, isremove){
	if(typeof(arguments[0]) != 'string'){ return; }
	var callback = typeof(arguments[1]) == 'function' ? callback : function(){};
	var isremove = typeof(arguments[2]) == 'boolean' ? isremove : false;
	var head = document.getElementsByTagName('HEAD')[0];
	var script = document.createElement('SCRIPT');
	script.type = 'text/javascript'; 
	script.src = src;
	head.appendChild(script);
	if(!/*@cc_on!@*/0) {
		script.onerror = script.onload = function(){ 
			callback();
			if(isremove){ script.parentNode.removeChild(this); } 
		}
	}else{
		script.onreadystatechange = function () {
			if (this.readyState == 'loaded' || this.readyState == 'complete') { 
				callback();
				if(isremove){ this.parentNode.removeChild(this); } 
			}
		}
	}
}

var addEvent = function(dom, eventname, func){
	if(window.addEventListener){
		if(eventname == 'mouseenter' || eventname == 'mouseleave'){
			function fn(e){
				var a = e.currentTarget, b = e.relatedTarget;
				if(!elContains(a, b) && a!=b){
					func.call(e.currentTarget,e);
				}	
			}
			function elContains(a, b){
				try{ return a.contains ? a != b && a.contains(b) : !!(a.compareDocumentPosition(b) & 16); }catch(e){}
			}
			if(eventname == 'mouseenter'){
				dom.addEventListener('mouseover', fn, false);
			}else{
				dom.addEventListener('mouseout', fn, false);
			}
		}else{
			dom.addEventListener(eventname, func, false);
		}
	}else if(window.attachEvent){
		dom.attachEvent('on' + eventname, func);
	}
}

var cancelBubble = function(evt){
	var evt = window.event || evt;
	if(evt.stopPropagation){      
		evt.stopPropagation();    
	}else{    
		evt.cancelBubble=true;   
	}
	return false;
}

var preventDefault = function(evt){
	var evt = window.event || evt;
	if(evt.preventDefault){
		evt.preventDefault();
	}else{
		event.returnValue = false;
	}
	return false;
}

var getElementPos = function(o){
	var point = {x:0, y:0};
	if (o.getBoundingClientRect) {
		var x=0, y=0;
		try{
			var box = o.getBoundingClientRect();
			var D = document.documentElement;
			x = box.left + Math.max(D.scrollLeft, document.body.scrollLeft) - D.clientLeft;
			y = box.top + Math.max(D.scrollTop, document.body.scrollTop) - D.clientTop;
		}catch(e){}
		point.x = x;
		point.y = y;
	}else{
		function pageX(o){ try {return o.offsetParent ? o.offsetLeft +  pageX(o.offsetParent) : o.offsetLeft; } catch(e){ return 0; } }
		function pageY(o){ try {return o.offsetParent ? o.offsetTop + pageY(o.offsetParent) : o.offsetTop; } catch(e){ return 0; } }
		point.x = pageX(o);
		point.y = pageY(o);
	}
	return point;
}

var getMousePos = function(e){
	var point = {x:0, y:0};
	if(typeof window.pageYOffset != 'undefined') {
		point.x = window.pageXOffset;
		point.y = window.pageYOffset;
	}else if(typeof document.compatMode != 'undefined' && document.compatMode != 'BackCompat') {
		point.x = document.documentElement.scrollLeft;
		point.y = document.documentElement.scrollTop;
	}else if(typeof document.body != 'undefined') {
		point.x = document.body.scrollLeft;
		point.y = document.body.scrollTop;
	}
	point.x += e.clientX;
	point.y += e.clientY;
	
	return point;
}

var getStyle = function(obj, attribute){     
	return obj.currentStyle ? obj.currentStyle[attribute] : document.defaultView.getComputedStyle(obj, false)[attribute];
}


//init
o.MHeader = MHeader;
MHeader.init();

})(window);
