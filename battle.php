<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Sleeper</title>
<link rel="stylesheet" type="text/css" href="battle.css">
<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
</head>

<?php
	$battle_id = $_POST["battle_id"];
	echo "<script>var battle_id=" . $battle_id . ";</script>";
	$sleepID = $_COOKIE["sleepID"];
	$story_num;
	$dbh;
	$my_card_num = array();
	$my_card = array();
	$enemy = array();
	ready($my_card_num, $sleepID);
	cardSet($my_card, $my_card_num);
	enemySet($enemy);
	echoCard($my_card);
	echoEnemy($enemy);
?>

<body>
<div id="main">
	<div id="pack">
    	<div id="space"></div>
        <div id="skip"></div>
        <div id="clear"></div>
        
        <div id="enemy_box">
        	<div id="enemy_name">崩aa兵士</div>
            <div id="enemy_img"></div>
            <div id="enemy_hp1"></div>
            <div id="enemy_hp2"></div>
        </div>
        
        <div id="me_pack">
        	<div id="chara_pack" class="card0">
            	<div id="chara_image" ></div>
                <div id="chara_hp"></div>
                <div id="chara_hp2"></div>
            </div>
            <div id="chara_pack" class="card1">
            	<div id="chara_image"></div>
                <div id="chara_hp"></div>
                <div id="chara_hp2"></div>
            </div>
            <div id="chara_pack" class="card2">
            	<div id="chara_image"></div>
                <div id="chara_hp"></div>
                <div id="chara_hp2"></div>
            </div>
            <div id="chara_pack" class="card3">
            	<div id="chara_image"></div>
                <div id="chara_hp"></div>
                <div id="chara_hp2"></div>
            </div>
            <div id="chara_pack" class="card4">
            	<div id="chara_image"></div>
                <div id="chara_hp"></div>
                <div id="chara_hp2"></div>
            </div>
        
        </div>
    </div>
</div>
<form action="menu.php" method="post">
	<input type="hidden" name="battle_or" value="1" id="battle_or">
    <input type="hidden" name="first" value="0">
    <input type="hidden" name="story_num" value="0" id="story_num">
    <input type="hidden" name="chat_num" value="0" id="chat_num">
</form>

<?php
	class Card {
		public $Name;
		public $Image;
		public $MaxHp;
		public $Hp;
		public $At;	
	}
	
	class Enemy {
		public $Name;
		public $Image;
		public $MaxHp;
		public $Hp;
		public $At;
		public $Kaisu;	
	}
	
	function ready(&$card_num, $sleepID){//サーバから自分のカード情報を得る
		global $battle_id;
		global $story_num;
		try {
			$dbh = new PDO('mysql:host=localhost;dbname=sleeper','root','2I9MLjwx');
			$dbh->query('SET NAMES utf8');//非奨順だが日本語化
			$sql = "select * from user_table";
			$st = $dbh->query($sql);
 			while($result = $st->fetch(PDO::FETCH_ASSOC)){//同じIDがあるか調べる
				if($result['NAME'] == $sleepID){
					//$story_num = $result['EVENT'];
					if($battle_id<=2){
						$story_num = 0;	
					}else if($battle_id<=4){
						$story_num = 1;	
					}else if($battle_id<=6){
						$story_num = 2;	
					}else{
						$story_num=3;	
					}
					echo "<script>var story_num =" . $story_num . ";</script>";
					$card_num[] = $result['card1'];
					$card_num[] = $result['card2'];
					$card_num[] = $result['card3'];
					$card_num[] = $result['card4'];
					$card_num[] = $result['card5'];
				}
	 		}
		} catch(PDOException $e) {
			var_dump($e->getMessage());
			exit;
		}	
	}


	function cardSet(&$_mycard, $card_num){//自分のカード情報セット
		$dbh = new PDO('mysql:host=localhost;dbname=sleeper','root','2I9MLjwx');
		$dbh->query('SET NAMES utf8');//非奨順だが日本語化
		$sql = "select * from chara_table";
		$st = $dbh->query($sql);
 		while($result = $st->fetch(PDO::FETCH_ASSOC)){//同じIDがあるか調べる
			for($i=0; $i<5; $i++){
				if($result['ID'] == $card_num[$i]){
					$c = new Card();
					$c->Name = $result['NAME'];
					$c->Image = "img/chara" . $card_num[$i] . ".jpg";
					$c->MaxHp = $result["HP"];
					$c->Hp = $result["HP"];
					$c->At = $result["AT"];
					$_mycard[] = $c;
				}
			}
	 	}
	}


	function enemySet(&$_enemy){//敵情報セット
		$dbh = new PDO('mysql:host=localhost;dbname=sleeper','root','2I9MLjwx');
		$dbh->query('SET NAMES utf8');//非奨順だが日本語化
		$e_num = array();
		$battle_id = $_POST["battle_id"];
		$sql = "select * from battle_table";
		$st = $dbh->query($sql);
 		while($result = $st->fetch(PDO::FETCH_ASSOC)){//同じIDがあるか調べる
			if($result['ID'] == $battle_id){
				for($i=1; $i<=$result["BT_NUMBER"]; $i++){
					$e_num[] = $result['BT_'.$i];	
				}
			}
	 	}		
		$sql = "select * from enemy_table";
		$st = $dbh->query($sql);
 
		while($result = $st->fetch(PDO::FETCH_ASSOC)){
			for($i=0; $i<count($e_num); $i++){
				if($result['ID'] == $e_num[$i]){
					$e = new Enemy();
					$e->Name = $result["NAME"];
					$e->Image = "img/enemy" . $e_num[$i] . ".jpg";
					$e->MaxHp = $result["HP"];
					$e->Hp = $result["HP"];
					$e->At = $result["AT"];
					$e->Kaisu = $result["AT_NUM"];
					$_enemy[] = $e;
				}
			}
		}

	}
	
	
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
	
	function echoEnemy($_enemy){
			$length = count($_enemy);
		echo "<script>";	
		echo "var enemy =[];";
		for($i=0; $i<$length; $i++){
			echo "var enemy" . $i . "={ name:'" . $_enemy[$i]->Name . "',image:'" . $_enemy[$i]->Image . "',maxhp:" . $_enemy[$i]->MaxHp . ",hp:" . $_enemy[$i]->Hp . ", at:" . $_enemy[$i]->At . ",kaisu:". $_enemy[$i]->Kaisu. "};";
			echo "enemy.push(enemy". $i .");";
		}
		echo "</script>";
	}
	
?>

</body>
</html>

<script>//---------------------消す--------------------
/*var chara =[];
var chara0={ name:'魔剣士　リア',image:'img/chara1.jpg',maxhp:150,hp:150, at:150};
chara.push(chara0);
var chara1={ name:'治癒師　アリア',image:'img/chara2.jpg',maxhp:200,hp:200, at:100};
chara.push(chara1);
var chara2={ name:'獣戦士　シャール',image:'img/chara3.jpg',maxhp:100,hp:100, at:200};
chara.push(chara2);
var chara3={ name:'刺だらけのバラ　ミラ',image:'img/chara4.jpg',maxhp:125,hp:125, at:175};
chara.push(chara3)
;var chara4={ name:'黒の剣士　ジュリア',image:'img/chara5.jpg',maxhp:1,hp:1, at:300};
chara.push(chara4);


var enemy =[];
var enemy0={ name:'笑う猫',image:'img/enemy1.jpg',maxhp:1000,hp:1000, at:50,kaisu:1};
enemy.push(enemy0);
var enemy1={ name:'死んだ目の魚',image:'img/enemy2.jpg',maxhp:1000,hp:1000, at:70,kaisu:1};
enemy.push(enemy1);*/
</script>

<script>//-------バトル-----
	//準備部分----
	var e_count = 0;
	var time = 1000;
	changeEnemy(enemy,e_count);
	makeChara(chara);
	
	$("#skip").click(function(){
				if(time >= 200){
					time -= 100; 
				}
	})
	
	battle(chara,  enemy);
	
	
	
	function check(_chara, _Enemy_now, _enemy){
		var length = _enemy.length;
		var liveCount = 0;
		if(_Enemy_now.hp <= 0){
			e_count += 1;
			if(e_count >= length){
				//ゲームクリアーーー
				clear(battle_id);
			}else{
				changeEnemy(enemy,e_count);	
			}
		}
		
		for (var i=0; i<5; i++){//ゲームオーバーチェック
			if($(".card" + i + " #chara_image").css("background-image") == "url(http://160.16.60.117/img/deth.jpg)"){
				liveCount += 1;
			}
		}
		if(liveCount == 5){
			//ゲームオーバー	
			alert("Gameover");
			$("form").attr("action","menu.php");
			$("#battle_or").val(3);
			$("form").submit();	
		}
	}
	
	
	function battle(_chara, _enemy){
		var kaisu = 0;
		setInterval(function(){
			if(kaisu == 0){ 
			//自分のターン
				atack(_enemy[e_count],_chara);
				kaisu = _enemy[e_count].kaisu;
			}else{
			//敵のターン
				damege(_enemy[e_count], _chara);
				kaisu -= 1;
			}
			//setTimeout(function(){
				check(_chara, _enemy[e_count], _enemy);
			//},300);
		},time);
	}

	
	function meGage(_chara, num){//自分のゲージ管理
		var i = num;
		var mh = _chara[i].maxhp;
			var h = _chara[i].hp;
			if( h>=0){
				var l = 180 * h / (mh/100) / 100;
				l = Math.ceil(l);
				$(".card" + i + " #chara_hp2").css("width", l+"px");
			}else{
				$(".card" + i + " #chara_hp2").css("width","0px");
				$(".card" + i + " #chara_image").css("background-image","url(img/deth.jpg)");
			}
	}
	
	
	function damege(_enemy, _chara){//ダメージを受けたとき
		var rnd = Math.floor( Math.random() * 5 );
		var at = _enemy.at;
		_chara[rnd].hp -= at;
		
		$("#enemy_img").animate({marginTop:"30px"},300,"",function(){
			$("#enemy_img").animate({marginTop:"0px"},300);
			meGage(_chara, rnd);
		});
		$(".card" + rnd + " #chara_image").animate({marginTop:"10px"},300,"",function(){
			$(".card" + rnd + " #chara_image").animate({marginTop:"0px"},300);
		}); 		
	}
	
	
	function enemyGage(_enemy){//敵のゲージ管理
			var mh = _enemy.maxhp;
			var h = _enemy.hp;
			if(h>=0){
				var l = 300 * h / (mh/100) / 100;
				l = Math.ceil(l);
				$("#enemy_hp2").css("width", l + "px");
			}else{
				$("#enemy_hp2").css("width","0px");	
			}
	}
	
	
	function atack(_enemy,_chara){
		for (var i=0; i<5; i++){
			_enemy.hp = _enemy.hp - at(_chara,i);
			enemyGage(_enemy);
		}
	}
	
	
	function at(_chara, num){
		if(_chara[num].hp>=0){
			var at = _chara[num].at;
			$(".card" + num + " #chara_image").animate({marginTop:"-30px"},300,"",function(){
				$(".card" + num + " #chara_image").animate({marginTop:"0px"},300);
			});
			$("#enemy_img").animate({marginTop:"-10px"},300,"",function(){
				$("#enemy_img").animate({marginTop:"0px"},300);
			});
			return at;
		}
		return 0;
	};


	function changeEnemy(_enemy, num ){//敵の表示
		var _enemy_now = enemy[num];
		$("#enemy_name").css("display","none");
		$("#enemy_name").text(_enemy_now.name);
		$("#enemy_img").css("display","none");
		$("#enemy_img").css("background-image","url(" + _enemy_now.image + ")");
		$("#enemy_hp1").css("display","none");
		$("#enemy_hp1").css("width","300px");
		$("#enemy_hp2").css("display","none");
		$("#enemy_hp2").css("width","300px");
		//setTimeout(function(){
			$("#enemy_hp1").fadeIn("slow");
			$("#enemy_hp2").fadeIn("slow");
			$("#enemy_img").fadeIn("slow");
			$("#enemy_name").fadeIn("slow");
		//},300);
	}
	
	function makeChara(_chara){//キャラ表示
		for(var i=0; i<5; i++){
			$(".card"+i+" #chara_image").css("background-image","url(" + _chara[i].image + ")");
			$(".card"+i+"  #chara_hp2").css("width","180px");
		}
	}
	
	function clear(_battle_id){
		if(_battle_id == 8){
			$("form").attr("action","story.php");
			$("#story_num").val(story_num+1);
			$("#chat_num").val(8);
			$("form").submit();
		}else if((_battle_id %2) == 0){
			alert("ステージクリア！");
			$("form").attr("action","menu.php");
			$("#story_num").val(story_num+1);
			$("#battle_or").val(1);
			$("form").submit();	
		}else{
			$("form").attr("action","story.php");
			$("#story_num").val(story_num);
			$("#chat_num").val(_battle_id);
			$("form").submit();	
		}
	}
	
	

</script>