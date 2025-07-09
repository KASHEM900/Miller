<?php

namespace App;

class BanglaConverter {
    public static $bn = array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
    public static $en = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");

    public static function bn2en($number) {
        return str_replace(self::$bn, self::$en, $number);
    }

    public static function en2bn($digit, $number) {
        return str_replace(self::$en, self::$bn, number_format($number, $digit));
    }

    public static function en2bt($number) {
        return str_replace(self::$en, self::$bn, $number);
    }

    public static function getNumToEn($age)
	{
		$nstr = (string)$age;
		$rage = "";
		$pos = 0;
		$j = (int)strlen($nstr)/3;

		for($i=0;$i<$j;$i++){
			$b = mb_substr($nstr,$pos,1,'UTF-8');

			if ($b == "."){
				$a = $b;
			}
			else {
		   		$a=BanglaConverter::getNumVal(mb_substr($nstr,$pos,1,'UTF-8'));
			}

		   	$rage = $rage . $a;
			$pos = $pos + 1;
		}

		return (float)$rage;
	}

	public static function getNumVal($num)
	{
		$rnum = "";
		if (strlen($num)==3){
            if ($num=="১"){
				$rnum = "1";
			} else if ($num=="২"){
				$rnum = "2";
			} else if ($num=="৩"){
				$rnum = "3";
			} else if ($num=="৪"){
				$rnum = "4";
			} else if ($num=="৫"){
				$rnum = "5";
			} else if ($num=="৬"){
				$rnum = "6";
			} else if ($num=="৭"){
				$rnum = "7";
			} else if ($num=="৮"){
				$rnum = "8";
			} else if ($num=="৯"){
				$rnum = "9";
			} else if ($num=="০"){
				$rnum = "0";
			}
		}

		return $rnum;
	}
}
