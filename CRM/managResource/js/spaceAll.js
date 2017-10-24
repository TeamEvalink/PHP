/**
 * Created by 大刀王五 on 2015/9/15.
 */
    //遮挡层
var pvbNow;
var introNow;
var openFlag = true;
$(document).ready(function () {
//    引入下拉模拟
    $(".cin_optionCommonSg").delegate("li","mouseenter", function () {
        $(this).addClass("cin_liHover");
    });
    $(".cin_optionCommonSg").delegate("li","mouseleave", function () {
        $(this).removeClass("cin_liHover");
    });
    $(".cin_optionCommonSg").delegate("li","click",function () {
        $(this).parent().find("li").removeClass("cin_liCheck");
        $(this).addClass("cin_liCheck");
        $(this).parent().prev().css("border","1px solid #e3e3e3");
        $(this).parent().prev().html($(this).text());
        $(this).parent().hide();
    });
    //关闭下拉
    window.onload = function(){
        document.onclick = function(e){
            $(".cin_optionCommonSg").hide();
            $(".cin_inputBox").css("border","1px solid #e3e3e3");
        }
        $(".cin_inputBox").click(function (e) {
            e = e||event; stopFunc(e);
        });
        $(".cin_optionCommonSg").click(function (e) {
            e = e||event; stopFunc(e);
        });
        liuxiaofan();
    }
    function stopFunc(e){
        e.stopPropagation?e.stopPropagation():e.cancelBubble = true;
    }
    $(".cin_inputBox").click(function () {
        var flag = $(this).next().css("display");
        if(flag == "none"){
            $(".cin_optionCommonSg").hide();
            $(".cin_optionCommon").hide();
            $(".cin_optionCommonSg_1").hide();
            $(".cin_inputBox").css("border","1px solid #e3e3e3");
            $(".cin_inputBox_1").css("border","1px solid #e3e3e3");
            $(this).css("border","1px solid #00a0e8");
            $(this).next().show();
        }else{
            $(this).css("border","1px solid #e3e3e3");
            $(this).next().hide();
        }
    });
//    本页js
    $(".pvb_close").mouseenter(function () {
        $(".pvb_close").attr("src","images/Space_coverCloseHover.png");
    });
    $(".pvb_close").mouseleave(function () {
        $(".pvb_close").attr("src","images/Space_coverClose.png");
    });
    $(".pvb_close").click(function () {
        $(".coverIndex").hide();
        $("body").css({overflowY:"auto"});
    });
    $("#lxf-box").find("li").click(function () {
        //$("body").css({overflowY:"hidden"});
        $(".coverIndex").show();
        $(".pvb_name").text($(this).find(".span1").text());
        pvbNow = $(this).find(".span1").text();
        $(".pvb_time").text($(this).find(".span3").text());
        $(".portfolioViewBox_top_right").text($(this).find(".span2").text());
        introNow = $(this).find(".span2").text();
        $(".imgViewBox").attr("src",$(this).find("img").attr("src"));
    });
    $(".pvb_leftArrow").click(function () {
        var nameNow =  $(".pvb_name").text();
        $("#lxf-box").find("li").each(function (i) {
            if($(this).find(".span1").text() == nameNow){
                if(i>=1) {
                    $(".pvb_name").text($(this).prev().find(".span1").text());
                    pvbNow = $(this).prev().find(".span1").text()
                    $(".pvb_time").text($(this).prev().find(".span3").text());
                    $(".portfolioViewBox_top_right").text($(this).prev().find(".span2").text());
                    introNow = $(this).prev().find(".span2").text();
                    $(".imgViewBox").attr("src", $(this).prev().find("img").attr("src"));
                }
            }
        });
    });
    $(".pvb_rightArrow").click(function () {
        var nameNow =  $(".pvb_name").text();
        $("#lxf-box").find("li").each(function (i) {
            if($(this).find(".span1").text() == nameNow){
                if(i<$("#lxf-box").find("li").length-1){
                    $(".pvb_name").text($(this).next().find(".span1").text());
                    pvbNow = $(this).next().find(".span1").text();
                    $(".pvb_time").text($(this).next().find(".span3").text());
                    $(".portfolioViewBox_top_right").text($(this).next().find(".span2").text());
                    introNow = $(this).next().find(".span2").text();
                    $(".imgViewBox").attr("src",$(this).next().find("img").attr("src"));
                }
            }
        });
    });
//    编辑作品名称
    $(".pvbNameChange").mouseenter(function () {
        $(this).addClass("pvb_nameHover")
    });
    $(".pvbNameChange").mouseleave(function () {
        $(this).removeClass("pvb_nameHover")
    });
    $(".pvbNameChange").click(function () {
        $(this).hide();
        $(this).next().val($(this).text())
        $(this).next().show();
        $(this).next().next().show();
        $(this).next().next().next().show();
        document.getElementById("labelStick_1").focus();
    });
//    取消修改
    $(".pvbNameChangeExit").click(function () {
        $(this).hide();
        $(this).prev().hide();
        $(this).prev().prev().hide();
        $(this).prev().prev().prev().show();
    });
//    确定修改
    $(".pvbNameChangeSure").click(function () {
        $(this).hide();
        $(this).next().hide();
        $(this).prev().prev().text($(this).prev().val());
        var pvbNameChange = $(this).prev().val();
        $(this).prev().prev().show();
        $(this).prev().hide();
        $("#lxf-box").find(".span1").each(function (i) {
            if($(this).text() == pvbNow){
                $(this).text(pvbNameChange);
            }
        });
    });
    //编辑描述
    $(".pvbtr_hover").mouseenter(function () {
        $(this).addClass("pvbtr_hover_1")
    });
    $(".pvbtr_hover").mouseleave(function () {
        $(this).removeClass("pvbtr_hover_1")
    });
    $(".pvbtr_hover").click(function () {
        $(this).hide();
        $(this).next().val($(this).html())
        $(this).next().show();
        $(this).next().next().show();
        document.getElementById("labelStick").focus();
    });
    //    取消修改
    $(".pvbNameChangeExit_1").click(function () {
        $(this).parent().hide();
        $(this).parent().prev().prev().show();
        $(this).parent().prev().hide();
    });
//    确定修改
    $(".pvbNameChangeSure_1").click(function () {
        $(this).parent().hide();
        $(this).parent().prev().prev().show();
        $(this).parent().prev().hide();
        $(this).parent().prev().prev().html($(this).parent().prev().val());
        var pvbIntroChange = $(this).parent().prev().val();
        $("#lxf-box").find(".span2").each(function (i) {
            if($(this).text() == introNow){
                $(this).text(pvbIntroChange);
            }
        });
    });

//      作品添加
    //对HR可见
    var nameUnique = false;
    $(".portfolioObv").find("img").click(function(){
        if(openFlag){
            $(this).attr("src","images/Space_close.png");
            openFlag = false;
        }else{
            $(this).attr("src","images/Space_open.png");
            openFlag = true;
        }
    });
    //新建作品集
    $(".newPortfolio").click(function () {
        $(this).parent().next().show();
        document.getElementById("newPortfolioName").focus();
        document.getElementById("newPortfolioName_1").focus();
    });
    //新建作品集确定
    $(".newPic").find(".cutButton").click(function () {
        $(".cin_optionCommonSg").eq(0).find("li").each(function () {
            if($(this).text()==$("#newPortfolioName").val()){
                nameUnique = true;
            }
        });
        if(nameUnique){
            $(this).parent().parent().parent().next().show();
            $(this).parent().parent().parent().next().find(".addPicMention").find("div").eq(0).text("作品集已存在，请重新命名");
            $(this).parent().parent().parent().next().find(".addPicMention").css("marginTop","140px");
            nameUnique = false;
        }else{
            var newPortfolio = "<li>"+$("#newPortfolioName").val()+"</li>";
            $(".cin_optionCommonSg").prepend(newPortfolio);
            $(".cin_optionCommonSg").find("li").removeClass("cin_liCheck");
            $(".cin_inputBox").html($("#newPortfolioName").val());
            $("#newPortfolioName").val("新建作品集");
            $(".portfolioRoot").eq(0).attr("checked",true);
            $(this).parent().parent().parent().hide();
        }

    });
    //新建作品集取消
    $(".newPortfolioWindow").find(".cutButton_1").click(function () {
        $(".portfolioRoot").eq(0).attr("checked",true);
        $("#newPortfolioName").val("新建作品集");
        $(this).parent().parent().parent().hide();
    });
    $(".addPicMention").find("button").click(function () {
        $(this).parent().parent().parent().hide();
    });
    //视频类作品集
    //新建作品集确定
    $(".newVideo").find(".cutButton").click(function () {
        $(".cin_optionCommonSg").eq(1).find("li").each(function () {
            if($(this).text()==$("#newPortfolioName_1").val()){
                nameUnique = true;
            }
        });
        if(nameUnique){
            $(this).parent().parent().parent().next().show();
            $(this).parent().parent().parent().next().find(".addPicMention").find("div").eq(0).text("作品集已存在，请重新命名");
            $(this).parent().parent().parent().next().find(".addPicMention").css("marginTop","140px");
            nameUnique = false;
        }else{
            var newPortfolio = "<li>"+$("#newPortfolioName_1").val()+"</li>";
            $(".cin_optionCommonSg").prepend(newPortfolio);
            $(".cin_optionCommonSg").find("li").removeClass("cin_liCheck");
            $(".cin_inputBox").html($("#newPortfolioName_1").val());
            $("#newPortfolioName_1").val("新建作品集");
            $(".portfolioRoot_1").eq(0).attr("checked",true);
            $(this).parent().parent().parent().hide();
        }

    });
    //新建作品集取消
    $(".newPortfolioWindow").find(".cutButton_1").click(function () {
        $(".portfolioRoot").eq(0).attr("checked",true);
        $("#newPortfolioName_1").val("新建作品集");
        $(this).parent().parent().parent().hide();
    });
    $(".addPicMention").find("button").click(function () {
        $(this).parent().parent().parent().hide();
    });
    //取消新建作品上传
    $(".avbb_2").click(function(){
        $(".videoAddress").find("input").val("贴入视频地址。支持优酷、土豆、乐视、bilibili等网站");
        $(".videoIntro").find("input").val("");
        $(".addVideoCover").hide();
    });
    //确认上传
    $(".avbb_1").click(function(){
        //Ajax操作
        $(".videoAddress").find("input").val("贴入视频地址。支持优酷、土豆、乐视、bilibili等网站");
        $(".videoIntro").find("input").val("");
        $(".addVideoCover").hide();
    });
    //图片重新上传选择出现
//    var picRemoveFlag = true;
//    $("#picPreview").mouseenter(function () {
//        if(picRemoveFlag){
//            $(".picReUpload").fadeIn("fast");
//        }
//    });
//    $(".picReUpload").mouseleave(function () {
//        if(picRemoveFlag){
//            $(this).fadeOut("fast");
//        }
//    });
//    $(".picReUpload").find("ul").click(function () {
//        $(".picReUpload").hide();
//        $(".addPicVideo").find("textarea").val("");
//    $("#picPreview").attr("src","images/Space_AddPicBG.jpg");
//        picRemoveFlag = false;
//    });
    //新建作品弹出
    $(".addPic").click(function () {
        $(".addPortfolioDeal").show();
    });
    //上传视频弹出
    $(".addVideo").click(function () {
        $(".addVideoCover").show();
    });
    //取消新建作品上传
    $(".apbb_2").click(function(){
        $("#picPreview").attr("src","images/Space_AddPicBG.jpg");
        $(".addPicVideo").find("textarea").val("");
        $(".addPortfolioDeal").hide();
    });
    //确认上传
    $(".apbb_1").click(function(){
        //Ajax操作
        $("#picPreview").attr("src","images/Space_AddPicBG.jpg");
        $(".addPicVideo").find("textarea").val("");
        $(".addPortfolioDeal").hide();
    });
});
//图片返回后提示操作
//容量不足
//$(".addPicMention").find("div").eq(0).text("对不起，您的个人空间容量已饱和。请尝试压缩图片或删除部分作品以释放空间。");
//$(".addPicCover").show();
//$(".addPicMention").css("marginTop","100px");
//图片尺寸超标
//$(".addPicMention").find("div").eq(0).text("对不起，请上传大小不超过5M的图片。");
//$(".addPicMention").css("marginTop","110px");
//$(".addPicCover").show();

//添加图片
var addPicFlag = true;
function picUpload() {
    if(addPicFlag){
        document.getElementById("picUpload").click();
    }
}
//上传图片
function picRecall() {
    console.log(document.getElementById("picUpload").value);
}