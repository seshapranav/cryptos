<?php
session_start();
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=cse1007', 'bindhu', 'bindhu');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
if(isset($_POST['disconnect'])){header("Location:logged_index.php");}
if(isset($_POST['send'])){
  
$plaintext=$_POST['message'];
$light_yellow=['a'=>1,'b'=>2,'c'=>3,'d'=>4,'e'=>5,'f'=>6,'g'=>7];
$dark_yellow=['h'=>1,'i'=>2,'j'=>3,'k'=>4,'l'=>5,'m'=>6];
$light_red=['n'=>1,'o'=>2,'p'=>3,'q'=>4,'r'=>5,'s'=>6,'t'=>7];
$dark_red=['u'=>1,'v'=>2,'w'=>3,'x'=>4,'y'=>5,'z'=>6];
$light_orange=[' '=>1,'!'=>2,'@'=>3,','=>4,'?'=>5,'.'=>6,'&'=>7];

$light_green=['A'=>1,'B'=>2,'C'=>3,'D'=>4,'E'=>5,'F'=>6,'G'=>7];
$dark_green=['H'=>1,'I'=>2,'J'=>3,'K'=>4,'L'=>5,'M'=>6];
$light_blue=['N'=>1,'O'=>2,'P'=>3,'Q'=>4,'R'=>5,'S'=>6,'T'=>7];
$dark_blue=['U'=>1,'V'=>2,'W'=>3,'X'=>4,'Y'=>5,'Z'=>6];


$key='';$enc_pt='';

$pt_char=str_split($plaintext);
for($i=0;$i<strlen($plaintext);$i++){
  if(isset($light_yellow[$pt_char[$i]])){$enc_num=($light_yellow[$pt_char[$i]]+6)%7;if($enc_num==0)$enc_num+=7;$key=$key.'ly';}
  if(isset($dark_yellow[$pt_char[$i]])){$enc_num=($dark_yellow[$pt_char[$i]]+5)%6;if($enc_num==0)$enc_num+=6;$key=$key.'dy';}
  if(isset($light_red[$pt_char[$i]])){$enc_num=($light_red[$pt_char[$i]]+6)%7;if($enc_num==0)$enc_num+=7;$key=$key.'lr';}
  if(isset($dark_red[$pt_char[$i]])){$enc_num=($dark_red[$pt_char[$i]]+5)%6;if($enc_num==0)$enc_num+=6;$key=$key.'dr';}
  if(isset($light_green[$pt_char[$i]])){$enc_num=($light_green[$pt_char[$i]]+6)%7;if($enc_num==0)$enc_num+=7;$key=$key.'lg';}
  if(isset($dark_green[$pt_char[$i]])){$enc_num=($dark_green[$pt_char[$i]]+5)%6;if($enc_num==0)$enc_num+=6;$key=$key.'dg';}
  if(isset($light_blue[$pt_char[$i]])){$enc_num=($light_blue[$pt_char[$i]]+6)%7;if($enc_num==0)$enc_num+=7;$key=$key.'lb';}
  if(isset($dark_blue[$pt_char[$i]])){$enc_num=($dark_blue[$pt_char[$i]]+5)%6;if($enc_num==0)$enc_num+=6;$key=$key.'db';}
  if(isset($light_orange[$pt_char[$i]])){$enc_num=($light_orange[$pt_char[$i]]+6)%7;if($enc_num==0)$enc_num+=7;$key=$key.'lo';}
  $enc_pt=$enc_pt.$enc_num;
}

$zeroes=0;
while(strlen($enc_pt)%7!=0){$enc_pt=$enc_pt.'0';$zeroes++;}
$permutation=[3,7,1,6,4,2,5];
$size=strlen($enc_pt)/7;
$enc_pt7=str_split($enc_pt,7);
for($i=0;$i<$size;$i++){
  $enc_pt_char=str_split($enc_pt7[$i]);
  $s_enc_pt_char=array();
  for($j=0;$j<7;$j++){$s_enc_pt_char[$j]=$enc_pt_char[$permutation[$j]-1];}
  $enc_pt7[$i]= implode($s_enc_pt_char);
}
$enc_pt=implode($enc_pt7);

  
  
  $stmt=$pdo->prepare("insert into feed(user_id,type,message) values (:user_id,:type,:message)");
    $stmt->execute(
      array(
        ':user_id' => $_SESSION['r_user_id'],
        ':type' => 1,
        ':message' => $enc_pt,
        )
    );
    $stmt=$pdo->prepare("insert into feed(user_id,type,message) values (:user_id,:type,:message)");
    $stmt->execute(
      array(
        ':user_id' => $_SESSION['user_id'],
        ':type' => 0,
        ':message' => $enc_pt,
        )
    );
    $stmt=$pdo->query("select * from feed");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
      if($row['message']===$enc_pt){
        $stmt1=$pdo->prepare("insert into decryption_keys(sl,decryption_key,zeroes) values (:sl,:decryption_key,:zeroes)");
        $stmt1->execute(
          array(
            ':sl' => $row['sl'],
            ':decryption_key' => $key,
            ':zeroes' => $zeroes,
            )
        );
      }
    }
  header("Location:chatbox.php");return;
}
?>
<html>
  <head>
    <title>Secure Chat</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="nvbr">
      <a class="navbar-brand" href="index.php" style="color: rgb(14, 165, 14);">
      <img src="Untitled.png" width="45" height="45" class="d-inline-block align-top" alt="">    Secure Chat</a>
      <span class="navbar-text" style="font-size: 18px;">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarText">
                  <ul class="navbar-nav mr-auto" id="menuoptions">
                    <li class="nav-item active">
                      <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="aboutus.php">About Us</a>
                    </li>
                      <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout </a>
                      </li>
                      
                    </ul>
                    
                  </div>

            </span>
    </nav>
          
          <div class="container-fluid" id=contents  style="min-height:600px;">
       
          <h2 style="color:rgb(14, 165, 14);text-align:center;"><?php echo $_SESSION['name']." &rarr; ".$_SESSION['r_name'];?></h2>
          <div style=" background-image:url(Untitled1.png);  background-repeat: no-repeat;
background-position: center;min-height:500px;margin:20px;
          margin-left:70px;margin-right:70px;border-radius:10px;background-color:white;
          padding:20px;">
          <pre><?php
          $stmt=$pdo->query("select * from feed");
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $stmt1=$pdo->query("select * from decryption_keys");
            while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)){
              if($row['sl']===$row1['sl']){$key=$row1['decryption_key'];$zeroes=$row1['zeroes'];}
            }
            $enc_pt=$row['message'];
            $size=strlen($enc_pt)/7;
$enc_pt7=str_split($enc_pt,7);
$dec_permutation=[3,6,1,5,7,4,2];
$light_yellow=['a','b','c','d','e','f','g'];
$dark_yellow=['h','i','j','k','l','m'];
$light_red=['n','o','p','q','r','s','t'];
$dark_red=['u','v','w','x','y','z'];

$light_green=['A','B','C','D','E','F','G'];
$dark_green=['H','I','J','K','L','M'];
$light_blue=['N','O','P','Q','R','S','T'];
$dark_blue=['U','V','W','X','Y','Z'];
$light_orange=[' ','!','@',',','?','.','&'];
for($i=0;$i<$size;$i++){
  $enc_pt_char=str_split($enc_pt7[$i]);
  $s_dec_pt_char=array();
  for($j=0;$j<7;$j++){$s_dec_pt_char[$j]=$enc_pt_char[$dec_permutation[$j]-1];}
  $dec_pt7[$i]= implode($s_dec_pt_char);
}
$dec_pt=implode($dec_pt7);
$dec_pt=substr($dec_pt,0,(7*$size)-$zeroes);
$dec_pt7=str_split($dec_pt,7);
$key2=str_split($key,2);
$pt='';$iter=0;
for($j=0;$j<$size;$j++){
  
$dec_pt1=str_split($dec_pt7[$j]);
for($i=0;$i<strlen($dec_pt7[$j]);$i++){

  if($key2[$iter]=='ly'||$key2[$iter]=='lr'||$key2[$iter]=='lg'||$key2[$iter]=='lb'||$key2[$iter]=='lo'){$num=(intval($dec_pt1[$i])+1)%7;if($num==0)$num+=7;}
  if($key2[$iter]=='dy'||$key2[$iter]=='dr'||$key2[$iter]=='dg'||$key2[$iter]=='db'){$num=(intval($dec_pt1[$i])+1)%6;if($num==0)$num+=6;}
  if($key2[$iter]=='ly'){$pt=$pt.$light_yellow[$num-1];}
  if($key2[$iter]=='lo'){$pt=$pt.$light_orange[$num-1];}
  if($key2[$iter]=='lr'){$pt=$pt.$light_red[$num-1];}
  if($key2[$iter]=='lg'){$pt=$pt.$light_green[$num-1];}
  if($key2[$iter]=='lb'){$pt=$pt.$light_blue[$num-1];}
  if($key2[$iter]=='dy'){$pt=$pt.$dark_yellow[$num-1];}
  if($key2[$iter]=='dr'){$pt=$pt.$dark_red[$num-1];}
  if($key2[$iter]=='dg'){$pt=$pt.$dark_green[$num-1];}
  if($key2[$iter]=='db'){$pt=$pt.$dark_blue[$num-1];}$iter++;
}}
            

            if($row['user_id']===$_SESSION['user_id']){
              if($row['type']==0){
                echo '<div class="card" style="width: fit-content;float:right">
                <div class="card text-right" style="width:fit-content;float:right;background-color: rgb(125, 215, 245);">
                <ul class="list-group list-group-flush">
                <li class="list-group-item">'.$pt.'</li>
                </ul>
              </div></div>';
              }
              if($row['type']==1){
                echo '
                <div class="card" style="width: 100%;">
                <div class="card" style="width: fit-content;background-color: rgb(125, 215, 245);">
                <ul class="list-group list-group-flush">
                <li class="list-group-item">'.$pt.'</li>
                </ul>
                </div>
                </div>
                ';
              }
            }
          }
          ?></pre>
          </div>
          <form method="POST">
  <div class="form-group row" style="padding-left:70px">
    <span class="col-sm-10">
      <input type="text" class="form-control" name="message" placeholder="Type a message to send">
      
    </span>
    <button type="submit" class="btn btn-primary" name="send">Send</button>&nbsp;
    <button type="submit" class="btn btn-primary" name="disconnect">Disconnect</button>
  </div>
</form>
          </div>
        
          <footer class="panel-footer" id="foot">
          <div class="container"></div>
              <div style="text-align: center;">
                This application is developed by: C. Bindhu Madhava Varma - 19BCD7116.
                P. Krishna Dheeraj - 19BCN7030 B. Mohan Srinivasa Sarma - 19BCN7015
                CH. Sesha Pranav - 19BCN7190
              </div>  
              <hr>
              <div class=" col-sm-12" style="text-align: center;" >&copy; Copyright Secure Chat 2020 <br>All Rights reserved &copy;2020.</div>
            </div>
          </footer>
          <script src="../jquery-1.11.3.min.js"></script>
          <script src="../js/bootstrap.min.js"></script>
        </body>
        </html>
    </body>
</html> 