$permutation=array(58,50,42,34,26,18,10,02,60,52,
  44,36,28,20,12,04,62,54,46,38,
  30,22,14,06,64,56,48,40,32,24,16,8,
  57,49,41,33,25,17,9,01,59,51,43,35,
  27,19,11,03,61,53,45,37,29,21,13,05,
  63,55,47,39,31,23,15,07);
  $binary_msg="";
  $msg=$_POST['message'];
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
  $p_enc_bin_msg=implode($enc_binary_msg_64);
  $p_enc_msg=pack('H*', base_convert($p_enc_bin_msg, 2, 16));





























  $dec_bin_msg= pack('H*',base_convert($enc_hex_msg, 16, 2));
          echo $enc_hex_msg."\n\n";
          echo $dec_bin_msg."\n\n";
          


            $msg=$dec_bin_msg;
            while($msg%64!=0){$msg=$msg+'0';}
            $depermutation=array(40,8,48,16,56,24,64,32,39,7,
            47,15,55,23,63,31,38,6,46,14,
            54,22,62,30,37,5,45,13,53,21,61,
            29,36,4,44,12,52,20,60,28,35,
            3,43,11,51,19,59,27,34,2,42,10,
            50,18,58,26,33,1,41,9,49,17,57,25);
            $size=strlen($msg)/64;
            $msg_64=str_split($msg,64);
            $dec_msg_64=array();
            for($i=0;$i<$size;$i++){
              $msg_char=str_split($msg_64[$i]);
              $dec_msg_char=array();
              for($j=0;$j<64;$j++){$dec_msg_char[$j]=$msg_char[$depermutation[$j]-1];}
              $dec_msg_64[$i]=implode($dec_msg_char);
            }
            $dec_bin_msg=implode($dec_msg_64);
            $bin_8=str_split($dec_bin_msg,8);$dec_msg='';
            for($i=0;$i<strlen($dec_bin_msg)/8;$i++){
              $dec_msg=$dec_msg.pack('H*',base_convert($bin_8[$i],2,16));
            }