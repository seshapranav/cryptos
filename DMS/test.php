<?php
$plaintext='Math';
$light_yellow=['a'=>1,'b'=>2,'c'=>3,'d'=>4,'e'=>5,'f'=>6,'g'=>7];
$dark_yellow=['h'=>1,'i'=>2,'j'=>3,'k'=>4,'l'=>5,'m'=>6];
$light_red=['n'=>1,'o'=>2,'p'=>3,'q'=>4,'r'=>5,'s'=>6,'t'=>7];
$dark_red=['u'=>1,'v'=>2,'w'=>3,'x'=>4,'y'=>5,'z'=>6];

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
for($i=0;$i<$size;$i++){
  $enc_pt_char=str_split($enc_pt7[$i]);
  $s_dec_pt_char=array();
  for($j=0;$j<7;$j++){$s_dec_pt_char[$j]=$enc_pt_char[$dec_permutation[$j]-1];}
  $dec_pt7[$i]= implode($s_dec_pt_char);
}
$dec_pt=implode($dec_pt7);
$dec_pt=substr($dec_pt,0,(7*$size)-$zeroes);
$key2=str_split($key,2);
$pt='';
$dec_pt1=str_split($dec_pt);
for($i=0;$i<strlen($dec_pt);$i++){
  if($key2[$i]=='ly'||$key2[$i]=='lr'||$key2[$i]=='lg'||$key2[$i]=='lb'){$num=(intval($dec_pt1[$i])+1)%7;if($num==0)$num+=7;}
  if($key2[$i]=='dy'||$key2[$i]=='dr'||$key2[$i]=='dg'||$key2[$i]=='db'){$num=(intval($dec_pt1[$i])+1)%6;if($num==0)$num+=6;}
  if($key2[$i]=='ly'){$pt=$pt.$light_yellow[$num-1];}
  if($key2[$i]=='lr'){$pt=$pt.$light_red[$num-1];}
  if($key2[$i]=='lg'){$pt=$pt.$light_green[$num-1];}
  if($key2[$i]=='lb'){$pt=$pt.$light_blue[$num-1];}
  if($key2[$i]=='dy'){$pt=$pt.$dark_yellow[$num-1];}
  if($key2[$i]=='dr'){$pt=$pt.$dark_red[$num-1];}
  if($key2[$i]=='dg'){$pt=$pt.$dark_green[$num-1];}
  if($key2[$i]=='db'){$pt=$pt.$dark_blue[$num-1];}
}
echo $pt;
?>