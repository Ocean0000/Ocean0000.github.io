<!DOCTYPE html>
<html>
<meta charset="utf-8">
<head>
	<title></title>
</head>
<body>
<?php
$ip = $_POST['ipdz'];
$ymcount = $_POST['zwym'];
echo "ip地址:$ip";
echo "子网掩码位数:$ymcount";
echo "</br>";
$ipshuzu = array(explode(".",$ip));
// echo decbin($ipshuzu[0][0]).decbin($ipshuzu[0][1]);
// echo "</br>";
// echo sprintf("%08d",decbin($ipshuzu[0][0]));
// echo "</br>";
// echo substr(decbin($ipshuzu[0][0]).decbin($ipshuzu[0][1]),0,$ymcount);
//var_dump($ip);
//var_dump($ipshuzu);
if ($ipshuzu[0][0] >= 1 && $ipshuzu[0][0] < 256 && $ipshuzu[0][1] >= 0 && $ipshuzu[0][1] < 256 && $ipshuzu[0][2] >= 0 && $ipshuzu[0][2] < 256 && $ipshuzu[0][3] >= 0 && $ipshuzu[0][3] < 256) {
	if ($ipshuzu[0][0] >= 1 && $ipshuzu[0][0] <= 127) {
		if ($ymcount > 7) {
			$counta = 8;
			echo "该IP地址正确，IP为A类网络</br>";
			$str1 = dobin($ipshuzu[0][0]);
			//var_dump ($str1);
			$str2 = dobin($ipshuzu[0][1]);
			$str3 = dobin($ipshuzu[0][2]);
			$str4 = dobin($ipshuzu[0][3]);
			$strings = buling($str1,$str2,$str3,$str4);
			//echo "$strings";
			$start = start($strings,$counta);
			$end = ende($strings,$ymcount);
			//var_dump($start);
			//var_dump($end);
			// echo bindec(substr($start . $end,16,8));
			// echo ".";
			// echo bindec(substr($start . $end,-8));
			zwjisuan ($ymcount,$counta,$start,$end);
		}else{
			echo "您输入的子网掩码位数不对，<a href='./form.php'>请返回重新输入</a>";
			//echo "<script>alert('\sdasd\');</script>";
		}
	}elseif ($ipshuzu[0][0] >= 128 && $ipshuzu[0][0] <= 191) {
		if($ymcount > 15){
			$countb = 16;
			echo "该IP地址正确，IP为B类网络</br>";
			$str1 = dobin($ipshuzu[0][0]);
			$str2 = dobin($ipshuzu[0][1]);
			$str3 = dobin($ipshuzu[0][2]);
			$str4 = dobin($ipshuzu[0][3]);
			$strings = buling($str1,$str2,$str3,$str4);
			$start = start($strings,$countb);
			$end = ende($strings,$ymcount);
			//var_dump($start);
			//var_dump($end);
			zwjisuan ($ymcount,$countb,$start,$end);
		}else{
			echo "您输入的子网掩码位数不对，<a href='./form.php'>请返回重新输入</a>";
			//echo "<script>alert('\sdasd\');</script>";
		}
	}elseif ($ipshuzu[0][0] >= 192 && $ipshuzu[0][0] <= 223) {
		if ($ymcount > 23) {
			$countc = 24;
			echo "该IP地址正确，IP为C类网络</br>";
			$str1 = dobin($ipshuzu[0][0]);
			//echo "$str1";
			$str2 = dobin($ipshuzu[0][1]);
			$str3 = dobin($ipshuzu[0][2]);
			$str4 = dobin($ipshuzu[0][3]);
			$strings = buling($str1,$str2,$str3,$str4);
			$start = start($strings,$countc);
			$end = ende($strings,$ymcount);
			//var_dump($start);
			//var_dump($end);
			zwjisuan ($ymcount,$countc,$start,$end);
		}else{
			echo "您输入的子网掩码位数不对，<a href='./form.php'>请返回重新输入</a>";
		}
	}else{
		echo "对不起，无法为您划分子网!<a href='./form.php'>请返回重新输入</a>";
	}

}else{
	// echo "</br>";
	echo "您输入的ip地址不正确!<a href='./form.php'>请返回重新输入</a>";
}
function buling ($s1,$s2,$s3,$s4)
{
	$s1 = sprintf("%08d",$s1);
	$s2 = sprintf("%08d",$s2);
	$s3 = sprintf("%08d",$s3);
	$s4 = sprintf("%08d",$s4);
	//echo "$s1";
	$string = $s1 . $s2 . $s3 . $s4;
	return $string;
}
function dobin ($s)
{
	$s = decbin($s);
	return $s;
}
// function jieqv ($str,$ym)
// {
// 	$start = substr($str,0,$ym);
// 	$end = substr($str,-(32-$ymc));
// 	return $start;
// 	return $end;
// }
function start ($str,$cuont)
{
	$start = substr($str,0,$cuont);
	return $start;
}
function ende ($str,$ymc)
{
	$end = substr($str,-(32-$ymc));
	return $end;
}
function zwjisuan ($ymcount,$count,$start,$end)
{	
	$endzero = "0";
	$endone = "1";
	$j = 32-$ymcount;
	$zhujishu = pow(2, $j);
	echo "每个子网的主机数：$zhujishu";
	echo "</br>";
	//$f = pow(2, $n)
	for ($i=0; $i < pow(2, $n); $i++) { 
		$n = $ymcount-$count;
		//echo "$n";
		//echo "$i";
		$f = decbin($i);
		//$sub = sprintf("%0$nd",$f);
		$sub = str_pad($f,$n,"0",STR_PAD_LEFT);
		//echo "$sub";
		$netid = $start . $sub . $end;
		$midzero = substr($end,0,(strlen($end)-1));
		$startid = $start . $sub . $midzero . $endone;
		$allone = str_replace("0", "1", $end);
		$midone = substr($allone,0,(strlen($allone)-1));
		$endid = $start . $sub . $midone . $endzero;
		$gbid = $start . $sub . $allone;
		$startid = goback($startid);
		$netid = goback($netid);
		$endid = goback($endid);
		$gbid = goback($gbid);
		$o = $i + 1;
		echo "</br>第 $o 个子网:</br>";
		echo "网络号  ： $netid </br>";
		echo "主机起始： $startid </br>";
		echo "主机结束： $endid </br>";
		echo "广播地址： $gbid </br>";
		echo "子网掩码：";gobackym($ymcount);
		echo "<br/>";
	}
}
function goback ($string)
{
	$str1 = bindec(substr($string,0,8));
	$str2 = bindec(substr($string,8,8));
	$str3 = bindec(substr($string,16,8));
	$str4 = bindec(substr($string,-8));
	$string = $str1 . "." . $str2 . "." . $str3 . "." . $str4;
	return $string;
}
function gobackym($ymcount)
{	
	//$count = $ymcount-1;
	$c = 1;
	$backym = str_pad($c,$ymcount,"1",STR_PAD_LEFT);
	$backym = str_pad($backym,32,"0",STR_PAD_RIGHT);
	$backym = goback($backym);
	echo "$backym";
	return $backym;
}
?>
</body>
</html>