<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>無題ドキュメント</title>
<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
</head>
<?php
	$moto = $_POST["moto"];
	$moto += 1;
	$moto_num=0;
	$saki = $_POST["saki"];
	$saki += 1;
	$saki_num=0;
	$userID = $_COOKIE["sleepID"];
	
	$dbh = new PDO('mysql:host=localhost;dbname=sleeper','root','2I9MLjwx');
	$dbh->query('SET NAMES utf8');//非奨順だが日本語化
	$sql = "select * from user_table";
	$st = $dbh->query($sql);
	
 	while($result = $st->fetch(PDO::FETCH_ASSOC)){//カードナンバー取得
		if($result['NAME'] == $userID){
			$moto_num = $result["card".($moto)];
			$saki_num = $result["card".($saki)];
		}
	}
	
	
	$box = $dbh->prepare("update user_table set card".$moto." =:c where NAME = :user");//--------------
	$box->execute(array(":c"=>$saki_num, ":user"=>$userID));
	
	$box = $dbh->prepare("update user_table set card".$saki." =:c where NAME = :user");//--------------
	$box->execute(array(":c"=>$moto_num, ":user"=>$userID));
?>

<script>
	$(function(){
		$("form").submit();
	});
</script>

<body>
<form action="menu.php" method="post">
	<input type="hidden" name="battle_or" value="2">
</form>
</body>
</html>