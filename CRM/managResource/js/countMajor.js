
var flow=[];
var labels = [];
var data = [];
var chartParam = {
		render : 'seekerCountDiv',
		data: data,
		align:'center',
		title : {
			text:'用户职位专业搜索量统计',
			font : '微软雅黑',
			fontsize:24,
			color:'#b4b4b4'
		},
		subtitle : {
			text:'',
			font : '微软雅黑',
			color:'#b4b4b4'
		},

		width : 900,
		height : 400,
		shadow:true,
		shadow_color : '#202020',
		shadow_blur : 8,
		shadow_offsetx : 0,
		shadow_offsety : 0,
		background_color:'#2e2e2e',
		animation : true,//开启过渡动画
		animation_duration:600,//600ms完成动画
		tip:{
			enable:true,
			shadow:true,
			listeners:{
				 //tip:提示框对象、name:数据名称、value:数据值、text:当前文本、i:数据点的索引
				parseText:function(tip,name,value,text,i){
					return "<span style='color:#005268;font-size:12px;'>'"+labels[i]+"'  数据量为:<br/>"+
					"</span><span style='color:#005268;font-size:20px;'>"+value+"</span>";
				}
			}
		},
		crosshair:{
			enable:true,
			line_color:'#62bce9'
		},
		sub_option : {
			smooth : true,
			label:false,
			hollow:false,
			hollow_inside:false,
			point_size:8
		},
		coordinate:{
			width:760,
			height:280,
			striped_factor : 0.18,
			grid_color:'#4e4e4e',
			axis:{
				color:'#252525',
				width:[0,0,4,4]
			     },
		    scale:[{
				 position:'left',	
				 start_scale:0,
				 end_scale:100,
				 scale_space:10,
				 scale_size:2,
				 scale_enable : false,
				 label : {color:'#9d987a',font : '微软雅黑',fontsize:11,fontweight:600},
				 scale_color:'#9f9f9f'
			},{
				 position:'bottom',	
				 label : {color:'#9d987a',font : '微软雅黑',fontsize:11,fontweight:600},
				 scale_enable : false,
				 labels:labels
			}]
		}
	};

var chartCustom = new iChart.Custom({
	drawFn:function(){
	//计算位置
	var coo = seekerChart.getCoordinate(),
		x = coo.get('originx'),
		y = coo.get('originy'),
		w = coo.width,
		h = coo.height;
	//在左上侧的位置，渲染一个单位的文字
	seekerChart.target.textAlign('start')
	.textBaseline('bottom')
	.textFont('600 11px 微软雅黑')
	.fillText('注册量',x-40,y-12,false,'#9d987a')
	.textBaseline('top')
	.fillText('(时间)',x+w+12,y+h+10,false,'#9d987a');
	
}
});

var countParam = {
		         "sDate" : $("#countSDate").val() ,
		          "eDate":$("#countEDate").val() 
		          };

//获取统计数据 ， 画出统计图
function countSeeker(){
	$("#onloadingImg").css("display" ,"inline");
	$.post("/sysCount/countMajor",
			countParam , 
			function (data){
				if(data.error == "relogin"){
					alert("请重新登录！");
					return ;
				}
			   //将返回的数据解析成报表数据
		       var flow = [];   //数值数组
		       var labels = []; //x坐标标签数组
		       for(var i = 0 , len = data.length ; i < len ; i++){
		    	   var dataObj = data[i];
		    	   labels.push(dataObj.key_word);
		    	   flow.push(dataObj.count);

		       }

		       
//		       console.log(flow);
//		       console.log(labels);

		     var charData = [
			         	{
			         		name : 'SK',
			         		value:flow,
			         		color:'#0d8ecf',
			         		line_width:2
			         	}
			         ];
		     
			//设置图表参数
		     chartParam.data = charData;
			var chartScale = chartParam.coordinate.scale;
			var labelObj = chartScale[1];
			labelObj.labels = labels;
			chartParam.subtitle.text = countParam.sDate + "---" + countParam.eDate + "  前10位搜索专业";
			chartParam.tip.listeners.parseText = function(tip,name,value,text,i){
													var lab = labels[i];

													return "<span style='color:#005268;font-size:12px;'>'"+lab+"'  数据量为:<br/>"+
													"</span><span style='color:#005268;font-size:20px;'>"+value+"</span>";
												}
			
			//绘制图表
			seekerChart = new iChart.LineBasic2D(chartParam);
			seekerChart.plugin(chartCustom);
			seekerChart.draw();
			$("#onloadingImg").css("display" ,"none");
	        },
	        "json"
	      );
}

countSeeker();


//改变统计密度事件
function changeCountParam(){
	countParam.sDate= $("#countSDate").val() ;
	countParam.eDate=$("#countEDate").val();
	countSeeker();
}

