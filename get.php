<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Sleeper</title>
<link rel="stylesheet" type="text/css" href="get.css">
<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="jQueryRotate.js"></script>
</head>
<?php
		$userID = $_COOKIE["sleepID"];
		$star=0;
		$maisu=0;
		$dbh = new PDO('mysql:host=localhost;dbname=sleeper','root','2I9MLjwx');
		$dbh->query('SET NAMES utf8');//非奨順だが日本語化
		$sql = "select * from user_table";
		$st = $dbh->query($sql);
 		while($result = $st->fetch(PDO::FETCH_ASSOC)){//同じIDがあるか調べる
			if($result['NAME'] == $userID){
				$maisu = $result["MAISU"];
				$maisu += 1;
				$star = $result['STAR'];
				$star -= 1;
			}
	 	}
		
	$get = rand(1,13);
	$box = $dbh->prepare("update user_table set card".$maisu." =:m where NAME = :user");//--------------
	$box->execute(array(":m"=>$get, ":user"=>$userID));

	$box = $dbh->prepare("update user_table set STAR =:s where NAME = :user");//--------------
	$box->execute(array(":s"=>$star, ":user"=>$userID));
	
	$box = $dbh->prepare("update user_table set MAISU =:mai where NAME = :user");//--------------
	$box->execute(array(":mai"=>$maisu, ":user"=>$userID));

	class Card {
		public $Name;
		public $Image;
		public $MaxHp;
		public $Hp;
		public $At;	
	}

	$my_card = array();
	$sql = "select * from chara_table";
	$st = $dbh->query($sql);
	while($result = $st->fetch(PDO::FETCH_ASSOC)){//同じIDがあるか調べる
		if($result['ID'] == $get){
			$c = new Card();
			$c->Name = $result['NAME'];
			$c->Image = "img/chara" . $get . ".jpg";
			$c->MaxHp = $result["HP"];
			$c->Hp = $result["HP"];
			$c->At = $result["AT"];
			$my_card[] = $c;
		}
 	}
		echoCard($my_card);
	 
	function echoCard($_mycard){
		$length = count($_mycard);
		echo "<script>";	
		echo "var chara =[];";
		for($i=0; $i<$length; $i++){
			echo "var chara" . $i . "={ name:'" . $_mycard[$i]->Name . "',image:'" . $_mycard[$i]->Image . "',maxhp:" . $_mycard[$i]->MaxHp . ",hp:" . $_mycard[$i]->Hp . ", at:" . $_mycard[$i]->At . "};";
			echo "chara.push(chara". $i .");";
		}
		echo "</script>";
	}

?>

<script>
	//chara[0];
	var angle =0;
	var roll;

	$(function(){
							//$("#under_image").fadeIn("slow");

		$("#card_img").css("background-image","url("+chara[0].image+")");
		$("#name").text(chara[0].name);
		$("#hp").text(chara[0].hp);
		$("#at").text(chara[0].at);
		$("#back_btn").mouseover(function(){
			$(this).css("color","#E9E9E9");		
		});
		$("#back_btn").mouseout(function(){
			$("this").css("color","#B1B1B1");
		});
		$("#back_btn").click(function(){
			$("form").submit();
		});
		
		$("#over_image").fadeIn("slow");
			roll();
	});
	
	function roll(){
		roll = setInterval(function(){
			angle +=0.5;
			var o = $("#over_image").css("opacity") - 0.004;
			$("#over_image").css("opacity",o);
			$("#over_image").rotate(angle);
			
			if(angle==300){
				clearInterval(roll);
					$("#under_image").fadeIn("slow");
			}
		},1);
	}
</script>

<body>
<div id="main">
	<div id="pack">
    	<div id="space"></div>
        <div id="over_image"></div>
        <div id="under_image">
        	<div id="card_wrap">
            	<div id="card_img"></div>
                <div id="card_info"><div id="name">彼方を見る者　アルフ</div></div>
                <div id="card_info"><div id="hp">HP: 200</div></div>
            	<div id="card_info"><div id="at">AT: 300</div></div>
            </div>
            
            <div id="back_btn">←back</div>
                 
        </div>
            
    </div>
</div>
<form action="menu.php" method="post">
	<input type="hidden" name="battle_or" value="2">
</form>
</body>
</html>
