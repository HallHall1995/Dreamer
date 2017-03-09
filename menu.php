<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Sleeper</title>
<link rel="stylesheet" type="text/css" href="menus.css">
</head>
<?php
	$eve;
	$userID;
	$battle_or = $_POST["battle_or"];
	$star = 0;
	
	if($battle_or == 1){//ストーリークリア時
		$userID = $_COOKIE["sleepID"];
		$me_eve=0;
		$me_star=0;
		$eve = $_POST["story_num"];
		$dbh = new PDO('mysql:host=localhost;dbname=sleeper','root','2I9MLjwx');
		$dbh->query('SET NAMES utf8');//非奨順だが日本語化
		$sql = "select * from user_table";
		$st = $dbh->query($sql);
 		while($result = $st->fetch(PDO::FETCH_ASSOC)){//同じIDがあるか調べる
			if($result['NAME'] == $userID){
				$me_eve = $result['EVENT'];
				$me_star = $result['STAR'];
			}
	 	}

		if($eve>$me_eve){
			$dbh = new PDO('mysql:host=localhost;dbname=sleeper','root','2I9MLjwx');
			$dbh->query('SET NAMES utf8');//非奨順だが日本語化
			$box = $dbh->prepare("update user_table set EVENT=:eve where NAME = :user");//--------------
			$box->execute(array(":eve"=>$eve, ":user"=>$userID));
			$h_eve = $eve;
			
		}
		$dbh = new PDO('mysql:host=localhost;dbname=sleeper','root','2I9MLjwx');
		$dbh->query('SET NAMES utf8');//非奨順だが日本語化
		$box = $dbh->prepare("update user_table set STAR =:star where NAME = :user");
		$h_star = $me_star + 1;
		$box->execute(array(":star"=>$h_star, ":user"=>$userID));
		$star = $h_star;
	}else if($battle_or==0){//ログイン時
		$ID = $_POST["userID"];
		$passward = $_POST["passward"];
		try {
			$dbh = new PDO('mysql:host=localhost;dbname=sleeper','root','2I9MLjwx');
			$dbh->query('SET NAMES utf8');//非奨順だが日本語化
			$sql = "select * from user_table";
			$st = $dbh->query($sql);
			$check = 0;
 			while($result = $st->fetch(PDO::FETCH_ASSOC)){//同じIDがあるか調べる
				if(($result['NAME'] == $ID)&&($result['PASSWARD'])){
						$check = 1;	
						$star = $result['STAR'];
					}
	 			}
			} catch(PDOException $e) {
				var_dump($e->getMessage());
				exit;
			}
		if($check ==1){
			setcookie('sleepID',$ID);
		}else{//idとパスワードが異なるとき
			echo "<script> history.back(); </script>";
		}
	}else{//ゲームオーバー　戻る
		$userID = $_COOKIE["sleepID"];
		$me_star=0;
		$dbh = new PDO('mysql:host=localhost;dbname=sleeper','root','2I9MLjwx');
		$dbh->query('SET NAMES utf8');//非奨順だが日本語化
		$sql = "select * from user_table";
		$st = $dbh->query($sql);
 		while($result = $st->fetch(PDO::FETCH_ASSOC)){//同じIDがあるか調べる
			if($result['NAME'] == $userID){
				$star = $result['STAR'];
			}
	 	}
	}
	
	?>

<body>
<div id="main">
	<div id="pack">
    	<div id="space"></div>
        <div id="left_image"></div>
        
        <div id="menu_wrap">
        		<a href="story_sentaku.php">
        			<div id="menu_box">Go to World</div>
            </a>
            <a href="change_page.php">
            		<div id="menu_box">Change a member</div>
            </a>
            <a href="gacha.php">
            		<div id="menu_box">Get a member</div>
            </a>
        	<div id="menu_box">How to</div>
        </div>
        
        <div id="right_wrap">
        	<div id="img_box"></div>
            <div id="star_box">★×<?php echo $star; ?></div>
            <div id="rogout"></div>
        </div>
    </div>
</div>
</body>
</html>
