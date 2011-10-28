<?php
/*
    Copyright (C) Nathanael Schaeffer

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as
    published by the Free Software Foundation, either version 3 of the
    License, or (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Affero General Public License for more details.

    You should have received a copy of the GNU Affero General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
	$myregs = $_COOKIE['myregs'];
	$raide = $_COOKIE['raide'];
	extract($_GET);		// php 5

	$time = time();
	unset( $last_sktr, $last_volo, $last_bivk, $last_skrd );
// les dernieres sorties sont stockees dans 'last' pour 2 jours.
	$last_sktr = trim(@file_get_contents('base/skitour.last'));
	$last_volo = trim(@file_get_contents('base/volo.last'));
	$last_bivk = trim(@file_get_contents('base/bivouak.last'));
	$last_skrd = trim(@file_get_contents('base/c2c.last'));
	$last_ohm = trim(@file_get_contents('base/OHM.last'));
// on efface le cookie 'last' pour le mettre a jour.
	setcookie('last','',$time-1000);
	setcookie('last',"sktr=$last_sktr&volo=$last_volo&bivk=$last_bivk&skrd=$last_skrd&ohm=$last_ohm",$time+48*3600);
// les dernieres sorties vues sont stockees dans 'current' pour 5 min.
	if (isset($_COOKIE['current']))
	{
		$items = explode('&',$_COOKIE['current']);
		$last_sktr = substr($items[0],strpos($items[0],'=')+1);
		$last_volo = substr($items[1],strpos($items[1],'=')+1);
		$last_bivk = substr($items[2],strpos($items[2],'=')+1);
		$last_skrd = substr($items[3],strpos($items[3],'=')+1);
		$last_ohm = substr($items[4],strpos($items[4],'=')+1);
	}
	elseif (isset($_COOKIE['last']))
	{
		$items = explode('&',$_COOKIE['last']);
		$last_sktr = substr($items[0],strpos($items[0],'=')+1);
		$last_volo = substr($items[1],strpos($items[1],'=')+1);
		$last_bivk = substr($items[2],strpos($items[2],'=')+1);
		$last_skrd = substr($items[3],strpos($items[3],'=')+1);
		$last_ohm = substr($items[4],strpos($items[4],'=')+1);
		setcookie('current',$_COOKIE['last'],$time+15*60);
	}

// raide : cookie must be overridden by form input.
	if (isset($_COOKIE['raide']) && (!empty($_GET)) && (!isset($_GET['raide'])))
		unset($raide);
// only my region : cookie must be overridden by form input.
	if (isset($_COOKIE['myregs']) && (!empty($_GET)) && (!isset($_GET['myregs'])))
		unset($myregs);
?>
<html>
<head>
<title>Meta-Skirando</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="description" content="Le moteur de recherche du Ski de Rando. Les conditions de neige pour le ski de randonnée en France et ailleurs !" />
<meta name="keywords" content="ski de rando, ski alpinisme, ski extrême, pente raide, alpes, pyrénées, neige, météo, skitour, skirando, blms, nimp crew, volopress, ohm chamonix, sngm, bivouak" />
<link href="style.css" rel="stylesheet" type="text/css" />
<link rel="alternate" type="application/rss+xml" title="Les dernieres sorties de ski de rando" href="ski_rss.php" />
<link rel="search" type="application/opensearchdescription+xml" title="rechercher avec metaskirando" href="metaskirando.xml">
<link rel="shortcut icon" href="favicon.ico" />
</head>
<body>

<?php include 'menu.inc'; ?>

<h1 style="text-align: center;"><small>Le moteur de recherche du Ski de
Rando :<br>
<small style="font-style: italic;">Passer plus de temps &agrave;
surfer
sur la neige que sur le net.</small></small><br>
</h1>

<?php

require "sites.inc.php";

//	echo "cookie 'last' = {$_COOKIE['last']}<br>";
//	echo "cookie 'current' = {$_COOKIE['current']}<br>";


//	update_OHM();
	update_SNGM();
//	update_BLMS();
	update_Bivouak();
	update_Skitour();
	update_Gulliver();
	update_Skirando();
//	update_NimpCrew();
	update_Volopress();
	update_CAFisere();

load_All($sorties);

$regs = make_region_list($sorties);

$nsorties = count($sorties);

?>

<p style="text-align: center;">Les <b><?php echo $nsorties; ?></b> derni&egrave;res sorties des principaux sites web de ski de randonn&eacute;s accessibles d'un seul coup d'oeil !<br>
<!--
<br /><span style="background: #ff99ff;"><big><b>Bug corrigé : </b></big>les <a href="prefs.php">filtres personnalisés</a> fonctionnent à nouveau</span>
-->
<!--
<br /><span style="background: #ff9999;"><big><b>[Nat'n'Co]</b></big> <b>Prochaine rando tractée le samedi 9 Fevrier, au Tabor de la Mure. RDV 8h30 au parking de Villard St-Honore</b> Pour être informé des futurs tractages, inscrivez-vous sur <a href="http://natnco.free.fr">Nat'n'Co</a></span>
<br /><span style="background: #ff9999;"><big><b>Camptocamp.org est à nouveau correctement indexé + nouvelle <a href="Nivo.php#Par">nivose Parpaillon</a>.</b></big> et aussi un <b>plugin recherche pour firefox</b> proposé par un de nos lecteurs.<br> Pour l'installer cliquer sur l'icone de la barre de recherche, et ajouter "metaskirando" !</span>
-->
<br /><span style="background: #ff9999;"><big><b>nouvelle <a href="Nivo.php#Big">nivose Aiguillettes</a>.</b></big>
et aussi un <b>plugin recherche pour firefox</b> proposé par un de nos lecteurs.<br> Pour l'installer cliquer sur l'icone de la barre de recherche, et ajouter "metaskirando" !</span>
</p>


<div style="text-align:center;">
<FORM method='get' name='search'>
<table align='center'><tr bgcolor='#ccccff'>
<td style="text-align:center; padding:5px 20px">
	<i><b>K</b>ick <b>Z</b>eurch</i> : <INPUT title="recherche sur tous les champs (massif, itinéraire, auteur, date ...)" TYPE=text SIZE=20 NAME=str>
	<INPUT TYPE=submit NAME="kz" VALUE="Quoi de neuf ?">
</td><td style="text-align:center; padding: 5px 20px;">
<input title="Seulement les pentes raides (a partir du niveau 4.1 ou D-)" type=checkbox name="raide" <?php if (isset($raide)) echo 'checked'; ?>>&nbsp;Pente&nbsp;raide.
<?php
	if (isset($_COOKIE['region']))
	{	?>
<br><input title="Seulement les sorties de mes régions." type=checkbox name="myregs" <?php if (isset($myregs)) echo 'checked'; ?>>&nbsp;Dans&nbsp;mes&nbsp;régions.
<?php 
	}	?>
</td><td style="text-align:center; padding:5px 20px">
<b> Massif : </b> <SELECT NAME="zon" onchange="document.forms['search'].submit()">
<option value=''>
<?php
	if (isset($_COOKIE['region']))
	{
		foreach ( $_COOKIE['region'] as $nom => $key )
			echo "<option value=\"$key\">* $nom </option>\n";
	}

	$r = count($regs);
	for ($i=0;$i<$r;$i++)
	{
		$nom = $regs[$i]['nom'];
		$nbr = $regs[$i]['nbr'];
		$key = $regs[$i]['key'];
		if ($nbr != 0)
	  		echo "<option value=\"$key\">$nom ($nbr) </option>\n";
	}
?>
	</SELECT>
<!--
<input TYPE=submit NAME="find" VALUE="Baaaaase !">
-->
<br>
	<a href="prefs.php">Définir mes régions</a>
</td></tr>
</table>
</FORM></div>

<?php

if (isset($raide))
{
	unset($found);
	$nf = 0;
	$n = count($sorties);
	for($i = 0; $i < $n; $i++)
	{
		if ($sorties[$i]['site'] == 'volo')
		{
			$found[$nf] = $sorties[$i];
			$nf++;
		}
		else
		{
			$cot = substr($sorties[$i]['cot'],0,1);
			switch($cot) {
				case '4' : case '5' : case 'D' : case 'T' : case 'E' :
				$found[$nf] = $sorties[$i];
				$nf++;
			}
		}
	}
	$sorties = $found;
}

if ( isset($myregs) && empty($zon) && isset($_COOKIE['region']) )
{
	unset($found);
	
	$zon = implode('|',$_COOKIE['region']);
	
	$nf = 0;
	$n = count($sorties);
	for($i = 0; $i < $n; $i++)
	{
		if (eregi($zon,$sorties[$i]['reg']))
		{
			$found[$nf] = $sorties[$i];
			$nf++;
		}
	}
	$sorties = $found;
}

$kz = 0;
if (!empty($zon))
{
//	$zon = implode('|',$zonA);

	unset($found);
	$nf = 0;
	for($j=0;$j<$r;$j++)
	{
		if ($zon == $regs[$j]['key'])
		{
			$reg_name = $regs[$j]['nom'];
			break;
		}
	}
	echo "\n<h1>$reg_name</h1>\n";
	
	$n = count($sorties);
	for($i = 0; $i < $n; $i++)
	{
		if (eregi($zon,$sorties[$i]['reg']))
		{
			$found[$nf] = $sorties[$i];
			$nf++;
		}
	}
	$sorties = $found;
	$kz = 1;
}

if (!empty($_GET['str']))
{
	unset($found);
	$nf = 0;
	$n = count($sorties);
	$req_str = sans_accent(eregi_replace('([1-5])[.]([1-6])',"\\1[.]\\2",$_GET['str']));
	$keys = explode(' ',$req_str);
	for($i = 0; $i < $n; $i++)
	{
		if (kick_zeurch($keys,sans_accent(implode(' ',$sorties[$i]))))
		{
			$req_str = implode('|',$keys);
			$found[$nf]['date'] = eregi_replace($req_str,"<span class='yt'>\\0</span>",$sorties[$i]['date']);
			$found[$nf]['nom'] = eregi_replace($req_str,"<span class='yt'>\\0</span>",$sorties[$i]['nom']);
			$found[$nf]['reg'] = eregi_replace($req_str,"<span class='yt'>\\0</span>",$sorties[$i]['reg']);
			$found[$nf]['part'] = eregi_replace($req_str,"<span class='yt'>\\0</span>",$sorties[$i]['part']);
			$found[$nf]['cot'] = eregi_replace($req_str,"<span class='yt'>\\0</span>",$sorties[$i]['cot']);
			$found[$nf]['site'] = $sorties[$i]['site'];
			$found[$nf]['lien'] = $sorties[$i]['lien'];
			$found[$nf]['id'] = $sorties[$i]['id'];
			$nf++;
		}
	}
	$sorties = $found;
	$kz = 1;
}

if ($kz == 0)
{
	echo "\n<h2>Quoi de neuf ?</h2>\n";
	$dmax = date('Y-m-d',time()-40*3600);

	unset($found);
	$nf = 0;
	// affiche les dernieres
	$n = count($sorties);
	for($i = 0; $i < $n; $i++)
	{
		$site = $sorties[$i]['site'];
		$id = $sorties[$i]['id'];
		$date = $sorties[$i]['date'];
/*
		if ( (($site == 'volo')&&( strnatcmp($id,$last_volo) >0 )) || (($site == 'skitour')&&($id > $last_sktr)) || (($site == 'c2c')&&($id > $last_skrd)) || (($site == 'bivouak')&&($id > $last_bivk)) || (($site == 'OHM')&&($id > $last_ohm)) )
		{
			$found[$nf] = $sorties[$i];
			$nf++;
		}
		elseif ($date >= $dmax)
		{
			$found[$nf] = $sorties[$i];
			$nf++;
		}
*/
		$found[$nf] = $sorties[$i];
		$nf++;
	}

/*
	if ($nf > 30)
	{
		echo "<p>$nf nouvelles sorties, dont 30 affichées.</p>\n";
		$found = array_slice($found,0,30);
	}
	else
*/
	if ($nf == 0)
	{
		rsort($sorties);
		$found = array_slice($sorties,0,30);
	}
	$sorties = &$found;
}

/*	$last_sktr = trim(file_get_contents('skitour.last'));
	$last_volo = trim(file_get_contents('volopress.last'));
	$last_bivk = trim(file_get_contents('bivouak.last'));
	$last_skrd = trim(file_get_contents('skirando.last'));
*/

//	echo "<p>last skitour: $last_sktr, skirando: $last_skrd, volo: $last_volo, biv: $last_bivk</p>";

if (isset($found))
{
	rsort($sorties);
	echo "<center><table class='main'>\n";

	$prevdate = 0;
	$n = count($sorties);
	for ($i=0;$i<$n;$i++)
	{
		$date = $sorties[$i]['date'];
		$nom = $sorties[$i]['nom'];
		$site = $sorties[$i]['site'];
		$reg = $sorties[$i]['reg'];
		$part = $sorties[$i]['part'];
		$lien = $sorties[$i]['lien'];
		$cot = $sorties[$i]['cot'];
		$id = $sorties[$i]['id'];

		$trtag = '<tr class="new">';
		switch($site) {
			case 'volo' : if ( strnatcmp($id,$last_volo) <= 0 ) { $trtag = '<tr>'; }
				 break;
			case 'bivouak' : if ($id <= $last_bivk) { $trtag = '<tr>'; }
				 break;
			case 'c2c' : if ($id <= $last_skrd) { $trtag = '<tr>'; }
				 break;
			case 'skitour' : if ($id <= $last_sktr) { $trtag = '<tr>'; }
				 break;
			case 'OHM' : if ($id <= $last_ohm) { $trtag = '<tr>'; }
				 break;
			default: $trtag = '<tr>';
		}

		if ($date == $prevdate) {
			$dtxt = '';
		} else {
			if ($i >= 100) break;	// trop de sorties ? on arête là !
			$dtxt = $date;
			$prevdate = $date;
		}
		
		if ($site == 'gulliver')
		{
			$trad = 'http://babelfish.altavista.com/babelfish/tr?lp=it_fr&trurl=' . urlencode($lien);
			echo "$trtag<td>$dtxt</td><td><a href=\"$lien\">$nom</a> [<a href=\"$trad\">FR</a>]</td><td><b>$reg</b></td><td>$cot</td><td><i> $part</i> [$site]</td></tr>\n";
		}
		else
		{
			echo "$trtag<td>$dtxt</td><td><a href=\"$lien\">$nom</a></td><td><b>$reg</b></td><td>$cot</td><td><i> $part</i> [$site]</td></tr>\n";
		}
	}

	echo '</table></center>';
}

include 'bottom.inc';

?>

</body></html>
