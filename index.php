<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Untitled Document</title>
 <style type="text/css">
     
h1 {color:black;}

h2 {color:black;}
  a:link, a:visited {
    background-color: #f44336;
    color: white;
    padding: 14px 25px;
    text-align: center; 
    text-decoration: none;
    display: inline-block;
}

a:hover, a:active {
  background-color: red;
}
   body {background-color: blanchedalmond;}
    
   </style><br />

 </head>
</head>

<body>
<?php  
define("korisnici", "korisnici.txt");
define("potraznja", "potraznja.txt");



if(isset($_GET['a'])) { $a = $_GET['a']; } else { $a = ''; }

switch($a)
{
 case 'default': default_stranica(); break;
 
 case 'register': register(); break;
 case 'registerP': registerP(); break;
 case 'prijavljivanje_stranica': prijavljivanje_stranica(); break;
 case 'prijavljivanje': prijavljivanje(); break;
 case 'odabir_jezika': odabir_jezika(); break;
 case 'upload': upload(); break;

default: default_stranica();
} 


function upload(){
	if(isset($_FILES['image'])){
      $errors= array();
      $file_name = $_FILES['image']['name'];
      $file_size =$_FILES['image']['size'];
      $file_tmp =$_FILES['image']['tmp_name'];
      $file_type=$_FILES['image']['type'];
      $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));
      
      $extensions= array("jpeg","jpg","png");
      
      if(in_array($file_ext,$extensions)=== false){
         $errors[]="extension not allowed, please choose a JPEG or PNG file.";
      }
      
      if($file_size > 2097152){
         $errors[]='File size must be excately 2 MB';
      }
      
      if(empty($errors)==true){
         move_uploaded_file($file_tmp,"images/".$file_name);
         echo "Success";
      }else{
         print_r($errors);
      }
   }
}

function default_stranica(){    
echo '<form id="first_page" name="first_page" method="post" action="">
  <h1>APLIKACIJA GET A FLAT:</h1> 
  
</form>';

echo '<h2> Izrada računa: </h2>';
echo '<p> <a href="?a=register"> IZRADA RAČUNA KUPAC</a> </p>';
echo '<p> <a href="?a=registerP"> IZRADA RAČUNA PRODAVAČ</a> </p>';
echo '<h2> Već registrirani korisnici </h2>';
echo '<p> <a href="?a=prijavljivanje_stranica"> PRIJAVI SE </a> </p>';
echo  '<p><a href="https://pretinac.gov.hr/KorisnickiPretinac/eGradani.html">e-Građani</a></p>';
    
}

function register(){
    
if(!$_POST){
    
echo '<form name="form2" method="post" action="?a=register">
  <p>Ime:<br> 
    <input name="ime" type="text" id="ime">
  </p>
  <p>Prezime:<br> 
    <input name="prezime" type="text" id="prezime">
  </p>
  <p>Kontakt broj:<br> 
    <input name="broj" type="text" id="broj">
  </p>
  <p>Korisnicko ime:<br> 
    <input name="username" type="text" id="username">
  </p>
  <p>Password:<br> 
    <input name="password" type="password" id="password">
  </p>
  <p>Ponovi password:<br> 
    <input name="ppassword" type="password" id="ppassword">
  </p>
  <p>Email<br>
    <input name="email" type="text" id="email">
  </p>
        <p>Spol: 
          <input type="radio" name="spol" value="Z">
          Ženski 
          <input type="radio" name="spol" value="M">
          Muški</p>
      
        <p>Opis nekretnine kakvu tražite: <br> 
          <textarea name="poruka" id="poruka"></textarea>
        </p>
        <p> 
          <input type="submit" name="Submit2" value="Registracija">
          <input name="skriveno" type="hidden" id="skriveno" value="1">
        </p>
</form>';
}else{
$fine = true; 

$message = array();
$ime = $_POST['ime'];
$prezime = $_POST['prezime'];
$broj = $_POST['broj'];											
$username = $_POST['username'];
$pass1 = $_POST['password'];
$pass2 = $_POST['ppassword'];
if($pass1!==$pass2) { $fine = false; $message[]='Passwordi nisu jednaki'; }

$email = $_POST['email'];

if(isset($_POST['spol'])) {
 $spol = $_POST['spol'];
 if($spol=='M') { $message[]='Spol: muski'; }
 elseif($spol=='Z') { $message[]='Spol: zenski'; }
 else { $fine=false; $message[]='Spol: greska'; }
}
else { $fine=false; $message[]='Nije odabran spol';}
$poruka = $_POST['poruka'];

if($fine)
{ 
$redak = $username."\t".$broj."\t".$pass1."\t".$email."\t".$spol."\t".$poruka."\n";
$fh = fopen(korisnici,'a');
flock($fh,LOCK_EX);
fwrite($fh,$redak);
flock($fh,LOCK_UN);
fclose($fh);

$potraznja = $poruka."\n";
$fh = fopen(potraznja,'a');
flock($fh,LOCK_EX);
fwrite($fh,$potraznja);
flock($fh,LOCK_UN);
fclose($fh);
}

else { 
    
foreach($message as $p){ echo $p.'<br>';} } 
echo '<p> PRIJAVA ZA KOMUNIKACIJU S AGENTOM: </p>'; 
echo '<p> <a href="?a=odabir_jezika">PRIJAVA</a> </p>';

}
}

function registerP(){
    
if(!$_POST){
    
echo '<form name="form2" method="post" action="?a=registerP">
  <p>Ime:<br> 
    <input name="ime" type="text" id="ime">
  </p>
  <p>Prezime:<br> 
    <input name="prezime" type="text" id="prezime">
  </p>
  <p>Kontakt broj:<br> 
    <input name="broj" type="text" id="broj">
  </p>
  <p>Korisnicko ime:<br> 
    <input name="username" type="text" id="username">
  </p>
  <p>Password:<br> 
    <input name="password" type="password" id="password">
  </p>
  <p>Ponovi password:<br> 
    <input name="ppassword" type="password" id="ppassword">
  </p>
  <p>Email<br>
    <input name="email" type="text" id="email">
  </p>
        <p>Spol: 
          <input type="radio" name="spol" value="Z">
          Ženski 
          <input type="radio" name="spol" value="M">
          Muški</p>
      
        <p>Opis nekretnine koju prodajem: <br> 
          <textarea name="poruka" id="poruka"></textarea>
        </p>
		<br>
		
		
		
		<p>DOKUMENTACIJA: <br>

		<input type="file" name="my_file" /><br /><br />
		<input type="submit" name="submit" value="Upload"/>

		<p><a href="https://pretinac.gov.hr/KorisnickiPretinac/eGradani.html">e-Građani</a></p>
		<p>
          <input type="submit" name="Submit2" value="Registracija">
		  
          <input name="skriveno" type="hidden" id="skriveno" value="1">
        </p>
</form>';


}else{
$fine = true; 

$message = array();
$ime = $_POST['ime'];
$prezime = $_POST['prezime'];
$broj = $_POST['broj'];											
$username = $_POST['username'];
$pass1 = $_POST['password'];
$pass2 = $_POST['ppassword'];
$image= $_POST['image'];
if($pass1!==$pass2) { $fine = false; $message[]='Passwordi nisu jednaki'; }

$email = $_POST['email'];

if(isset($_POST['spol'])) {
 $spol = $_POST['spol'];
 if($spol=='M') { $message[]='Spol: muski'; }
 elseif($spol=='Z') { $message[]='Spol: zenski'; }
 else { $fine=false; $message[]='Spol: greska'; }
}
else { $fine=false; $message[]='Nije odabran spol';}
$poruka = $_POST['poruka'];
if($fine)
{ 
$redak = $username."\t".$broj."\t".$pass1."\t".$email."\t".$spol."\t".$poruka."\n";
$fh = fopen(korisnici,'a');
flock($fh,LOCK_EX);
fwrite($fh,$redak);
flock($fh,LOCK_UN);
fclose($fh);

}
else { 
    
foreach($message as $p){ echo $p.'<br>';} } 
echo '<p> PRIJAVA ZA KOMUNIKACIJU S AGENTOM: </p>'; 
echo '<p> <a href="?a=prijavljivanje_stranica">PRIJAVA</a> </p>';

}
}

function prijavljivanje_stranica(){
echo '   <form name="form1" method="post" action="?a=prijavljivanje">
        <p>Korisnicko ime:<br> 
          <input name="username" type="text" id="username">
        </p>
        <p>Password:<br> 
          <input name="password" type="password" id="password">
        </p>
        <p>
          <input type="submit" name="Submit" value="Prijava">
		  
		
        </p>
</form>'; 
    
}
function prijavljivanje(){
    if($_POST){
$username = $_POST['username'];
$password = $_POST['password'];

$fh = fopen(korisnici,'r');
$provjera = false;
	while (($red = fgets($fh, 4096)) !== false) 
	{	
		$redak = explode("\t",$red);
		if($redak[0]==$username) 
		{
			if($redak[1]==$password) 
            {
                $provjera = true;
                $email = $redak[2];
                break;
            }
		}
	}
	fclose($fh);
echo '<p>Za komunikaciju s agetom:</p>';        
echo '<a href="?a=odabir_jezika&username='.$username.'"> ODABERITE JEZIK</a>';
echo '  <form name="" method="post" action="?a=uredi&username='.$username.'">
</form>';  
}    
}

function odabir_jezika(){

    if (!$_POST) {
    echo '<form method="post" action="">';
    $trazeni_jezici = array();
    $f = fopen('jezici.txt', 'r');
    while (($redak = fgets($f, 4096)) !== false) {
        $polje = explode("\t", $redak);
        if (!in_array($polje[0], $trazeni_jezici)) {
            $trazeni_jezici[] = $polje[0];
        }
    }
    fclose($f);
    echo '<br><select name="odabir">';
    foreach ($trazeni_jezici as $r) {
        echo '<option value="' . $r . '">' . $r . '</option>';
    }
    echo '</select>';
    echo '<br>';
	echo '<br>';
	echo '<br>';
	echo '<br>';
    echo '<input type="submit" value="ODABERI">';
    echo '</form>';
} else {
    $odabir = $_POST['odabir'];
    $f1 = fopen('trazeni_jezici.txt', 'a');
    $f2 = fopen('trazeni_jezici.txt', 'r');
    while (($redak = fgets($f2, 4096)) !== false) {
        $polje = explode("\t", $redak);
        if ($polje[0] == $odabir) {
            echo '<b>Odabrali ste lijek: </b>'.$polje[0].'</p>';
            
            fwrite($f1, $redak);
        }
    }
    fclose($f2);
    fclose($f1);
    
    echo '<b>Zahvaljujemo na odabiru jezika.<br>S obzirom na odabran jezik kroz 24 sata će vas kontaktirati jedan od naših agenata.';
    echo '<br>';
    echo '<br>';
    echo '<br>';
    echo'<a href="?a=odabir_jezika"> ODABERITE JEZIK AGENTA </a>';
   echo '<br>';
    echo '<br>';
    echo '<br>';
    echo'<a href="?a=default_stranica"> POCETNA STRANICA </a>';
    
    
}
}

?>

</body>
</html>
