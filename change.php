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
	$moto = $_POST["moto"];
	echo "<script> var moto =" . $moto . ";</script>";
	
	class Card {
		public $Name;
		public $Image;
		public $MaxHp;
		public $Hp;
		public $At;	
	}
	
	$card_num = array();
	$my_card = array();
	
	$dbh = new PDO('mysql:host=localhost;dbname=sleeper','root','2I9MLjwx');
	$dbh->query('SET NAMES utf8');//非奨順だが日本語化
	$sql = "select * from user_table";
	$st = $dbh->query($sql);
	
 	while($result = $st->fetch(PDO::FETCH_ASSOC)){//カードナンバー取得
		if($result['NAME'] == $userID){
			$leng = $result['MAISU'];
			for($i=1; $i<=$leng; $i++){
				$card_num[] = $result['card'.$i];
			}
		}
	}
		
	for($i=0; $i<count($card_num); $i++){//カード情報取得
	$sql = "select * from chara_table";
	$st = $dbh->query($sql);
		while($result = $st->fetch(PDO::FETCH_ASSOC)){
			if($card_num[$i] == $result['ID']){
				$c = new Card();
				$c->Name = $result['NAME'];
				$c->Image = "img/chara" . $card_num[$i] . ".jpg";
				$c->MaxHp = $result["HP"];
				$c->Hp = $result["HP"];
				$c->At = $result["AT"];
				$my_card[] = $c;
			}
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
var saki = 0;

$(function(){
	var maisu = chara.length;
	$("#moto_img").css("background-image","url(" + chara[moto].image + ")");
	$("#moto_hp").text("HP : " + chara[moto].hp);
	$("#moto_at").text("AT : "+ chara[moto].at);
	ready(maisu);
	change();
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

});

function ready(length){
	for(var i=0; i<length; i++){
		var target = $("#chara"+i);
		target.css("width","105px");
		target.css("height","105px");
		target.css("background-size","cover");
		target.css("background-image","url(" + chara[i].image + ")");
		if(i<5){
			target.css("opacity",0.7);
		}
		makeEve(length);
	}
}

function makeEve(length){
	for(var i =5; i<length; i++){
		$("#chara"+i).mouseover(function(){
			$(this).css("opacity",0.8);
		});
		$("#chara"+i).mouseout(function(){
			$(this).css("opacity",1);	
		});
				
		$("#chara"+i).bind("click",{x:i},function(e){
			$("#saki_img").css("background-image","url("+ chara[e.data.x].image + ")");
			$("#saki_hp").text("HP : "+ chara[e.data.x].hp);
			$("#saki_at").text("AT : "+ chara[e.data.x].at);
			saki = e.data.x;
		})
	}
}

function change(){
	$("#change_btn").click(function(){
		$("#moto").val(moto);
		$("#saki").val(saki);
		$("form").submit();
	});
	
}



</script>


<body>
<div id="main">
	<div id="pack4">
    	<div id="space"></div>
        <div id="left_image"></div>
        
        <div id="right_wrap4">
        	<div id="change_box">
            	<div id="me_box">
                	   <div id="moto_img"></div>
                    <div id="moto_hp">HP: 200</div>
                    <div id="moto_at">AT: 300</div>
                </div>
                <div id="yajirusi">→</div>
                <div id="me_box">
                	<div id="saki_img"></div>
                    <div id="saki_hp"></div>
                    <div id="saki_at"></div>
                </div>
            </div>
            
            <div id="change_btn"></div>
            
            <div id="card_wrap">
            	
                <div id="cards">
                	<div id="chara"><div id="chara0"></div></div>
                    <div id="chara"><div id="chara1"></div></div>
                    <div id="chara"><div id="chara2"></div></div>
                    <div id="chara"><div id="chara3"></div></div>
                    <div id="chara"><div id="chara4"></div></div>
                </div>
            	
                 <div id="cards">
                 	<div id="chara"><div id="chara5"></div></div>
                    <div id="chara"><div id="chara6"></div></div>
                    <div id="chara"><div id="chara7"></div></div>
                    <div id="chara"><div id="chara8"></div></div>
                    <div id="chara"><div id="chara9"></div></div>         
                </div>
                
                 <div id="cards">
                 	<div id="chara"><div id="chara10"></div></div>
                    <div id="chara"><div id="chara11"></div></div>
                    <div id="chara"><div id="chara12"></div></div>
                    <div id="chara"><div id="chara13"></div></div>
                    <div id="chara"><div id="chara14"></div></div>
                </div>
                
                 <div id="cards">
                 	<div id="chara"><div id="chara15"></div></div>
                    <div id="chara"><div id="chara16"></div></div>
                    <div id="chara"><div id="chara17"></div></div>
                    <div id="chara"><div id="chara18"></div></div>
                    <div id="chara"><div id="chara19"></div></div>
                </div>
                
                 <div id="cards">
                 	<div id="chara"><div id="chara20"></div></div>
                    <div id="chara"><div id="chara21"></div></div>
                    <div id="chara"><div id="chara22"></div></div>
                    <div id="chara"><div id="chara23"></div></div>
                    <div id="chara"><div id="chara24"></div></div>
                </div>
                
                 <div id="cards">
					<div id="chara"><div id="chara25"></div></div>
                    <div id="chara"><div id="chara26"></div></div>
                    <div id="chara"><div id="chara27"></div></div>
                    <div id="chara"><div id="chara28"></div></div>
                    <div id="chara"><div id="chara29"></div></div>
                </div>
           
            </div>
            
            <div id="back_btn">← back</div>
        
        </div>
    </div>
</div>

<form action="change_jikko.php" method="post">
	<input type="hidden" name="moto" value="0" id="moto">
	<input type="hidden" name="saki" value="0" id="saki">
    <input type="hidden" name="battle_or" value="2">
</form>

</body>
</html>
