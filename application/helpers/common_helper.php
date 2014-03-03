<?php
/**
* The following functions are used by many classes, therefore the name common helpers
*/

function encrypt_password($password)
{
	$salt = 'MT_sillystring_as_sal';
	if(CRYPT_SHA512 == 1)
	{
		return substr(crypt($password, '$6$rounds=10000$'.$salt.'$'),33);
	}
	if (CRYPT_SHA256 == 1)
	{
	    return substr(crypt($password, '$5$rounds=10000$'.$salt.'$'),33);
	}
	if (CRYPT_MD5 == 1)
	{
	    return substr(crypt($password, '$1$'.$salt.'$'),12);
	}

	return false;
}

function get_full_name($arr)
{
	$fullname = '';
	if(isset($arr->first_name)) $fullname .= $arr->first_name;
	if(isset($arr->last_name)) $fullname .= " ". $arr->last_name;
	return trim($fullname);
}

function readable_date($date, &$lang, $short = FALSE)
{
	if($lang == '')
	{
		$lang = array('date_today' => 'Idag', 'date_yesterday' => 'Igår');
	}

	$theDate = new DateTime($date);
	$today = new DateTime(date("Y-m-d 24:00:00"));
	$interval = $theDate->diff($today);
	$n = $interval->format("%d"); // get total number of days that differ (always positive number)

	$string = '';
	if($short)
	{
		switch($n)
		{
			case 0:
				$string = $theDate->format('H:i');
				break;
			case 1:
				$string = $lang['date_yesterday'];
				break;
			default:
				$string = $theDate->format('Y-m-d');
				break;
		}
	} else {
		switch($n)
		{
			case 0:
				$string = $lang['date_today'] . " " . $theDate->format('H:i');
				break;
			case 1:
				$string = $lang['date_yesterday'] . " " . $theDate->format('H:i');
				break;
			default:
				$string = $theDate->format('Y-m-d H:i');
				break;
		}
	}

	return $string;
}

function compact_name($name)
{
	$string = strtolower($name);
	$string = preg_replace("/(å|ä)/","a",$string);
	$string = preg_replace("/(ö)/","o",$string);
	return preg_replace("/[^A-Za-z0-9_]/","_",strtolower($string));
}

function uncompact_name($name)
{
	$string = preg_replace("/^_*/", "", $name);
	$string = preg_replace("/_*$/", "", $string);
	$string = preg_replace("/[_]+/i", ".{1}", $string);
	$string = preg_replace("/a/i", "(a|å|ä){1}", $string);
	return preg_replace("/o/i", "(o|ö){1}", $string);
}

function _local_linker($matches)
{
	$c = count($matches);
	if($c > 2)
		return anchor($matches[1],$matches[2]);
	return "";
}

function _img_format($matches)
{
	$id = "";
	$w = 130;
	$h = 75;
	$align = "";

	$settings_array = explode(" ", trim($matches[1]));

	for ($i=0; $i < count($settings_array); $i++) {
		$setting = explode("=",$settings_array[$i],2);
		switch(strtolower($setting[0]))
		{
			case "id":
			case "filename":
			case "file":
			case "original":
				if(strlen($setting[1]) >0)
				{
					$id = $setting[1];
				}
				break;
			case "w":
				if(is_numeric($setting[1]) && $setting[1] >0)
				{
					$w = $setting[1];
				}
				break;
			case "h":
				if(is_numeric($setting[1]) && $setting[1] >0)
					$h = $setting[1];
				break;
			case "align":
				if(strtolower($setting[1]) == "left" || strtolower($setting[1]) == "right")
					$align = 'align="'.$setting[1].'"';
				break;
		}
	}

	// error check
	if ($id == "")
	{
		$im = new imagemanip("unknown", 'zoom', $w, $h);
	} else {
		$im = new imagemanip($id, 'zoom', $w, $h);
	}


	return $im->get_img_tag($align);
}

function text_strip($input, $line_break = FALSE)
{
	// remove all html attempts
	$text = preg_replace('/</','&lt;', $input);
	$text = preg_replace('/>/','&gt;', $text);

	//\r\n, \n\r, \n and \r
	$patterns = array("/\r\n/", "/\n\r/", "/\r/", "/\n/");
	$replacements = '';
	if($line_break)
	{
		$replacements = array("\n","\n","\n","\n");
	}
	$text = preg_replace($patterns,$replacements, $text);

	return $text;
}

function text_format($input, $pre = '<p>', $post = '</p>', $xtravaganza = TRUE)
{
	$text = text_strip($input, TRUE);

	//wrap with paragraph
	//$text = $pre.$text.$post;
	//$text = preg_replace("/(^|\n)((?!#+).*[a-zA-Z_åäöÅÄÖ0-9]+.*)\n/","\n".$pre."$2".$post."\n", $text);

	$text = preg_replace("/(\[br\]\n?)/","<br/>", $text);
	$text = preg_replace("/(^|\n)((?!#+).*[a-zA-Z_åäöÅÄÖ0-9].*)(\n|$)/","\n".$pre."$2".$post."\n", $text);

	// bold and italics
	$text = preg_replace('/\[b\](.*)\[\/b\]/','<b>${1}</b>', $text);
	$text = preg_replace('/\[i\](.*)\[\/i\]/','<i>${1}</i>', $text);

	if($xtravaganza === TRUE)
	{
		// URL
		$text = preg_replace('@(https?://([-\w\.]+)+(:\d+)?(/([\w/_\.]*(\?\S+)?)?)?)@', '<a href="$1">$1</a>', $text);

		$text = preg_replace_callback("/\(([a-zA-Z\/]+)\|([a-zA-Z\s]+)\)/",'_local_linker',$text);

		// headlines
		$text = preg_replace("/(\n####)([a-zA-Z_åäöÅÄÖ0-9\s\_\-&]+)(\n)/","\n<h4>$2</h4>\n",$text);
		$text = preg_replace("/(\n###)([a-zA-Z_åäöÅÄÖ0-9\s\_\-&]+)(\n)/","\n<h3>$2</h3>\n",$text);
		$text = preg_replace("/(\n##)([a-zA-Z_åäöÅÄÖ0-9\s\_\-&]+)(\n)/","\n<h2>$2</h2>\n",$text);
		$text = preg_replace("/(\n#)([a-zA-Z_åäöÅÄÖ0-9\s\_\-&]+)(\n)/","\n<h1>$2</h1>\n",$text);

		$text = preg_replace_callback('/\[img((?:\s+[a-zA-Z]+=[a-zA-Z0-9\_]+)*)\s*\]/','_img_format', $text);
	} else {
		$text = preg_replace('/\[img[a-zA-Z0-9\_=\s]*\]/','', $text);
	}


	return auto_link($text);

}

function news_size_to_class($size)
{
	switch($size)
	{
		case 1:
			return "oneThird";
		case 2:
			return "oneHalf";
		case 3:
			return "twoThirds";
		default:
			return "";

	}
}
function news_size_to_class_invert($size)
{
	switch($size)
	{
		case 1:
			return "twoThirds";
		case 2:
			return "oneHalf";
		case 3:
			return "oneThird";
		default:
			return "";

	}
}
function news_size_to_px($size)
{
	switch($size)
	{
		case 1:
			return 250;
		case 2:
			return 375;
		case 3:
			return 500;
		case 4:
			return 750;
		default:
			return "";

	}
}

function lang_id_to_imgpath($id)
{
	switch($id)
	{
		case 1:
			return base_url().'web/img/flags/se_big.png';
		case 2:
			return base_url().'web/img/flags/gb_big.png';
		default:
			return "";

	}
}

function news_excerpt($cont, $length = 200)
{
	$cont_notags = strip_tags($cont);
	if(strlen($cont_notags) > $length)
	{
		$sub_excerpt = substr($cont_notags, 0, $length-5);
		$excerpt_words = explode(' ', $sub_excerpt);
		$excerpt_cut = -(strlen($excerpt_words[count($excerpt_words)-1]));

		if($excerpt_cut < 0)
			$cont_notags = substr($sub_excerpt, 0, $excerpt_cut);
		else
			$cont_notags = $sub_excerpt;
	}

	return $cont_notags;
}

/**
 * Better GI than print_r or var_dump -- but, unlike var_dump, you can only dump one variable.
 * Added htmlentities on the var content before echo, so you see what is really there, and not the mark-up.
 *
 * Also, now the output is encased within a div block that sets the background color, font style, and left-justifies it
 * so it is not at the mercy of ambient styles.
 *
 * Inspired from:     PHP.net Contributions
 * Stolen from:       [highstrike at gmail dot com]
 * Modified by:       stlawson *AT* JoyfulEarthTech *DOT* com
 *
 * @param mixed $var  -- variable to dump
 * @param string $var_name  -- name of variable (optional) -- displayed in printout making it easier to sort out what variable is what in a complex output
 * @param string $indent -- used by internal recursive call (no known external value)
 * @param unknown_type $reference -- used by internal recursive call (no known external value)
 */
function do_dump(&$var, $var_name = NULL, $indent = NULL, $reference = NULL)
{
    $do_dump_indent = "<span style='color:#666666;'>|</span> &nbsp;&nbsp; ";
    $reference = $reference.$var_name;
    $keyvar = 'the_do_dump_recursion_protection_scheme'; $keyname = 'referenced_object_name';

    // So this is always visible and always left justified and readable
    echo "<div style='text-align:left; background-color:white; font: 100% monospace; color:black;'>";

    if (is_array($var) && isset($var[$keyvar]))
    {
        $real_var = &$var[$keyvar];
        $real_name = &$var[$keyname];
        $type = ucfirst(gettype($real_var));
        echo "$indent$var_name <span style='color:#666666'>$type</span> = <span style='color:#e87800;'>&amp;$real_name</span><br>";
    }
    else
    {
        $var = array($keyvar => $var, $keyname => $reference);
        $avar = &$var[$keyvar];

        $type = ucfirst(gettype($avar));
        if($type == "String") $type_color = "<span style='color:green'>";
        elseif($type == "Integer") $type_color = "<span style='color:red'>";
        elseif($type == "Double"){ $type_color = "<span style='color:#0099c5'>"; $type = "Float"; }
        elseif($type == "Boolean") $type_color = "<span style='color:#92008d'>";
        elseif($type == "NULL") $type_color = "<span style='color:black'>";

        if(is_array($avar))
        {
            $count = count($avar);
            echo "$indent" . ($var_name ? "$var_name => ":"") . "<span style='color:#666666'>$type ($count)</span><br>$indent(<br>";
            $keys = array_keys($avar);
            foreach($keys as $name)
            {
                $value = &$avar[$name];
                do_dump($value, "['$name']", $indent.$do_dump_indent, $reference);
            }
            echo "$indent)<br>";
        }
        elseif(is_object($avar))
        {
            echo "$indent$var_name <span style='color:#666666'>$type</span><br>$indent(<br>";
            foreach($avar as $name=>$value) do_dump($value, "$name", $indent.$do_dump_indent, $reference);
            echo "$indent)<br>";
        }
        elseif(is_int($avar)) echo "$indent$var_name = <span style='color:#666666'>$type(".strlen($avar).")</span> $type_color".htmlentities($avar)."</span><br>";
        elseif(is_string($avar)) echo "$indent$var_name = <span style='color:#666666'>$type(".strlen($avar).")</span> $type_color\"".htmlentities($avar)."\"</span><br>";
        elseif(is_float($avar)) echo "$indent$var_name = <span style='color:#666666'>$type(".strlen($avar).")</span> $type_color".htmlentities($avar)."</span><br>";
        elseif(is_bool($avar)) echo "$indent$var_name = <span style='color:#666666'>$type(".strlen($avar).")</span> $type_color".($avar == 1 ? "TRUE":"FALSE")."</span><br>";
        elseif(is_null($avar)) echo "$indent$var_name = <span style='color:#666666'>$type(".strlen($avar).")</span> {$type_color}NULL</span><br>";
        else echo "$indent$var_name = <span style='color:#666666'>$type(".strlen($avar).")</span> ".htmlentities($avar)."<br>";

        $var = $var[$keyvar];
    }

    echo "</div>";
}

/**
 * Check url
 * @param 	string 	$url 	the url to be checked
 * @return 	bool
 */
function valid_url($url = '')
{
	$regex = "!/(?i)\b((?:https?:\/\/|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}\/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:'\".,<>?«»“”‘’]))/";
	return preg_match($regex, $url);
}

/**
 * Return gravatar img
 * @param 	string/obj 	$user 		the user
 * @param 	int 	$size 			size of image [1, 2048]
 * @param 	string 	$extra 			any desired extra html
 * @param 	string 	$fallback 		gravatar fallback url
 * @param 	bool 	$img 			if you want a img-tag
 * @return 	string 					the desired link, styled and everything
 */
function gravatarimg($theuser, $size = 80, $extra = '', $fallback = 'mm', $img = true)
{
	if(empty($theuser) || is_string($theuser))
		$user = $theuser;
	else
		$user = $theuser->gravatar;

	$return = 'http://www.gravatar.com/avatar/'.md5($user).'?s='.$size.'&d='.$fallback;

	if($img)
		return '<img src="'.$return.'" '.$extra.'/>';

	return $return;
}
