<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Sleeper</title>
<link rel="stylesheet" type="text/css" href="menus.css">
<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
</head>

<?php
	$id = $_COOKIE['sleepID'];
	$eve = 0;
	try {
		$dbh = new PDO('mysql:host=localhost;dbname=sleeper','root','2I9MLjwx');
		$dbh->query('SET NAMES utf8');//非奨順だが日本語化
		$sql = "select * from user_table";
		$st = $dbh->query($sql);
 		while($result = $st->fetch(PDO::FETCH_ASSOC)){//同じIDがあるか調べる
			if($result['NAME'] == $id){
				$eve = $result['EVENT'];
			}
		}
	} catch(PDOException $e) {
		var_dump($e->getMessage());
		exit;
	}
	echo "<script> var eve =" . $eve .";</script>";
?>

<body>
<div id="main">
	<div id="pack2">
    	<div id="space"></div>
        <div id="left_image"></div>
        
        <div id="right_wrap2">
        	<div class="story_box"><div id="story0"><img src="img/chapter0.jpg" onmouseover="this.src='img/chapter0_on.jpg'" onmouseout="this.src='img/chapter0.jpg'"></div></div>
            <div class="story_box"><div  id="story1"><img src="img/chapter1.jpg" onmouseover="this.src='img/chapter1_on.jpg'" onmouseout="this.src='img/chapter1.jpg'"></div></div>
            <div id="clear"></div>
            <div class="story_box"><div id="story2"><img src="img/chapter2.jpg" onmouseover="this.src='img/chapter2_on.jpg'" onmouseout="this.src='img/chapter2.jpg'"></div></div>
            <div class="story_box"><div id="story3"><img src="img/chapter3.jpg" onmouseover="this.src='img/chapter3_on.jpg'" onmouseout="this.src='img/chapter3.jpg'"></div></div>
        	<div id="clear"></div>
            <div id="back_btn">← back</div>
        </div>
    </div>
</div>

<form action="story.php" method="post">
	<input type="hidden" name="first" value="0">
    <input type="hidden" name="battle_or" value="2">
    <input type="hidden" name="story_num" value="0" id="story_num">
    <input type="hidden" name="chat_num" value="0" id="chat_num">
</form>

</body>

<script>
if(eve>=0){
		$("#story0").fadeIn("slow");
}
if(eve>=1){
		$("#story1").fadeIn("slow");
}
if(eve>=2){
		$("#story2").fadeIn("slow");
}
if(eve>=3){
		$("#story3").fadeIn("slow");
}

$("#story0").click(function(){
	$("form #story_num").val(0);
	$("form #chat_num").val(0);
	$("form").submit();
});
$("#story1").click(function(){
	$("form #story_num").val(1);
	$("form #chat_num").val(2);
	$("form").submit();
});
$("#story2").click(function(){
	$("form #story_num").val(2);
	$("form #chat_num").val(4);
	$("form").submit();
});
$("#story3").click(function(){
	$("form #story_num").val(3);
	$("form #chat_num").val(6);
	$("form").submit();
});

$("#back_btn").mouseover(function(){
		$(this).css("color","#E9E9E9");		
	});
	$("#back_btn").mouseout(function(){
		$("this").css("color","#B1B1B1");
	});
	$("#back_btn").click(function(){
		$("form").attr("action","menu.php");
		$("form").submit();
	});
</script>

</html>
