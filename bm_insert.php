<?php
//1. POSTデータ取得
$title = $_POST["title"];
$url = $_POST["url"];
$comment = $_POST["comment"];

//2. DB接続します
try {
  //ID ;’root',Password:MAMP='root',XAMPP=''
  $pdo = new PDO('mysql:dbname=gs_db_bookmark;charset=utf8;host=localhost','root',''); 
} catch (PDOException $e) {
  exit('DBConnectError:'.$e->getMessage());
}

//３．データ登録SQL作成
$sql = "INSERT INTO gs_bm_table(title,url,comment,indate)VALUES(:title,:url,:comment,sysdate());"; //直接変数入れると危ない
$stmt = $pdo->prepare($sql); //セキュリティを高めるための仕組み
$stmt->bindValue(':title',  $title,  PDO::PARAM_STR);  //Integer（文字列の場合 PDO::PARAM_STR)
$stmt->bindValue(':url',    $url,    PDO::PARAM_STR);  //Integer（文字列の場合 PDO::PARAM_STR)
$stmt->bindValue(':comment',$comment,PDO::PARAM_STR);  //Integer（文字列の場合 PDO::PARAM_STR)
$status = $stmt->execute(); //実行ボタン

//４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("SQLError:".$error[2]);
}else{
  //５．index.phpへリダイレクト
  header("Location: bm_index.php"); //LocationのLは大文字、index.phpの前は空白必須
  exit();
}
?>
