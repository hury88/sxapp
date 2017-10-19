// 头部二级绑定
$("ul#erjiDom li a").click(function(){
    init(this.href);
})
$("ul#erjiMDom li a").click(function(){
    init(this.href);
})

$("#replaceTpl").on("click", ".index-casetab ul li a", function(){
    var href = this.href;
    pushState(href);
    init(href);
})

window.onpopstate = function(){
    if (history.state != null && history.state.url != null) {
        init(history.state.url)
    };
    // history.state.hasOwnProperty("url")
}
// 初始化数据
init(top.location);

function init(u)
{
    pattern = /#\/(.*)/
    r = pattern.exec(u)
    if (r) {
        r = r[1]
        getData(r)
        /*r = r[1]
        pattern = /(.*)\/(.*)/;
        r = pattern.exec(r)
        if (r) {
            key = r[1];
            value = r[2];
            getData(key,value)
        };*/
    }
}

function getData(u)
{
    u = "/mod/case?" + u;
    $.get(u,function(text){
        $('#replaceTpl').html(text);
    })
}/*
function getData(k,v)
{
    $(".index-casetab ul li").removeClass('active');
    $('.index-casetab ul li.category'+v).addClass('active')
    getUrl = "/mod/case?" + k + "=" + v;
    $.get(getUrl,function(text){
        $('#replaceTpl').html(text);
    })
}*/

function pushState(url)
{
    var title = '';
    var state = {
        title : title,
        url : url,
    }
    history.pushState(state, title, url)
}
