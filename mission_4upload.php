<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body>

<?php
//3-1 データベースに接続
$dsn = 'データベース名';
$user = 'ユーザー名';
$password = 'パスワード';
$pdo = new PDO ($dsn, $user, $password);    
    
//3-2 DB内にテーブルを作成
$sql="CREATE TABLE tb1"
."("
."id INT PRIMARY KEY AUTO_INCREMENT,"
."name char(32),"
."comment TEXT,"
."password char(32),"
."date text"
.");";
$stmt = $pdo -> query($sql);
?>

<?php
$edit = $_POST["編集対象番号"];
$name = $_POST["名前"];
$coments = $_POST["コメント"];
$date = date("Y年m月d日 H時i分");
$delite = $_POST["削除対象番号"];
$password = $_POST["パスワード"];
$passdeli = $_POST["削除パスワード"];
$passedit = $_POST["編集パスワード"];

//編集番号が届いたとき
if(!empty($edit)){
    $sql = "select*from tb1 WHERE id = $edit";
    $results = $pdo -> query($sql);
    foreach($results as $row){
        if($row['password'] == $passedit){
            $editnumber = $row['id'];
            $name1 = $row['name'];
            $coments1 = $row['comment'];
            $password1 = $row['password'];
        }else{
            echo "パスワードが違います";
        }
    }
}

$editnum = $_POST["編集番号"];
if(!empty($editnum)){
    $sql = "update tb1 set name = '$name', comment='$coments', password='$password', date='$date' where id = $editnum";
    $result = $pdo -> query($sql);
}

//削除番号が届いたとき
if(!empty($delite)&&empty($edit)){
    $sql = "select*from tb1 WHERE id = $delite";
    $results = $pdo -> query($sql);
    foreach($results as $row){
        if($row['password'] == $passdeli){
            $sql = "delete from tb1 where id = $delite";
            $result = $pdo -> query($sql);
        }else{
            echo "パスワードが違います";
        }
    }
}

//名前とコメントとパスワードが届いたとき    
if(!empty($name)&&($coments)&&(password)&&empty($editnum)){
    //3-5 DBに入力する
    $sql = $pdo -> prepare("INSERT INTO tb1 (id, name, comment, password, date) VALUES(:id, :name, :comment, :password, :date)");
    $sql -> bindParam(':id', $id, PDO::PARAM_STR);
    $sql -> bindParam(':name', $name, PDO::PARAM_STR);
    $sql -> bindParam(':comment', $coments, PDO::PARAM_STR);
    $sql -> bindParam(':password', $password, PDO::PARAM_STR);
    $sql -> bindParam(':date', $date, PDO::PARAM_STR);
    $sql -> execute();
}
?>

<!--入力フォーム-->
<form method="post" action="mission_4upload.php" name="入力フォーム">
    <tr><td><input type="text" name="名前" placeholder="名前" value="<?php echo $name1 ?>"></td></tr>
    <br>
    <tr><td><input type ="text"  name="コメント" placeholder="コメント" value = "<?php echo $coments1 ?>" ></td></tr>
    <br>
    <tr><td><input type ="text"  name="パスワード" placeholder="パスワード" value = "<?php echo $password1 ?>"></td></tr>
    <input type = "submit" value="送信">
    <br>
    <tr><td><input type ="hidden"  name="編集番号" value = "<?php echo "$editnumber" ?>"></td></tr>
    <br>
    <tr><td><input type ="text"  name="削除対象番号" placeholder="削除対象番号" ></td></tr>
    <br>
    <tr><td><input type ="text"  name="削除パスワード" placeholder="パスワード"></td></tr>
    <input type = "submit" value="送信">
    <br>
    <br>
    <tr><td><input type ="text"  name="編集対象番号" placeholder="編集対象番号" ></td></tr>
    <br>
    <tr><td><input type ="text"  name="編集パスワード" placeholder="パスワード"> </td></tr>
    <input type = "submit" value="送信">
</form>


<?php
//3-6 テーブルを表示する
echo "<hr>";
$sql = 'SELECT*FROM tb1 ORDER BY id';
$results = $pdo -> query($sql);
foreach($results as $row){
    //$rowの中にテーブルのカラム名が入る
    echo $row['id'].' ';
    echo $row['name'].' ';
    echo $row['comment'].' ';
    echo $row['date'].'<br>';
}
?>

</body>
</html>