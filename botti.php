<?php

$data = [];

//テンプレ：$data[] = array();
$data[0] = array('大野智','二宮和也','櫻井翔','松本潤','相葉雅紀');
$data[1] = array('国分太一','松岡昌宏','長瀬智也','城島茂');
$data[2] = array('坂本昌行','長野博','井ノ原快彦','森田剛','三宅健');
$data[3] = array('横山裕','村上信五','丸山隆平','安田章大','大倉忠義');
$data[4] = array('山田涼介','知念侑李','中島裕翔','有岡大貴','高木雄也','伊野尾慧','八乙女光','薮宏太','岡本圭人');
$data[5] = array('中島健人','菊池風磨','佐藤勝利','松島聡','マリウス葉');
$data[6] = array('亀梨和也','上田竜也','中丸雄一');
$data[7] = array('加藤シゲアキ','小山慶一郎','手越祐也','増田貴久');

//人数が送信された場合
if(isset($_POST['num'])){
	$person = intval($_POST['num']);

	//自然数か判定する
	if($person > 0){

		//関数呼び出し
		$cookieArr = setValue($data, $person);

		$group = $cookieArr[0];
		$key1 = $cookieArr[1];
		$key2 = $cookieArr[2];
		$botti = $cookieArr[3];
		$count = $cookieArr[4];

		$cookieArr[] = $person;

		$cookieValue = implode(',',$cookieArr);
		setcookie('cookie',$cookieValue);

	}else{
		$error = '数字は1以上で入力してください。';
	}
}

//Cookieが存在する場合
if(isset($_COOKIE['cookie'])){
	$cookieArr = explode(',',$_COOKIE['cookie']);

	$group = $cookieArr[0];
	$key1 = $cookieArr[1];
	$key2 = $cookieArr[2];
	$botti = $cookieArr[3];
	$count = $cookieArr[4]+1;
	$person = $cookieArr[5];

	$cookieArr[4]++;

	//再びsetcookie
	$cookieValue = implode(',',$cookieArr);
	setcookie('cookie',$cookieValue);

	//リセットされた場合
	if(isset($_POST['reset'])){
		setcookie('cookie', $cookieValue, time()-3600);
	}
}


function setValue($data,$person){ //2回目アクセスしか発生しない。

	//group = $dataのどれを選ぶか
	$group = rand(0,(count($data))-1);

	//keys = $dataの多数派と少数派を決める
	$keys = array_rand($data[$group], 2);
	shuffle($keys);

	$key1 = $keys[0];
	$key2 = $keys[1];

	$botti = rand(1,$person);

	$count = 1;

	return array($group, $key1, $key2, $botti, $count);
}

?>

<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>ぼっちっちゲーム(仮)</title>
	<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
	<script src='js/bootstrap.bundle.js'></script>
	<link rel='stylesheet' href='css/bootstrap.css'>
</head>
<body>
	<div class='container'>

		<p></p>
		<p>☆リセット→人数入力→スタートを押すようにしてください☆</p>

		<form method='post'>
			<p><input type='number' name='num' style='width:50px;'>人でプレイ！
			<input type='submit' value='スタート'></p>
		</form>

		<p></p>


		<p>あなたのお題は：</p>
		<?php if(isset($_COOKIE['cookie']) || isset($_POST['num'])){  ?>
			<?php if($count == $botti){ ?>
				<p id='answer1'><?php echo $data[$group][$key1]; ?></p>
			
			<?php }elseif(intval($count) > intval($person)){ ?>			
				<p>人数分表示しました。</p>

			<?php }else{ ?>
				<p id='answer2'><?php echo $data[$group][$key2]; ?></p>
			<?php } ?>

			<form>
				<input type='submit' value='進む'>
			</form>

		<?php } ?>
		<p></p>
	
		

		<p></p>
		<input type='button' onclick="hidden1();" value='隠す'>

		<p></p>
		<form method="post">
			<input type='hidden' name='reset' value='reset'>
			<input type='submit' value='リセット'>
		</form>
		<?php if(isset($_POST['reset'])){ ?>
			<div>リセットされました</div>
		<?php }?>

		<?php if(isset($error) && empty($_COOKIE['cookie'])){ ?>
			<div>数字は1以上で入力してください。</div>
		<?php }?>

	</div>
	<script>
		function hidden1(){
			if(document.getElementById('answer1') != null){
				var ans1 = document.getElementById('answer1');
				ans1.style.display='none';
			}else{
				var ans2 = document.getElementById('answer2');
				ans2.style.display='none';
			}
		}

	</script>
</body>
</html>
