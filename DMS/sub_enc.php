<html>
<head>
<meta charset="UTF-8">
</head>
<body>
<pre style="font-size:20px"><?php
$key=array(array(),array());
$msg='hellohellohellohello';
$msg_16=str_split($msg,16);

$full_enc_hex_msg='';$full_enc_msg='';
for($a=0;$a<count($msg_16);$a++){
    $hex_msg=implode(unpack("H*", $msg_16[$a]));
    while(strlen($hex_msg)!=32){$hex_msg=$hex_msg.'0';}
    $hex_msg_c=str_split($hex_msg,2);
$state=array(array(),array());
$k=0;
for($i=0;$i<4;$i++){
    for($j=0;$j<4;$j++){
        $state[$j][$i]=$hex_msg_c[$k];$k++;
    }
}

$s_box=array(
    array('63','7c','77','7b','f2','6b','6f','c5','30','01','67','2b','fe','d7','ab','76'),
    array('ca','82','c9','7d','fa','59','47','f0','ad','d4','a2','af','9c','a4','72','c0'),
    array('b7','fd','93','26','36','3f','f7','cc','34','a5','e5','f1','71','d8','31','15'),
    array('04','c7','23','c3','18','96','05','9a','07','12','80','e2','eb','27','b2','75'),
    array('09','83','2c','1a','1b','6e','5a','a0','52','3b','d6','b3','29','e3','2f','84'),
    array('53','d1','00','ed','20','fc','b1','5b','6a','cb','be','39','4a','4c','58','cf'),
    array('d0','ef','aa','fb','43','4d','33','85','45','f9','02','7f','50','3c','9f','a8'),
    array('51','a3','40','8f','92','9d','38','f5','bc','b6','da','21','10','ff','f3','d2'),
    array('cd','0c','13','ec','5f','97','44','17','c4','a7','7e','3d','64','5d','19','73'),
    array('60','81','4f','dc','22','2a','90','88','46','ee','b8','14','de','5e','0b','db'),
    array('e0','32','3a','0a','49','06','24','5c','c2','d3','ac','62','91','95','e4','79'),
    array('e7','c8','37','6d','8d','d5','4e','a9','6c','56','f4','ea','65','7a','ae','08'),
    array('ba','78','25','2e','1c','a6','b4','c6','e8','dd','74','1f','4b','bd','8b','8a'),
    array('70','3e','b5','66','48','03','f6','0e','61','35','57','b9','86','c1','1d','9e'),
    array('e1','f8','98','11','69','d9','8e','94','9b','1e','87','e9','ce','55','28','df'),
    array('8c','a1','89','0d','bf','e6','42','68','41','99','2d','0f','b0','54','bb','16')
);
for($i=0;$i<4;$i++){
    for($j=0;$j<4;$j++){
        $val=$state[$i][$j];
        $val_arr=str_split($val);
        $state[$i][$j]=$s_box[hexdec($val_arr[0])][hexdec($val_arr[1])];
    }
}

$shift_row_enc=array(
    array('00','01','02','03'),
    array('11','12','13','10'),
    array('22','23','20','21'),
    array('33','30','31','32')
);
$tr_state=array(array(),array());
for($i=0;$i<4;$i++){
    for($j=0;$j<4;$j++){
        $val=$shift_row_enc[$i][$j];
        $val_arr=str_split($val);
        $tr_state[$i][$j]=$state[$val_arr[0]][$val_arr[1]];
    }
}

for($i=0;$i<4;$i++){
    $k='';
    $b=array($tr_state[$i][0],$tr_state[$i][1],$tr_state[$i][2],$tr_state[$i][3]);
    for($j=0;$j<8;$j++){
        $ki=$b[0];
        $b[0]=$b[1];
        $b[1]=$b[2];
        $b[2]=$b[3];
        $b[3]=bin2hex(pack('H*',$ki) ^ pack('H*',$b[0]));
        if($j>3)$k=$k.$ki;
    }
    $key[$a][$i]=$k;
    $p_key=str_split($key[$a][$i],2);
   
    for($j=0;$j<4;$j++){
        $temp=bin2hex(pack('H*',$tr_state[$j][$i]) ^ pack('H*',$p_key[$j]));
        $tr_state[$j][$i]=$temp;
    }
}
print_r($key);

$state_one = array();
foreach ($tr_state as $value) {
$state_one = array_merge($state_one, $value);
}
$enc_hex_msg=implode($state_one);
$full_enc_hex_msg=$full_enc_hex_msg.$enc_hex_msg;
$string='';
for ($i=0; $i < strlen($enc_hex_msg)-1; $i+=2){
    $string .= chr(hexdec($enc_hex_msg[$i].$enc_hex_msg[$i+1]));
}
$full_enc_msg=$full_enc_msg.$string;
}
echo $full_enc_hex_msg."\n\n".$full_enc_msg;




?></pre>
</body>
</html>

