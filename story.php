<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Sleeper</title>
<link rel="stylesheet" type="text/css" href="story.css">
<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="onother.js"></script>
</head>

<body>
	<?php
		$first = $_POST["first"];//1なら登録0ならそれ以外
		$event_num ;//チャプターナンバー（０〜３）
		$story_num = 0;//イベントナンバー…（０〜７）
		$ID;
		$passward;
		IDmake($first);
		echo_word($event_num);
	?>
    
	<div id="main">
	<div id="pack">
    	<div id="space"></div>
        <div id="image1"></div>
        <div id="image2"></div>
        <div id="clear"></div>
        <div id="serihi_box">
        	<div id="name_box">王様</div>
        		<div id="serihu">
            <p>王様はその時、遠くを見ながら声を発した。<br>
            ここは君の夢の中だ<br>
            君の世界なのに、君はここがどこか　わからないのかい？</p>          
            </div>
        </div>
    </div>
    </div>
    
    <form action="battle.php" method="post" name="battle">
    		<input type="hidden" name="battle_id" value="0">
         <input type="hidden" name="battle_or" value="2">
    </form>
    
    <?php
		function IDmake($f){//---登録--------------------
			$story_num = 0;//------------------
			global $event_num;
			if($f==1){
				$ID = $_POST["userID"];
				$passward = $_POST["passward"];
				try {
					$dbh = new PDO('mysql:host=localhost;dbname=sleeper','root','2I9MLjwx');
					$dbh->query('SET NAMES utf8');//非奨順だが日本語化
					$sql = "select * from user_table";
					$st = $dbh->query($sql);
					$check = 0;
 					while($result = $st->fetch(PDO::FETCH_ASSOC)){//同じIDがあるか調べる
						if($result['NAME'] == $ID){
							$check = 1;	
						}
	 				}
				} catch(PDOException $e) {
					var_dump($e->getMessage());
					exit;
				}
			
				if($check == 0){
					$box = $dbh->prepare("insert into user_table (NAME,PASSWARD) values (:name, :passward)");
					$box->bindParam(":name",$h_name);
					$box->bindParam(":passward", $h_passward);
					$h_name = $ID;
					$h_passward = $passward;
					$box->execute();
					$event_num = 0;
					setcookie('sleepID',$ID);
				}else{
					//ユーザーIDが重なった場合
					echo "<script> history.back(); </script>";
				}
			}else{//----------チャプターとチャットナンバー受け取り
				//$event_num = $_POST["story_num"];
				$event_num =$_POST["story_num"];
				$story_num = $_POST["chat_num"];
				
			}
					echo '<script> var c_num = ' . $story_num . ';</script>';
		}
		
		
		
		
		
	//---javascript吐き出し-----⬇-------		
		
	//---------イベント処理------//
function echo_word($eve){	
	echo "<script>";
	switch ($eve) {
		case 0:
			echo 'var serihu1 = ["……","色の無い世界  現実味の無い光景","私は自分がどこにいるのかわからなかった","ここはどこなのだろうか？","…！    あたりを見渡すと、そこに１匹のうさぎがいた","話しかけてみようか"];';
			echo 'var serihu2 = ["はじめまして    ぼくは臆病なウサギだよ","…？    ここがどこかって？","何を言っているんだい？   ここは君の夢の中でしょう？","…？帰り方？   もしかして君は迷子なの？","うーん…羊さんならわかるかも…   ついて来て　こっちだよ！"];';
			echo 'var serihu3 = ["やぁ　どうしたんだい   ウサギくん？","帰り方？","…教えたくないなぁ   うん…","そうだな   少し僕と遊んでよ","楽しめたら教えてあげる","準備はいいね？   いくよー"];';
			break;
			
		case 1:
					echo 'var serihu1 = ["…負けちゃったー","うん？   帰り方？","…ごめんね  実は知らないんだ","ハハハ   でもそうだな王様なら知ってるんじゃないかな？","きいてみたら？"];';
			echo 'var serihu2 = ["…何の用だ？","帰り道？   そうか君は夢の中で迷子なのか","…確かに私は知っている","だが教えたくない   君が帰れば君の夢は終わってしまう","君には悪いが、ここから先には行かせはしない！"];';
			break;
		case 2:
				echo 'var serihu1 = ["そうか…私では君を止められないか…","…君の帰り道だが……","本来道がわからずとも   勝手に夢は終わる物だ","それがわからないということは   おそらく誰かが邪魔をしているのだろう","…おそらくだが","邪魔をしているのはアリスだろう","彼女の居場所は私もわからない   彼女のおもちゃを尋ねるといいだろう"];';
				echo 'var serihu2 = ["君たちは何だい…？   …","そうか　この夢を覚まそうとしているのか","ということは   アリスを探しているのかい？","…","アリスは…僕が守るんだ…！"];';
			break;
		case 3:
				echo 'var serihu1 = ["そうか…夢はいつか覚めるのか…","でもアリスはきっと　この夢を終わらせないよ","それでもいいの？","…そう","アリスは　おもちゃの家にいるはずだよ"];';
				echo 'var serihu2 = ["あはははは","はじめまして   私はアリス","遊びにきたの？   遊びにきたのね？","遊ぼう　遊ぼうよ","ずっと夢の中で遊び続けるの"];';
			break;
		case 4:
				echo 'var serihu1 = ["なんで？　なんで？   なんで　なんで　なんで　なんで　なんで　なんで！","どうして　どうして！　どうして！   どうして！　どうして！どうして！　どうしてよ！！","私はただ　遊びたかっただけなのに…","誰かと遊びたかっただけなのに…"];';
				echo 'var serihu2 = ["なら","僕が友達になるよ","これからも遊べるよ　アリスさん","ね？"];';
				echo 'var serihu3 = ["…うん…","…","ごめんなさい","うさぎさん","ありがとう"];';
				echo 'var serihu4 = ["…日が毎朝昇る様に…   夜も毎日訪れ","毎晩　人は夢を見るよね","…これで夢は覚めるけど","また　会おうね！"];';
				echo 'var serihu5 = ["Thank you for Playing!"];';	
	}
	
	//イベントナンバー
	echo "</script>";
}
?>

<script>
	switch(c_num){
		case 0:
			event0();
			break;	
		case 1:
			event1();
			break;
		case 2:
			event2();
			break;
		case 3:
			event3();
			break;
			case 4:
			event4();
			break;	
		case 5:
			event5();
			break;
		case 6:
			event6();
			break;
		case 7:
			event7();
			break;
		case 8:
			event8();
			break;
	}


	function event0(){//チャプター0バトル前
		$("#image1").css("background-image","url(img/usagi_2.jpg)");
		var text_count = 0;
		var count_max1 = 5;
		var count_max2 = 5;
		$("#name_box").text("自分");
		$("#serihu p").text(serihu1[text_count]);
		
		$("#serihu").click(function(){
			if(text_count >= (count_max1+count_max2)){//セリフ終わり
				$("form input").val("1");//post送信
				var post = $("form")
				post.submit();				
			}else if(text_count>=count_max1){//ウサギのセリフ
				if(text_count == 5){
					$("#image1").fadeIn(1000);	
					$("#name_box").text("臆病なウサギ");
				}
				$("#serihu").fadeOut("slow",function(){					
					serihu_change(serihu2, text_count-count_max1);
					text_count += 1;
				});				
			}else{//自分のセリフ
				$("#serihu").fadeOut("slow",function(){
					text_count += 1;
					serihu_change(serihu1, text_count);
				});				
			}			
		});		
	};


	function event1(){//チャプター0ボス前
		$("#image1").css("background-image","url(img/enemy9.jpg)");
		$("#image1").fadeIn(1000);
		var text_count = 0;
		var count_max1 = 5;
		$("#name_box").text("夢の住民");
		$("#serihu p").text(serihu3[text_count]);
		
		$("#serihu").click(function(){
			if(text_count >= count_max1){//セリフ終わり
				$("form input").val("2");//post送信
				var post = $("form")
				post.submit();				
			}else{//羊のセリフ
				$("#serihu").fadeOut("slow",function(){
					text_count += 1;
					serihu_change(serihu3, text_count);
				});				
			}			
		});		
	};

	function event2(){//チャプター1バトル前
		$("#image1").css("background-image","url(img/enemy9.jpg)");
		$("#image1").fadeIn(1000);
		var text_count = 0;
		var count_max1 = 4;
		$("#name_box").text("夢の住民");
		$("#serihu p").text(serihu1[text_count]);
		
		$("#serihu").click(function(){
			if(text_count >= count_max1){//セリフ終わり
				$("form input").val("3");//post送信
				var post = $("form")
				post.submit();				
			}else{//羊のセリフ
				$("#serihu").fadeOut("slow",function(){
					text_count += 1;
					serihu_change(serihu1, text_count);
				});				
			}			
		});		
	};

	function event3(){//チャプター１ボス前
		$("#image1").css("background-image","url(img/enemy10.jpg)");
		$("#image1").fadeIn(1000);
		var text_count = 0;
		var count_max1 = 5;
		$("#name_box").text("王様");
		$("#serihu p").text(serihu2[text_count]);
		
		$("#serihu").click(function(){
			if(text_count >= count_max1){//セリフ終わり
				$("form input").val("4");//post送信
				var post = $("form")
				post.submit();				
			}else{//猫のセリフ
				$("#serihu").fadeOut("slow",function(){
					text_count += 1;
					serihu_change(serihu2, text_count);
				});				
			}			
		});		
	};
	
	function event4(){//チャプター2バトル前
		$("#image1").css("background-image","url(img/enemy10.jpg)");
		$("#image1").fadeIn(1000);
		var text_count = 0;
		var count_max1 = 6;
		$("#name_box").text("王様");
		$("#serihu p").text(serihu1[text_count]);
		
		$("#serihu").click(function(){
			if(text_count >= count_max1){//セリフ終わり
				$("form input").val("5");//post送信
				var post = $("form")
				post.submit();				
			}else{//王様のセリフ
				$("#serihu").fadeOut("slow",function(){
					text_count += 1;
					serihu_change(serihu1, text_count);
				});				
			}			
		});		
	};


	function event5(){//チャプター2ボス前
		$("#image1").css("background-image","url(img/enemy11.jpg)");
		$("#image1").fadeIn(1000);
		var text_count = 0;
		var count_max1 = 4;
		$("#name_box").text("友達思いのおもちゃ");
		$("#serihu p").text(serihu2[text_count]);
		
		$("#serihu").click(function(){
			if(text_count >= count_max1){//セリフ終わり
				$("form input").val("6");//post送信
				var post = $("form")
				post.submit();				
			}else{//おもちゃのセリフ
				$("#serihu").fadeOut("slow",function(){
					text_count += 1;
					serihu_change(serihu2, text_count);
				});				
			}			
		});		
	};
	
	
	function event6(){//チャプター3バトル前
		$("#image1").css("background-image","url(img/enemy11.jpg)");
		$("#image1").fadeIn(1000);
		var text_count = 0;
		var count_max1 = 4;
		$("#name_box").text("おもちゃ");
		$("#serihu p").text(serihu1[text_count]);
		
		$("#serihu").click(function(){
			if(text_count >= count_max1){//セリフ終わり
				$("form input").val("7");//post送信
				var post = $("form")
				post.submit();				
			}else{//おもちゃのセリフ
				$("#serihu").fadeOut("slow",function(){
					text_count += 1;
					serihu_change(serihu1, text_count);
				});				
			}			
		});		
	};
	
	function event7(){//チャプター3ボス前
		$("#image1").css("background-image","url(img/enemy12.jpg)");
		$("#image1").fadeIn(1000);
		var text_count = 0;
		var count_max1 = 4;
		$("#name_box").text("アリス");
		$("#serihu p").text(serihu2[text_count]);
		
		$("#serihu").click(function(){
			if(text_count >= count_max1){//セリフ終わり
				$("form input").val("8");//post送信
				var post = $("form")
				post.submit();				
			}else{//アリスのセリフ
				$("#serihu").fadeOut("slow",function(){
					text_count += 1;
					serihu_change(serihu2, text_count);
				});				
			}			
		});		
	};
	
		function event8(){//エンディング
		$("#image2").css("background-image","url(img/usagi_2.jpg)");
		$("#image1").css("background-image","url(img/enemy12.jpg)");
		$("#image1").fadeIn(1000);
		var text_count = 0;
		var count_max1 = 3;
		var count_max2 = 4;
		var count_max3 = 5;
		var count_max4 = 4;
		var count_max5 = 1;
		var count_maxs = count_max1+count_max2+count_max3+count_max4+count_max5;
		$("#name_box").text("アリス");
		$("#serihu p").text(serihu1[text_count]);
		
		$("#serihu").click(function(){
			if(text_count >= count_maxs){//セリフ終わり
				$("form").attr("action","menu.php");//post送信
				var post = $("form")
				post.submit();
			}else if(text_count >= (count_maxs -count_max5)){//thankのセリフ
				$("#serihu").fadeOut("slow",function(){					
					serihu_change(serihu5, 1);
					text_count += 1;
				});				
			}else if(text_count >= (count_maxs - (count_max5 + count_max4))){//ウサギのセリフ
				$("#name_box").text("臆病なウサギ");
				$("#serihu").fadeOut("slow",function(){					
					serihu_change(serihu4, text_count - (count_max1+count_max2+count_max3)); 
					text_count += 1;
				});		
			}else if(text_count >= (count_max1 + count_max2)){//アリスのセリフ

				$("#name_box").text("アリス");
				$("#serihu").fadeOut("slow",function(){					
					serihu_change(serihu3, text_count - (count_max1+count_max2)); 
					text_count += 1;
				});		
			}
			else if(text_count >= count_max1){//ウサギのセリフ
				$("#name_box").text("臆病なウサギ");
				$("#serihu").fadeOut("slow",function(){
					var c = text_count - count_max1;
					serihu_change(serihu2, c);
					text_count += 1;
				});		
			}else{//アリスのセリフ１
				$("#serihu").fadeOut("slow",function(){
					serihu_change(serihu1, text_count);
				});		
				text_count += 1;
			}
		});		
	};
	
	
	

	function serihu_change(serihu,num){//セリフ処理
		$("#serihu p").text(serihu[num]);
		setTimeout(function(){
			$("#serihu").fadeIn(1000);
		}, 300);
	}
</script>
</body>
</html>
