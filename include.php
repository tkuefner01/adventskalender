<?

class connection
	{
	var $host,$user,$password,$database, $link;

	function connection ()
		{
		include("config.php");
		$this->host = $db['host'];
		$this->user = $db['user'];
		$this->password = $db['password'];
		$this->database = $db['database'];
		$link = @mysql_connect ($this->host,$this->user,$this->password) or die("Could not connect: ".mysql_error());
		@mysql_select_db($this->database,$link) or die(mysql_error());
		$this->link=$link;
		}

	function query ($querystring)
		{
		$result = mysql_query($querystring,$this->link) or die("error in query: ".mysql_error());
		return $result;
		}

	function sanitize ($array)
		{
		if(count($array)>1)
		{
		foreach($array as $key)
			{
			$key = mysql_real_escape_string($key,$this->link);
			$key = trim($key);
			$key = strip_tags($key);
			}
		}
		else
		{
			$array = mysql_real_escape_string($array,$this->link);
			$array = trim($array);
			$array = strip_tags($array);
		}
		return $array;
		}

	function insertuser ($newuser) // $newuser = array('name','password','email');
		{
			$newuser = $this->sanitize($newuser);
			if(empty($newuser['name'])) return false;
			if(empty($newuser['email'])) return false;
			if(empty($newuser['password'])) return false;
			if($newuser['level'] == "") return false;
			$this->query("INSERT INTO lions_user (name,password,email,login) VALUES ('".$newuser['name']."','".md5($newuser['password'])."','".$newuser['email']."','".$newuser['level']."')");
			return true;
		}
	function updateuser ($updateuser)
		{
			/*echo "<pre>";
			print_r($updateuser);
			echo "</pre>";*/
			$updateuser = $this->sanitize($updateuser);
			if(empty($updateuser['name'])){ echo "name"; return false;}
			if(empty($updateuser['email'])){ echo "email"; return false;}
			if($updateuser['level']=="" OR !preg_match("#^\d+$#",$updateuser['level']) ){ echo "level"; return false;}
			if(empty($updateuser['id'])){ echo "id"; return false;}
			
			$sql="UPDATE lions_user SET ";
			$sql.="name='".$updateuser['name']."'";
			if(!empty($newuser['password']))
				{
					$sql.=",password='".md5($newuser['password'])."'";
				}
			$sql.=", email='".$updateuser['email']."' ";
			$sql.=", login='".$updateuser['level']."' ";
			$sql.=", vorname='".$updateuser['vorname']."' ";
			$sql.=", nachname='".$updateuser['nachname']."' ";
			$sql.=", geburtstag='".$updateuser['geburtstag']."' ";
			$sql.=", titel='".$updateuser['titel']."' ";
			$sql.=", gattin='".$updateuser['gattin']."' ";
			$sql.=", eintritt='".$updateuser['eintritt']."' ";
			$sql.=", strasse='".$updateuser['strasse']."' ";
			$sql.=", ort='".$updateuser['ort']."' ";
			$sql.=", telprivat='".$updateuser['telprivat']."' ";
			$sql.=", teldienst='".$updateuser['teldienst']."' ";
			$sql.=", telmobil='".$updateuser['telmobil']."' ";
			$sql.=", telfax='".$updateuser['telfax']."' ";
			$sql.="WHERE id='".$updateuser['id']."'";
			$this->query($sql,$this->link);
			return true;
		}
	
	function updatetime()
		{
			# // Update zeit in user
			$sql = "UPDATE lions_user SET zeit=now() WHERE id='".$_COOKIE['userid']."'";
			if($this->loggedin()) $this->query($sql); else "AUSGELOGGT!";
			echo mysql_error();
		}
	function getlevels()
		{
			$result = $this->query("SELECT * FROM lions_level");
			for($i=0;$i<mysql_num_rows($result);$i++)
				{
					$array[$i]=mysql_fetch_array($result);
				}
			return $array;
		}
	function getlevelname ($level)
		{
			if($level == "") return false;
			$sql = "SELECT name FROM lions_level WHERE level='".$level."'";
			$array = mysql_fetch_array($this->query($sql));
			return $array['name'];
		}
	function getuserdata($user,$password="")
		{
			if(empty($user)) return false;
			$user=$this->sanitize($user);
			$password=$this->sanitize($password);
			$sql="SELECT *,(UNIX_TIMESTAMP()-UNIX_TIMESTAMP(zeit)) as time FROM lions_user WHERE ";
			if(preg_match("#^\d+$#",$user))		// Wenn $user eine Zahl ist ... 
				{
				#echo "Eine Zahl wurde übergeben";
				$sql.="id='".$user."'";
				}
			else
				{
				#echo "Ein String wurde übergeben";
				$sql.="name='".$user."'";
				}
				#echo "<br>".$sql."<br>";
			if(empty($password))
				{
					$result = mysql_query($sql, $this->link);
				}
			elseif(!empty($password))
				{
					$sql.=" AND password='".md5($password)."'";
					$result = mysql_query($sql, $this->link);
				}
			#echo $sql;
			if(mysql_num_rows($result) != 1){echo mysql_error();return false;}
			return mysql_fetch_array($result);
		}
	function loggedin()
		{	
			if(empty($_COOKIE['sid'])) return false;
			$user = $this->getuserdata($_COOKIE['userid']);
			if($user['kennung'] == $_COOKIE['sid'])
				{
					include("config.php");
					$time=$user['time']/60;
					if($user['time']/60 < $idle)
						{
							return true;
						}
					else
						{
							return false;
						}	
				}
			else
				{
					// Kennung und sid passen nicht zueinander
					return false;
				}
			
		}
	function user($feld="")
		{
			if($this->loggedin())
				{
					$user=$this->getuserdata($_COOKIE['userid']);
					if(empty($feld))
						{
							return $user;
						}
					else
						{
							return $user[$feld];
						}
				}
		}
	function userexist ($name)
		{
			$name = $this->sanitize($name);
			if(mysql_num_rows($this->query("SELECT name FROM lions_user WHERE name='".$name."'"))>0)
			{
			 return true;
			}
			else
			{
			 return false;
			}
		}
	function zugang($level=1)
		{
			Global $level;
			if($this->loggedin())
				{
					//$user=$this->getuserdata($_COOKIE['userid']);
					if($this->user("login")>=$level)
						{
							$allow = true;
						}
					else
						{
							$allow = false;
						}
				}
			else
				{
					$allow = false;
				}

			if(!$allow)
				{
					echo "Sie haben kein Recht diese Seite anzusehen!";
					include("unten.php");
					die();
				}
			
		}
}

function button ($text,$script)
	{
		$button = "button.php?text=".$text;
		if(!is_array($script))
			{
				$array[0]=$script;
			}
		else
			{
				$array=$script;
			}
		foreach($array as $key)
			{
			if($_SERVER["SCRIPT_NAME"] == dirname($_SERVER["SCRIPT_NAME"])."/".$key.".php")
				{
					$button.= "&type=active";
				}
			}
		return $button;
	}

function check_email($email) {
  // RegEx begin
  $nonascii      = "\x80-\xff"; # Non-ASCII-Chars are not allowed

  $nqtext        = "[^\\\\$nonascii\015\012\"]";
  $qchar         = "\\\\[^$nonascii]";

  $protocol      = '(?:mailto:)';

  $normuser      = '[a-zA-Z0-9][a-zA-Z0-9_.-]*';
  $quotedstring  = "\"(?:$nqtext|$qchar)+\"";
  $user_part     = "(?:$normuser|$quotedstring)";

  $dom_mainpart  = '[a-zA-Z0-9][a-zA-Z0-9._-]*\\.';
  $dom_subpart   = '(?:[a-zA-Z0-9][a-zA-Z0-9._-]*\\.)*';
  $dom_tldpart   = '[a-zA-Z]{2,5}';
  $domain_part   = "$dom_subpart$dom_mainpart$dom_tldpart";

  $regex         = "$protocol?$user_part\@$domain_part";
  // RegEx end

  return preg_match("/^$regex$/",$email);
}

function saveimage($files)
	{
		include("config.php");
		$dateiname = uniqid("");
		switch($files['datei']['type'])
			{
			case "image/jpeg":
			case "image/pjpeg":
			$dateiname.=".jpg";
			break;
			case "image/png":
			$dateiname.=".png";
			break;
			case "image/gif":
			$dateiname.=".gif";
			break;
			default:
			echo "<b>".$files['datei']['type']."</b>";
			break; 
			}

		move_uploaded_file($_FILES['datei']['tmp_name'], "upload/".$dateiname);
		chmod ("upload/".$dateiname, 0755);
		
		switch($files['datei']['type'])
			{
			case "image/jpeg":
			case "image/pjpeg":
			$bildalt = imagecreatefromjpeg("upload/".$dateiname);
			break;
			case "image/png":
			$bildalt = imagecreatefrompng("upload/".$dateiname);
			break;
			case "image/gif":
			$bildalt = imagecreatefromgif("upload/".$dateiname);
			break;
			}

		$info = @getimagesize("upload/".$dateiname);
		$breitalt = $info[0];
		$hochalt = $info[1];
		$breit = $config['thumb_width'];
		$hoch = ceil($hochalt*$breit/$breitalt);
		$bildneu = imagecreatetruecolor($breit, $hoch);
		imagecopyresized($bildneu, $bildalt, 0, 0, 0, 0, $breit, $hoch, $breitalt, $hochalt);
		
		switch($files['datei']['type'])
			{
			case "image/jpeg":
			case "image/pjpeg":
			imagejpeg($bildneu,"upload/thumb_".$dateiname);
			break;
			case "image/png":
			imagepng($bildneu,"upload/thumb_".$dateiname);
			break;
			case "image/gif":
			imagegif($bildneu,"upload/thumb_".$dateiname);
			break;
			}
		if(file_exists("upload/thumb_".$dateiname) && file_exists("upload/".$dateiname))
			{
				return $dateiname;
			}
	}

function savepdf($files)
	{
		$dateiname = uniqid("").".pdf";
		move_uploaded_file($files['datei']['tmp_name'], "upload/pdf/".$dateiname);
		chmod ("upload/pdf/".$dateiname, 0755);
		if(file_exists("upload/pdf/".$dateiname))
			{
				return $dateiname;
			}
	}
?>