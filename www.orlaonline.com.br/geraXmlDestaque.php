<?php
	echo '<?xml version="1.0" encoding="iso-8859-1"?>';
?>
<galeria>
<?php
	include "configuration.php"; ;

	/*
	Esta funcao cria um thumb de uma imagem e salva em $thumb
	$img = nome da imagem
	$h	 = altura
	$w	 = largura
	$rw	 = sobrescrever thumb
	*/
	function thumb($img, $x = 9999, $y = 9999, $rw = false, $menor = true){
		if ($img == "") {return;}
		$ext  = explode(".", $img); // ext img
		
		
		// busca a imagem
		if ($ext[1] == "jpg"){
			$im = imagecreatefromjpeg($img);
		}else if ($ext[1] == "gif"){
			$im = imagecreatefromgif($img);
		}else if ($ext[1] == "png"){
			$im = imagecreatefrompng($img);
		}else {
			$im = imagecreatefromjpeg($img);
		}
		
		if ((is_file($ext[0]."_".$x."x".$y.".".$ext[1]))&&(!$rw)) {return;}
		
		// largura e altura
		$ix = imagesx($im);
		$iy = imagesy($im);
	
		// escala
		if ($menor)
			$is = min(($x/$ix),($y/$iy));
		else
			$is = max(($x/$ix),($y/$iy));
		
		// novas altura e largura
		$inx = floor($ix * $is);
		$iny = floor($iy * $is);
		
		// cria a img final
		$n_img = imagecreatetruecolor($inx, $iny);
		
		// copia a nova imagem
		imagecopyresampled($n_img, $im, 0, 0, 0, 0, $inx, $iny, $ix, $iy);
		
		// imprime a nova imagem
		imagepng($n_img,$ext[0]."_".$x."x".$y.".".$ext[1]);
		
		// libera memória
		imagedestroy($im);
		imagedestroy($n_img);
	}


	//1º passo - Conecta ao servidor MySQL
	if(!($id = mysql_connect("localhost",'orlaonli_user','1579387'))) {
	   echo "Não foi possível estabelecer uma conexão com o gerenciador MySQL. Favor Contactar o Administrador.";
	   exit;
	}
	//2º passo - Seleciona o Banco de Dados
	if(!($con=mysql_select_db('orlaonli_dbwork',$id))) {
	   echo "Não foi possível estabelecer uma conexão com o banco MySQL. Favor Contactar o Administrador.";
	   exit;
	}
	
	$strSql = "SELECT `id`, `title`, `introtext` FROM `jos_content` WHERE `created_by` = 65 ORDER BY id DESC LIMIT 0 , 5 ";
	
	$res = @mysql_query($strSql,$id);
	//Exibe as linhas encontradas na consulta
	while ($row = mysql_fetch_array($res)) {
		//echo "<foto imagem='".$row['introtext']."' legenda='".$row['title']."' link='".$row['id']."'/>";
		$img2 = explode("<img", $row['introtext']);
		$img3 = explode("src=", $img2[1]);
		$img4 = explode("\"", $img3[1]);
		$img = $img4[1];"images/stories/boca da barra itanham noturna-luciano netto.jpg";
		$height = 300;
		$width = 300;
		$ext  = explode(".", $img);
		$nimg = "http://www.orlaonline.com.br/joomla/".$ext[0]."_".$width."x".$height.".".$ext[1];
		if (file_exists($img)) 
			thumb($img, $width, $height, false, false);
		else
			$nimg = "http://www.orlaonline.com.br/joomla/images/stories/logo.jpg";
		echo "	<foto imagem='".$nimg."' legenda='".$row['title']."' link='".$row['id']."'/>";
?>

<?php
}
?>
</galeria>