<?php
$permutation=array(58,50,42,34,26,18,10,02,60,52,
  44,36,28,20,12,04,62,54,46,38,
  30,22,14,06,64,56,48,40,32,24,16,8,
  57,49,41,33,25,17,9,01,59,51,43,35,
  27,19,11,03,61,53,45,37,29,21,13,05,
  63,55,47,39,31,23,15,07);
  $binary_msg="";
  $msg='hello';
  $msg_c=str_split($msg);

  foreach($msg_c as $k=>$i){
    $value = unpack('H*', $i);
    $bin_msg_c=base_convert($value[1], 16, 2);
    while(strlen($bin_msg_c)<8){$bin_msg_c='0'.$bin_msg_c;}
    $binary_msg=$binary_msg.$bin_msg_c;  
  }

  while(strlen($binary_msg) % 64 !=0){$binary_msg=$binary_msg.'0';}
  $size= strlen($binary_msg)/64;
  $binary_msg_64=str_split($binary_msg,64);
  $enc_binary_msg_64=array();
  for($i=0;$i<$size;$i++){
    $binary_msg_char=str_split($binary_msg_64[$i]);
    
    $enc_binary_msg_char=array();
    for($j=0;$j<64;$j++){$enc_binary_msg_char[$j]=$binary_msg_char[$permutation[$j]-1];}
    $enc_binary_msg_64[$i]=implode($enc_binary_msg_char);
  }
  $enc_bin_msg=implode($enc_binary_msg_64);
  echo $enc_bin_msg;
  ?>