<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Sleeper</title>
<link rel="stylesheet" type="text/css" href="menus.css">
<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
</head>

<?php
	class Card {
		public $Name;
		public $Image;
		public $MaxHp;
		public $Hp;
		public $At;	
	}
	
	$card_num = array();
	$my_card = array();
	$c = new Card();
	$userID = $_COOKIE["sleepID"];
	$dbh = new PDO('mysql:host=localhost;dbname=sleeper','root','2I9MLjwx');
	$dbh->query('SET NAMES utf8');//非奨順だが日本語化
	$sql = "select * from user_table";
	$st = $dbh->query($sql);
	
 	while($result = $st->fetch(PDO::FETCH_ASSOC)){//カードナンバー取得
		if($result['NAME'] == $userID){
			$card_num[] = $result['card1'];
			$card_num[] = $result['card2'];
			$card_num[] = $result['card3'];
			$card_num[] = $result['card4'];
			$card_num[] = $result['card5'];
		}
	}
	
	for($i=0; $i<5; $i++){
		$sql = "select * from chara_table";
		$st = $dbh->query($sql);
		while($result = $st->fetch(PDO::FETCH_ASSOC)){//カード情報取得
			if($result['ID'] == $card_num[$i]){
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

<body>
<div id="main">
	<div id="pack3">
    	<div id="space"></div>
        <div id="left_image"></div>
        
        <div id="right_wrap3">
        	<div id="member_wrap">
            
            	<div class="member" id="member0">
                	<div id="chara_image0"></div>
                    <div id="chara_name"><div id="chara_name0">時の魔術師<br>メリア</div></div>
                	<div id="chara_index"><div id="chara_hp0">ＨＰ：２６０</div></div>
                    <div id="chara_index"><div id="chara_at0">ＡＴ：１００</div></div>
                </div>
                
            	<div class="member" id="member1">
                	<div id="chara_image1"></div>
                    <div id="chara_name"><div id="chara_name1">時の魔術師<br>メリア</div></div>
                	<div id="chara_index"><div id="chara_hp1">ＨＰ：２６０</div></div>
                    <div id="chara_index"><div id="chara_at1">ＡＴ：１００</div></div>
                </div>
                
                <div class="member" id="member2">
                	<div id="chara_image2"></div>
                    <div id="chara_name"><div id="chara_name2">時の魔術師<br>メリア</div></div>
                	<div id="chara_index"><div id="chara_hp2">ＨＰ：２６０</div></div>
                    <div id="chara_index"><div id="chara_at2">ＡＴ：１００</div></div>
                </div>
                
                <div class="member"  id="member3">
                	<div id="chara_image3"></div>
                    <div id="chara_name"><div id="chara_name3">時の魔術師<br>メリア</div></div>
                	<div id="chara_index"><div id="chara_hp3">ＨＰ：２６０</div></div>
                    <div id="chara_index"><div id="chara_at3">ＡＴ：１００</div></div>
                </div>
                
                <div class="member" id="member4">
                	<div id="chara_image4"></div>
                   <div id="chara_name"><div id="chara_name4">時の魔術師<br>メリア</div></div>
                	<div id="chara_index"><div id="chara_hp4">ＨＰ：２６０</div></div>
                    <div id="chara_index"><div id="chara_at4">ＡＴ：１００</div></div>
                </div>
                
                <div id="back_btn">← back</div>
            </div>
        </div>
    </div>
</div>

<form action="change.php" method="post">
	<input type="hidden" name="battle_or" value="3" id="battle_or">
    <input type="hidden" name="moto" value="0" id="moto">
</form>

</body>

<script>
	makeChara(chara);
	
	$("#member0").click(function(){
		clickBt(0);	
	});
	$("#member1").click(function(){
		clickBt(1);	
	});
	$("#member2").click(function(){
		clickBt(2);	
	});
	$("#member3").click(function(){
		clickBt(3);	
	});
	$("#member4").click(function(){
		clickBt(4);	
	});
	
	function clickBt(num){
		$("form #moto").val(num);
		$("form").submit();	
	}
	
	$(".member").mouseover(function(){
		$(this).css("background-image","url(img/chara_waku_on.jpg)");	
	});
	$(".member").mouseout(function(){
		$(this).css("background-image","url(img/chara_waku.jpg)");	
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

	function makeChara(_chara){//キャラ表示
		for(var i=0; i<5; i++){
			$(".member #chara_image"+i).css("background-image","url(" + _chara[i].image + ")");
			$(".member #chara_name"+i).text(_chara[i].name);
			$(".member #chara_hp"+i).text("HP : " + _chara[i].maxhp);
			$(".member #chara_at"+i).text("AT : " + _chara[i].at);
		}
	}

</script>

</html>
