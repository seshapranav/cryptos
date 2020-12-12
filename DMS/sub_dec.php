<html>
<head>
<meta charset="UTF-8">
</head>
<body>
<pre style="font-size:20px"><?php

function transpose($array) {
    return array_map(null, ...$array);
}
$key=array(
    array('6e0ed855','e3e9048d','425700af','9a5d2c9a')
);

$hex_msg='a8634d58a8637eb5634d632eedd62e3b';
$hex_msg_32=str_split($hex_msg,32);
$dec_msg='';
for($a=0;$a<count($hex_msg_32);$a++){
    $hex_msg_c=str_split($hex_msg_32[$a],2);
    $state=array(array(),array());
    $k=0;
    for($i=0;$i<4;$i++){
        for($j=0;$j<4;$j++){
            $state[$i][$j]=$hex_msg_c[$k];$k++;
        }
    }

    for($i=0;$i<4;$i++){
        $p_key=str_split($key[$a][$i],2);
        for($j=0;$j<4;$j++){
            $temp=bin2hex(pack('H*',$state[$j][$i]) ^ pack('H*',$p_key[$j]));
            $state[$j][$i]=$temp;
        }
    }


    $s_box=array(
        array('52','09','6a','d5','30','36','a5','38','bf','40','a3','9e','81','f3','d7','fb'),
        array('7c','e3','39','82','9b','2f','ff','87','34','8e','43','44','c4','de','e9','cb'),
        array('54','7b','94','32','a6','c2','23','3d','ee','4c','95','0b','42','fa','c3','4e'),
        array('08','2e','a1','66','28','d9','24','b2','76','5b','a2','49','6d','8b','d1','25'),
        array('72','f8','f6','64','86','68','98','16','d4','a4','5c','cc','5d','65','b6','92'),
        array('6c','70','48','50','fd','ed','b9','da','5e','15','46','57','a7','8d','9d','84'),
        array('90','d8','ab','00','8c','bc','d3','0a','f7','e4','58','05','b8','b3','45','06'),
        array('d0','2c','1e','8f','ca','3f','0f','02','c1','af','bd','03','01','13','8a','6b'),
        array('3a','91','11','41','4f','67','dc','ea','97','f2','cf','ce','f0','b4','e6','73'),
        array('96','ac','74','22','e7','ad','35','85','e2','f9','37','e8','1c','75','df','6e'),
        array('47','f1','1a','71','1d','29','c5','89','6f','b7','62','0e','aa','18','be','1b'),
        array('fc','56','3e','4b','c6','d2','79','20','9a','db','c0','fe','78','cd','5a','f4'),
        array('1f','dd','a8','33','88','07','c7','31','b1','12','10','59','27','80','ec','5f'),
        array('60','51','7f','a9','19','b5','4a','0d','2d','e5','7a','9f','93','c9','9c','ef'),
        array('a0','e0','3b','4d','ae','2a','f5','b0','c8','eb','bb','3c','83','53','99','61'),
        array('17','2b','04','7e','ba','77','d6','26','e1','69','14','63','55','21','0c','7d')
    );
    for($i=0;$i<4;$i++){
        for($j=0;$j<4;$j++){
            $val=$state[$i][$j];
            $val_arr=str_split($val);
            $state[$i][$j]=$s_box[hexdec($val_arr[0])][hexdec($val_arr[1])];
        }
    }
    $shift_row_dec=array(
        array('00','01','02','03'),
        array('13','10','11','12'),
        array('22','23','20','21'),
        array('31','32','33','30')
    );
    $tr_state=array(array(),array());
    for($i=0;$i<4;$i++){
    for($j=0;$j<4;$j++){
        $val=$shift_row_dec[$i][$j];
        $val_arr=str_split($val);
        $tr_state[$i][$j]=$state[$val_arr[0]][$val_arr[1]];
    }
    }
    
    $tr_state=transpose($tr_state);
    $state_one = array();
    foreach ($tr_state as $value) {
    $state_one = array_merge($state_one, $value);
    }
    $enc_hex_msg=implode($state_one);
    
    $string='';
    for ($i=0; $i < strlen($enc_hex_msg)-1; $i+=2){
        $string .= chr(hexdec($enc_hex_msg[$i].$enc_hex_msg[$i+1]));
    }
    $dec_msg=$dec_msg.$string;
    
}
echo $dec_msg;


?></pre>
</body>
</html>
