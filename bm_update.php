<?php
//PHP:コード記述/修正の流れ
//1. insert.phpの処理をマルっとコピー。
//   POSTデータ受信 → DB接続 → SQL実行 → 前ページへ戻る
//2. $id = POST["id"]を追加
//3. SQL修正
//   "UPDATE テーブル名 SET 変更したいカラムを並べる WHERE 条件"
//   bindValueにも「id」の項目を追加
//4. header関数"Location"を「select.php」に変更
//1. POSTデータ取得
$title   = $_POST["title"];
$url  = $_POST["url"];
$comment = $_POST["comment"];
$id    = $_POST["id"];

//2. DB接続します
include("funcs.php"); //funcs.phpを読み込み

//３．データ登録SQL作成
$pdo = db_conn(); //関数として呼び出し
$sql = "UPDATE gs_bm_table SET title=:title,url=:url,comment=:comment WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':title',    $title,    PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':url',      $url,      PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':comment',  $comment,  PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':id',       $id,       PDO::PARAM_INT); 
$status = $stmt->execute(); //実行

//４．データ登録処理後
if($status==false){
    sql_error($stmt);//間数sql_errorを実行
}else{
    redirect("bm_select.php");
}
?>
