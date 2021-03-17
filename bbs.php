<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="utf-8">
	<title>paiza掲示板</title>
</head>

<body>
	<?php
	// データベースに接続する
	$pdo = new PDO("mysql:host=127.0.0.1;dbname=lesson;charset=utf8", "root", "");
	// print_r($_POST);

	// 受け取ったデータを書き込む
	if (isset($_POST["content"])) {
		$content = $_POST["content"];
		$sql  = "INSERT INTO bbs (content, updated_at) VALUES (:content, NOW());";
		$stmt = $pdo->prepare($sql);
		$stmt -> bindValue(":content", $content, PDO::PARAM_STR);
		$stmt -> execute();
	}
	?>

	<h1>paiza掲示板</h1>

	<h2>投稿フォーム</h2>
	<form action="bbs.php" method="post">
		<label>投稿内容</label>
		<input type="text" name="content">
		<button type="submit">送信</button>
	</form>

	<h2>発言リスト</h2>
	<?php
	// データベースからデータを取得する
	$sql = "SELECT * FROM bbs ORDER BY updated_at;";
	$stmt = $pdo->prepare($sql);
	$stmt -> execute();
	?>
	<table>
		<tr>
			<th>id</th>
			<th>日時</th>
			<th>投稿内容</th>
		</tr>
		<?php
		// 取得したデータを表示する
		while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)) { ?>
			<tr>
				<td><?= $row["id"] ?></td>
				<td><?= $row["updated_at"] ?></td>
				<td><?= $row["content"] ?></td>
			</tr>
		<?php } ?>
	</table>
</body>

</html>