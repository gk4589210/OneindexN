<?php view::layout('layout')?>
<?php 
function file_ico($item){
  $ext = strtolower(pathinfo($item['name'], PATHINFO_EXTENSION));
  if(in_array($ext,['bmp','jpg','jpeg','png','gif'])){
  	return "image";
  }
  if(in_array($ext,['mp4','mkv','webm','avi','mpg', 'mpeg', 'rm', 'rmvb', 'mov', 'wmv', 'mkv', 'asf'])){
  	return "ondemand_video";
  }
  if(in_array($ext,['ogg','mp3','wav'])){
  	return "audiotrack";
  }
  return "insert_drive_file";
}
?>

<?php view::begin('content');?>

<?php if(is_login()):?>
<div class="mdui-container-fluid" >
	<div class="nexmoe-item">
	<button class="mdui-btn mdui-ripple" id="newfolder">新建文件夹</button>
	<button class="mdui-btn mdui-ripple" id="upload111">上传文件</button>
	<button class="mdui-btn mdui-ripple" id="example-confirm-1">Aria2</button>
	<button class="mdui-btn mdui-ripple multiopt" id="deleteall" style="display: none;">删除</button>
	<button class="mdui-btn mdui-ripple multiopt" id="shareall" style="display: none;">分享</button>
	<button class="mdui-btn mdui-ripple singleopt" id="rename" style="display: none;">重命名</button>
	</div>
</div>
<?endif;?> 


<div class="mdui-container-fluid">
<?php if($head):?>
<div class="mdui-typo" style="padding: 20px;">
	<?php e($head);?>
</div>
<?php endif;?>
<style>
.thumb .th{
	display: none;
}
.thumb .mdui-text-right{
	display: none;
}
.thumb .mdui-list-item a ,.thumb .mdui-list-item {
	width:217px;
	height: 230px;
	float: left;
	margin: 10px 10px !important;
}

.thumb .mdui-col-xs-12,.thumb .mdui-col-sm-7{
	width:100% !important;
	height:230px;
}

.thumb .mdui-list-item .mdui-icon{
	font-size:100px;
	display: block;
	margin-top: 40px;
	color: #7ab5ef;
}
.thumb .mdui-list-item span{
	float: left;
	display: block;
	text-align: center;
	width:100%;
	position: absolute;
    top: 180px;
}
</style>
<div class="nexmoe-item">
<div class="mdui-row">
	<ul class="mdui-list">
		<li class="mdui-list-item th">
		<?php if(is_login()):?>
			<label class="mdui-checkbox"><input type="checkbox" value="" id="checkall" onclick="checkall()"><i
					class="mdui-checkbox-icon"></i></label>
			<?endif;?> 
		  <div class="mdui-col-xs-12 mdui-col-sm-7">文件 <i class="mdui-icon material-icons icon-sort" data-sort="name" data-order="downward">expand_more</i></div>
		  <div class="mdui-col-sm-3 mdui-text-right">修改时间 <i class="mdui-icon material-icons icon-sort" data-sort="date" data-order="downward">expand_more</i></div>
		  <div class="mdui-col-sm-2 mdui-text-right">大小 <i class="mdui-icon material-icons icon-sort" data-sort="size" data-order="downward">expand_more</i></div>
		</li>
		<?php if($path != '/'):?>
		<li class="mdui-list-item mdui-ripple">
			<a href="<?php echo get_absolute_path($root.$path.'../');?>">
			  <div class="mdui-col-xs-12 mdui-col-sm-7">
				<i class="mdui-icon material-icons">arrow_upward</i>
		    	..
			  </div>
			  <div class="mdui-col-sm-3 mdui-text-right"></div>
			  <div class="mdui-col-sm-2 mdui-text-right"></div>
		  	</a>
		</li>
		<?php endif;?>
		
		<?php foreach((array)$items as $item):?>
			<?php if(!empty($item['folder'])):?>

		<li class="mdui-list-item mdui-ripple" data-sort 
					data-sort-name="<?php echo $item['name'] ;?>"
                    data-sort-date="<?php echo $item['lastModifiedDateTime'];?>"
					data-sort-size="<?php echo $item['size'];?>" 
					id="<?php echo $item["id"] ?>">
			<?php if(is_login()):?>
			<label class="mdui-checkbox">
				<input type="checkbox" value="<?php echo $item["id"] ?>" name="itemid" onclick="onClickHander()">
				<i class="mdui-checkbox-icon"></i></label>
			<?endif;?> 		
			<a href="<?php echo get_absolute_path($root.$path.rawurlencode($item['name']));?>">
			  <div class="mdui-col-xs-12 mdui-col-sm-7 mdui-text-truncate">
				<i class="mdui-icon material-icons">folder_open</i>
		    	<span><?php echo $item['name'];?></span>
			  </div>
			  <div class="mdui-col-sm-3 mdui-text-right"><?php echo date("Y-m-d H:i:s", $item['lastModifiedDateTime']);?></div>
			  <div class="mdui-col-sm-2 mdui-text-right"><?php echo onedrive::human_filesize($item['size']);?></div>
		  	</a>
		</li>
			<?php else:?>
		<li class="mdui-list-item file mdui-ripple" data-sort
                    data-sort-name="<?php echo $item['name'];?>"
                    data-sort-date="<?php echo $item['lastModifiedDateTime'];?>"
					data-sort-size="<?php echo $item['size'];?>" 
					id="<?php echo $item["id"] ?>">
					<?php if(is_login()):?>
			<label class="mdui-checkbox">
				<input type="checkbox" value="<?php echo $item["id"] ?>" name="itemid" onclick="onClickHander()">
				<i class="mdui-checkbox-icon"></i></label>
			<?endif;?> 	
			<a href="<?php echo get_absolute_path($root.$path).rawurlencode($item['name']);?>" target="_blank">
			  <div class="mdui-col-xs-12 mdui-col-sm-7 mdui-text-truncate">
				<i class="mdui-icon material-icons"><?php echo file_ico($item);?></i>
		    	<span><?php e($item['name']);?></span>
			  </div>
			  <div class="mdui-col-sm-3 mdui-text-right"><?php echo date("Y-m-d H:i:s", $item['lastModifiedDateTime']);?></div>
			  <div class="mdui-col-sm-2 mdui-text-right"><?php echo onedrive::human_filesize($item['size']);?></div>
		  	</a>
		</li>
			<?php endif;?>
		<?php endforeach;?>
	</ul>
</div>
</div>
<?php if($readme):?>
<div class="mdui-typo mdui-shadow-3" style="padding: 20px;margin: 20px; ">
	<div class="mdui-chip">
	  <span class="mdui-chip-icon"><i class="mdui-icon material-icons">face</i></span>
	  <span class="mdui-chip-title">README.md</span>
	</div>
	<?php e($readme);?>
</div>
<?php endif;?>
</div>
<script>
$ = mdui.JQ;
$.fn.extend({
    sortElements: function (comparator, getSortable) {
        getSortable = getSortable || function () { return this; };

        var placements = this.map(function () {
            var sortElement = getSortable.call(this),
                parentNode = sortElement.parentNode,
                nextSibling = parentNode.insertBefore(
                    document.createTextNode(''),
                    sortElement.nextSibling
                );

            return function () {
                parentNode.insertBefore(this, nextSibling);
                parentNode.removeChild(nextSibling);
            };
        });

        return [].sort.call(this, comparator).each(function (i) {
            placements[i].call(getSortable.call(this));
        });
    }
});

function downall() {
     let dl_link_list = Array.from(document.querySelectorAll("li a"))
         .map(x => x.href) // 所有list中的链接
         .filter(x => x.slice(-1) != "/"); // 筛选出非文件夹的文件下载链接

     let blob = new Blob([dl_link_list.join("\r\n")], {
         type: 'text/plain'
     }); // 构造Blog对象
     let a = document.createElement('a'); // 伪造一个a对象
     a.href = window.URL.createObjectURL(blob); // 构造href属性为Blob对象生成的链接
     a.download = "folder_download_link.txt"; // 文件名称，你可以根据你的需要构造
     a.click() // 模拟点击
     a.remove();
}

function thumb(){
	if($('#format_list').text() == "apps"){
		$('#format_list').text("format_list_bulleted");
		$('.nexmoe-item').removeClass('thumb');
		$('.nexmoe-item .mdui-icon').show();
		$('.nexmoe-item .mdui-list-item').css("background","");
	}else{
		$('#format_list').text("apps");
		$('.nexmoe-item').addClass('thumb');
		$('.mdui-col-xs-12 i.mdui-icon').each(function(){
			if($(this).text() == "image" || $(this).text() == "ondemand_video"){
				var href = $(this).parent().parent().attr('href');
				var thumb =(href.indexOf('?') == -1)?'?t=220':'&t=220';
				$(this).hide();
				$(this).parent().parent().parent().css("background","url("+href+thumb+")  no-repeat center top");
			}
		});
	}

}	



$(function(){
	$('.file a').each(function(){
		$(this).on('click', function () {
			var form = $('<form target=_blank method=post></form>').attr('action', $(this).attr('href')).get(0);
			$(document.body).append(form);
			form.submit();
			$(form).remove();
			return false;
		});
	});

	$('.icon-sort').on('click', function () {
        let sort_type = $(this).attr("data-sort"), sort_order = $(this).attr("data-order");
        let sort_order_to = (sort_order === "less") ? "more" : "less";
        $('li[data-sort]').sortElements(function (a, b) {
            let data_a = $(a).attr("data-sort-" + sort_type), data_b = $(b).attr("data-sort-" + sort_type);
            let rt = data_a.localeCompare(data_b, undefined, {numeric: true});
            return (sort_order === "more") ? 0-rt : rt;
        });
        $(this).attr("data-order", sort_order_to).text("expand_" + sort_order_to);
    });
});
</script>

<div class="mdui-fab-wrapper" id="myFab">
    <button class="mdui-fab mdui-ripple mdui-color-theme-accent">
      <i class="mdui-icon material-icons">add</i>
      <i class="mdui-icon mdui-fab-opened material-icons">mode_edit</i>
    </button>
    <div class="mdui-fab-dial">
	  
      <button class="mdui-fab mdui-fab-mini mdui-ripple mdui-color-pink" onclick="location.href='/?/offline'" style="display: <?php if(!$manager['offline']) echo "none" ;else echo "inline" ?>;"><i class="mdui-icon material-icons">cloud_upload</i>
      </button>
      <button class="mdui-fab mdui-fab-mini mdui-ripple mdui-color-red" id="file_upload" style="display: <?php if(!$manager['online']) echo "none" ;else echo "inline" ?>;"><i class="mdui-icon material-icons">file_upload</i>
      </button>
      <button class="mdui-fab mdui-fab-mini mdui-ripple mdui-color-orange" onclick="location.href='/?/admin'"><i class="mdui-icon material-icons">account_circle</i>
      </button>
      <button class="mdui-fab mdui-fab-mini mdui-ripple mdui-color-blue" onclick="thumb()"><i class="mdui-icon material-icons" id="format_list">format_list_bulleted</i>
      </button>
    </div>
  </div>

  <div class="mdui-container">

  <div class="mdui-dialog" id="fileupload-dialog">
    <div class="mdui-dialog-title">文件上传</div>
    <div class="mdui-dialog-content">
		<form action="?/onlinefileupload" method="post" enctype="multipart/form-data" style="display: <?php if(!$manager['online']) echo "none" ;else echo "inline" ?>;">
			<input class="mdui-center" type="file" style="margin: 50px 0;" name="onlinefile" />
			<input type="text" style="display: none;" name="uploadurl" value="<?php echo $_SERVER['REQUEST_URI']; ?>"/>
			<div class="mdui-row-xs-3">
			<div class="mdui-col"></div>
				<div class="mdui-col">
					<button class="mdui-btn mdui-btn-block mdui-color-theme-accent mdui-ripple">上传</button>
				</div>
			</div>
		</form>
		<h4 style="display: <?php if($manager['online']) echo "none" ;else echo "inline" ?>;">管理员未允许游客上传</h4>
	</div>
    <div class="mdui-dialog-actions">
      <button class="mdui-btn mdui-ripple" mdui-dialog-cancel>取消</button>
    </div>
  </div>
</div>


<script>
    var inst1 = new mdui.Fab('#myFab');


	var inst2 = new mdui.Dialog('#fileupload-dialog');
	// method
	document.getElementById('file_upload').addEventListener('click', function () {
	inst2.open();
	});
	//新建文件夹
	mdui.JQ('#newfolder').on('click', function () {
		mdui.prompt('输入文件夹名称',
			function (value) {
				var httpRequest = new XMLHttpRequest();//第一步：创建需要的对象
				httpRequest.open('POST', '?/create_folder', true); //第二步：打开连接
				httpRequest.setRequestHeader("Content-type","application/x-www-form-urlencoded");//设置请求头 注：post方式必须设置请求头（在建立连接后设置请求头）
				var query='foldername='+value+'&uploadurl=<?php echo $_SERVER['REQUEST_URI']; ?>';
				httpRequest.send(query);//发送请求 将情头体写在send中
				mdui.alert('创建成功2秒后\n自动刷新列表！');
				setInterval(function(){location.reload();},3000);
				/**
				* 获取数据后的处理程序
				*/
				httpRequest.onreadystatechange = function () {//请求后的回调接口，可将请求成功后要执行的程序写在其中
					if (httpRequest.readyState == 4 && httpRequest.status == 200) {//验证请求是否发送成功
						
					}
				};
			},
			function (value) {
			}
		);
	});
	//重命名
	mdui.JQ('#rename').on('click', function () {
		mdui.prompt('输入新名称',
			function (value) {
				var httpRequest = new XMLHttpRequest();//第一步：创建需要的对象
				httpRequest.open('POST', '?/rename', true); //第二步：打开连接
				httpRequest.setRequestHeader("Content-type","application/x-www-form-urlencoded");//设置请求头 注：post方式必须设置请求头（在建立连接后设置请求头）
				var query='name='+value+'&itemid='+check_val[0];
				httpRequest.send(query);//发送请求 将情头体写在send中
				mdui.alert('重命名成功2秒后\n自动刷新列表！');
				setInterval(function(){location.reload();},3000);
				/**
				* 获取数据后的处理程序
				*/
				httpRequest.onreadystatechange = function () {//请求后的回调接口，可将请求成功后要执行的程序写在其中
					if (httpRequest.readyState == 4 && httpRequest.status == 200) {//验证请求是否发送成功
						
					}
				};
			},
			function (value) {
			}
		);
	});
	//删除文件/文件夹
	mdui.JQ('#deleteall').on('click', function(){
		mdui.confirm('请确认是否删除选中项目',
			function(){
				var httpRequest = new XMLHttpRequest();
				httpRequest.open('POST', '?/deleteitems', true); 
				httpRequest.setRequestHeader("Content-type","application/json");//设置请求头 注：post方式必须设置请求头（在建立连接后设置请求头）
				var query=JSON.stringify(check_val);
				httpRequest.send(query);
				mdui.alert('删除成功2秒后\n自动刷新列表！');
				setInterval(function(){location.reload();},3000);
				
				/**
				* 获取数据后的处理程序
				*/
				httpRequest.onreadystatechange = function () {//请求后的回调接口，可将请求成功后要执行的程序写在其中
					if (httpRequest.readyState == 4 && httpRequest.status == 200) {//验证请求是否发送成功
						
					}
				};
			},
			function(){
			}
		);
		});

	function onClickHander(){
		checkitems = document.getElementsByName("itemid");
		check_val = [];
		for (k in checkitems) {
			if (checkitems[k].checked) check_val.push(checkitems[k].value);
		}
		//alert(check_val);
		console.log(check_val);
		var singleopt = document.getElementsByClassName("singleopt");
		var multiopt = document.getElementsByClassName("multiopt");
		//单文件操作
		if(check_val.length==1){
			for(var i=0;i<singleopt.length;i++){
				singleopt[i].style.display = "inline";
			}
		}
		else{
			for(var i=0;i<singleopt.length;i++){
				singleopt[i].style.display = "none";
			}
		}
		//多文件操作
		if(check_val.length>=1){
			for(var i=0;i<multiopt.length;i++){
				multiopt[i].style.display = "inline";
			}
		}else{
			for(var i=0;i<multiopt.length;i++){
				multiopt[i].style.display = "none";
			}
		}
		// if (check_val != "") {
		// 	var div = document.getElementById("mangger");
		// 	var div2= document.getElementById("navess");
		// 	div2.style.display = "none";
		// 	div.style.display = "block";
		// } else {
		// 	var div = document.getElementById("mangger");
		// 	var div2= document.getElementById("navess");
		// 	div.style.display = "none";
		// 	div2.style.display = "block";
		// }
	}
	function checkall(){
		var checkall = document.getElementById("checkall");
		var itemsbox = document.getElementsByName("itemid");
		if (checkall.checked == false) {
			for (var i = 0; i < itemsbox.length; i++) {
			itemsbox[i].checked = false;
			}
		} else {
			for (var i = 0; i < itemsbox.length; i++) {
			itemsbox[i].checked = true;
			}
		}
		onClickHander();
	}
	

</script>
<?php view::end('content');?>
