<?php
$dsn='データベース名';
$user='ユーザー名';
$password='パスワード';
$pdo=new PDO($dsn,$user,$password);

$sql="CREATE TABLE nnn"
."("
."id INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,"
."name char(32),"
."comment TEXT"
.");";
$stmt=$pdo->query($sql);

$sql="ALTER TABLE nnn ADD password INT";
$stmt=$pdo->query($sql);

$sql="ALTER TABLE nnn ADD update_time timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP";
$stmt=$pdo->query($sql);

$sql="ALTER TABLE nnn DROP COLUMN id";
$stmt=$pdo->query($sql);

$sql="ALTER TABLE nnn ADD id INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY";
$stmt=$pdo->query($sql);


$deletenumber=$_POST['deletenumber'];
$editnumber=$_POST['editnumber'];
$editContents=$_POST['editContents'];
$password1=$_POST['password1'];
$password2=$_POST['password2'];
$pass=$_POST['pass'];



if(!empty($editContents)){
$sql="SELECT*FROM nnn where id=$editContents";
$result=$pdo->query($sql);
foreach($result as $nn){
   if($pass==$nn['password']){
   $id=$editContents;
   $name=$_POST['name']; 
   $comment=$_POST['comment'];
   $sql="update nnn set name='$name',comment='$comment' where id=$id";
   $result=$pdo->query($sql);
     }
   }
}else{
   if(!empty($_POST['name'])&&!empty($_POST['comment'])){
   $sql=$pdo->prepare("INSERT INTO nnn(name,comment,password)VALUES(:name,:comment,:password)");
   $sql->bindParam(':name',$name,PDO::PARAM_STR);
   $sql->bindParam(':comment',$comment,PDO::PARAM_STR);
   $sql->bindParam(':password',$password,PDO::PARAM_STR);
   $name=$_POST['name']; 
   $comment=$_POST['comment'];
   $password=$_POST['password'];
   $sql->execute();
   }
}


if(!empty($editnumber)){
$sql="SELECT*FROM nnn where id=$editnumber";
$result=$pdo->query($sql);
   foreach($result as $ss){
      if($password2==$ss['password']){
        $ss_name=$ss['name'];
        $ss_comment=$ss['comment'];
       }else{
        echo "パスワード間違いました。";
        }
    }
}

if(!empty($deletenumber)){
$sql="SELECT*FROM nnn where id=$deletenumber";
$result=$pdo->query($sql);
  foreach($result as $aa){
     if($password1==$aa['password']){
     $id=$deletenumber;
     $sql="delete from nnn where id=$id";
     $result=$pdo->query($sql);
     }else{
     echo "パスワード間違いました。";
         }
     }
}
?>



<html>
  <head>
   <title>mission4-1test</title>
   <meta charset="utf-8">
  </head>
     <body>
     <h2>名前とコメントを書いてください。</h2>
        <form method="POST" action="mission4-1test.php">
        <label for="name">名前：</label>
        <input type="text"name='name'value="<?php echo $ss_name;?>"><br><br>
        <label for="comment">コメント:</label>
        <input type="text"name='comment' value="<?php echo $ss_comment;?>"><br><br>
        <input type="hidden" name="editContents" value="<?php echo $editnumber;?>">
        <label for="password">パスワード:</label>
        <input type="text" name='password' value="">
        <input type="hidden" name='pass' value="<?php echo $password2;?>">
        <br>*パスワードは11以内の数字でお願いします。<br>
        
        <input type="submit"value="送信"><br><br>
        </form>

        <form method="POST" action="mission4-1test.php">
        <input type="text" name='deletenumber' value="削除対象番号"><br>
        <input type="text" name='password1' value="パスワード">
        <input type="submit"value="削除"><br><br>
        </form>

        <form method="POST" action="mission4-1test.php">
        <input type="text"name='editnumber' value="編集対象番号"><br>
        <input type="text" name='password2' value="パスワード">
        <input type="submit"value="編集">
        </form>

     </body>
</html>


<?php
$sql='SELECT*FROM nnn';
$results=$pdo->query($sql);
foreach($results as $row){
  echo $row['id'].',';
  echo $row['name'].',';
  echo $row['comment'].',';
  echo $row['update_time'].'<br>';
}
?>
