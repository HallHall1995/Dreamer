<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Sleeper</title>
<link rel="stylesheet" type="text/css" href="menus.css">
<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
</head>

<?php
		$userID = $_COOKIE["sleepID"];
		$star=0;
		$dbh = new PDO('mysql:host=localhost;dbname=sleeper','root','2I9MLjwx');
		$dbh->query('SET NAMES utf8');//非奨順だが日本語化
		$sql = "select * from user_table";
		$st = $dbh->query($sql);
 		while($result = $st->fetch(PDO::FETCH_ASSOC)){//同じIDがあるか調べる
			if($result['NAME'] == $userID){
				$star = $result['STAR'];
				echo "<script>var star =".$star . ";</script>";
			}
	 	}


?>

<body>
<div id="main">
	<div id="pack3">
    	<div id="space"></div>
        <div id="left_image"></div>
        
        <div id="right_wrap3">
        	<div id="info_wrap">
            	<div id="info_box">
                	<div id="setumei">
                    	星を消費すると<br>
                        <br>
                        新しい仲間を増やせるよ
                    </div>
                </div>
                <div id="usagi_box"></div>
                <div id="gacha_btn"></div>
                
                <div id="clear"></div>
                <div id="star_box2">★×<?php echo $star ?></div>
                <div id="back_btn2">←back</div>
            </div>
        
        </div>
    </div>
</div>
<form action="get.php" method="post">
	<input type="hidden" name="battle_or" value="2">
</form>
</body>

<script>
$("#gacha_btn").mouseover(function(){
	$(this).css("opacity",0.7);	
});
$("#gacha_btn").mouseout(function(){
	$(this).css("opacity",1);	
});
$("#gacha_btn").click(function(){
	if(star<=0){
		alert("星の数が足りないよ");
	}else{
		$("form").submit();	
	}
});


$("#back_btn2").mouseover(function(){
		$(this).css("color","#E9E9E9");		
	});
	$("#back_btn2").mouseout(function(){
		$("this").css("color","#B1B1B1");
	});
	$("#back_btn2").click(function(){
		$("form").attr("action","menu.php");
		$("form").submit();
	});

</script>
</html>
