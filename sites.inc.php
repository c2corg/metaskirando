<?php
/*
    Copyright (C) Nathanael Schaeffer
    Copyright (C) Camptocamp Association

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

require_once('./settings.inc.php');

// la date limite des sorties, commune à tous les sites => 1 mois.
	$dlim = date('Y-m-d',time()-31*24*3600);
	$today = date('Y-m-d',time());
	ignore_user_abort(TRUE);

//////////////
// les sorties sont enregistrées par :
// * date * site * region * iti * lien * participants * cot
//////////////

function make_region_list(&$sorties)
{
$reg[] = array( 'nom' => '+ Savoies', 'key' => 'Aravis|Bornes|Bauges|Chablais|Fauci|Rouges|Blanc|Bianco|Giffre', 'nbr' => 0);
	$reg[] = array( 'nom' => '&nbsp; Aravis - Bornes', 'nbr' => 0, 'key' => 'Aravis|Bornes' );
	$reg[] = array( 'nom' => '&nbsp; Bauges', 'nbr' => 0, 'key' => 'Bauges' );
	$reg[] = array( 'nom' => '&nbsp; Chablais - Faucigny - Aig.Rouges', 'nbr' => 0, 'key' => 'Chablais|Rouges|Fauci|Giffre' );
	$reg[] = array( 'nom' => '&nbsp; Mont-Blanc', 'nbr' => 0, 'key' => 'Blanc|Bianco' );
$reg[] = array( 'nom' => '+ Maurienne et Tarentaise', 'nbr' => 0, 'key' => 'Beaufort|lauz|Vanoise|Maurienne|Charbonnel|Cerces|Ambin|Thabor|Tarentaise|Alpes Gr' );
	$reg[] = array( 'nom' => '&nbsp; Beaufortain', 'nbr' => 0, 'key' => 'Beaufort' );
	$reg[] = array( 'nom' => '&nbsp; Vanoise-Lauzière', 'nbr' => 0, 'key' => 'Vanoise|lauz' );
	$reg[] = array( 'nom' => '&nbsp; Charbonnel - Grées', 'nbr' => 0, 'key' => 'Charbonnel|Tarentaise|Maurienne|Alpes Gr' );
	$reg[] = array( 'nom' => '&nbsp; Cerces - Thabor - Ambin', 'nbr' => 0, 'key' => 'Cerces|Thabor|Ambin|Maurienne' );
$reg[] = array( 'nom' => '+ Autour de Grenoble', 'key' => 'Belledonne|Chartreuse|Vercors|Rousses|Taillefer|Mat.+sine|Beaumont', 'nbr' => 0 );
	$reg[] = array( 'nom' => '&nbsp; Belledonne', 'nbr' => 0, 'key' => 'Belledonne' );
	$reg[] = array( 'nom' => '&nbsp; Chartreuse', 'nbr' => 0, 'key' => 'Chartreuse' );
	$reg[] = array( 'nom' => '&nbsp; Rousses - Arves - Galibier', 'nbr' => 0, 'key' => 'Rousses|Arves|Galibier' );
	$reg[] = array( 'nom' => '&nbsp; Taillefer - Matheysine', 'nbr' => 0, 'key' => 'Taillefer|Beaumont|Mat.+sine' );
	$reg[] = array( 'nom' => '&nbsp; Vercors', 'nbr' => 0, 'key' => 'Vercors' );
$reg[] = array( 'nom' => '+ Alpes du Sud', 'key' => 'Dign|Queyras|Parpaillon|Ubaye|Brian|Maritime|Mercantour|Baron|voluy|crins|valg|oisans|combeyn|champsaur|grasse|provence|du.Sud', 'nbr' => 0);
	$reg[] = array( 'nom' => '&nbsp; Alpes Maritimes', 'nbr' => 0, 'key' => 'Maritime|Mercantour' );
	$reg[] = array( 'nom' => '&nbsp; Dévoluy', 'nbr' => 0, 'key' => 'voluy' );
	$reg[] = array( 'nom' => '&nbsp; Ecrins', 'nbr' => 0, 'key' => 'crins|champsaur|valg|combeyn|oisans' );
	$reg[] = array( 'nom' => '&nbsp; Préalpes de Provence', 'key' => 'Dign|Baron|grasse|prov', 'nbr' => 0);
	$reg[] = array( 'nom' => '&nbsp; Queyras - Parpaillon - Ubaye', 'nbr' => 0, 'key' => 'Queyras|Parpaillon|Ubaye|Brian' );
$reg[] = array( 'nom' => 'Corse', 'nbr' => 0, 'key' => 'Corse|Corsica' );
$reg[] = array( 'nom' => 'Jura', 'nbr' => 0, 'key' => 'Jura' );
$reg[] = array( 'nom' => 'Massif Central', 'nbr' => 0, 'key' => 'Massif Central' );
//$reg[] = array( 'nom' => 'Pyrénées', 'nbr' => 0, 'key' => 'Pyr|Aig.etortes|Andorr.|Ari.ge|Aure|Capcir|Card.s|Cerdagne|Corbi.res|Conflent|Gavarnie|Maladeta|N.ouvielle|Ordesa|Posets' );
$reg[] = array( 'nom' => 'Pyrénées', 'nbr' => 0, 'key' => 'Pyr|Pirine|Aig.etortes|Andorr|Ari.ge|Aure|Basque|B.arn|Bigorre|Cadi|Canigou|Cantabri|Capcir|Card.s|Catalo|Cerdagne|Conflent|Corbi.res|Couserans|Encantats|Euskadi|Gavarnie|Garrotxa|Gredos|Luchon|Maladeta|Mont.Perdu|Monte.Perdido|Navarr|N.ouvielle|de.Europa|Posets|Puigmal|Vasco' );
$reg[] = array( 'nom' => 'Vosges', 'nbr' => 0, 'key' => 'Vosges' );
$reg[] = array( 'nom' => '+ Suisse', 'nbr' => 0, 'key' => 'Bern|Vaudois|Urner|Glarner|Appenzell|ndner|Graub' );
	$reg[] = array( 'nom' => '&nbsp; Alpes Bernoises/Fribourgeoises', 'nbr' => 0, 'key' => 'Bern|Fribourg' );
	$reg[] = array( 'nom' => '&nbsp; Alpes Vaudoises', 'nbr' => 0, 'key' => 'Vaudois' );
	$reg[] = array( 'nom' => '&nbsp; Apenzeller', 'nbr' => 0, 'key' => 'Appenzell' );
	$reg[] = array( 'nom' => '&nbsp; Bündner Oberland', 'nbr' => 0, 'key' => 'ndner' );
	$reg[] = array( 'nom' => '&nbsp; Urner-Glarner Alpen', 'nbr' => 0, 'key' => 'Urner|Glarner' );
	$reg[] = array( 'nom' => '&nbsp; Graubünden', 'nbr' => 0, 'key' => 'Graub' );
$reg[] = array( 'nom' => 'Valais', 'nbr' => 0, 'key' => 'Valais|Pennin' );
$reg[] = array( 'nom' => '+ Italie', 'nbr' => 0, 'key' => 'Italie|Paradis|Tici|Orobie|Adamello|Dolomiti|Giulie|Ortles|Cozi|Disgrazia' );
	$reg[] = array( 'nom' => '&nbsp; Adamello', 'nbr' => 0, 'key' => 'Adamello' );
	$reg[] = array( 'nom' => '&nbsp; Cozie', 'nbr' => 0, 'key' => 'Cozi' );
	$reg[] = array( 'nom' => '&nbsp; Dolomites', 'nbr' => 0, 'key' => 'Dolomit' );
	$reg[] = array( 'nom' => '&nbsp; Engadin - Disgrazia', 'nbr' => 0, 'key' => 'Disgrazia' );
	$reg[] = array( 'nom' => '&nbsp; Giulie', 'nbr' => 0, 'key' => 'Giulie' );
	$reg[] = array( 'nom' => '&nbsp; Gran Paradiso', 'nbr' => 0, 'key' => 'Paradis' );
	$reg[] = array( 'nom' => '&nbsp; Orobie', 'nbr' => 0, 'key' => 'Orobie' );
	$reg[] = array( 'nom' => '&nbsp; Ortles', 'nbr' => 0, 'key' => 'Ortles' );
	$reg[] = array( 'nom' => '&nbsp; Tici', 'nbr' => 0, 'key' => 'Tici' );
$r = count($reg);
$r2 = 0;
$n = count($sorties);

$reg2 = array();

// un premier scan pour obtenir les régions.
	for ($i=0;$i<$n;$i++)
	{
		$reg_name = $sorties[$i]['reg'];

		$j = 0; $found = FALSE;
		while($j<$r)
		{
			if (eregi($reg[$j]['key'],$reg_name))
			{
				$reg[$j]['nbr'] ++;
				$found = TRUE;
			}
			$j++;
		}
		if (!$found)
		{
			for($j=0; $j<$r2; $j++)
			{
				if (isset($reg2[$j]) && $reg2[$j]['key'] == $reg_name)
				{
					$reg2[$j]['nbr'] ++;
					$found = TRUE;
					break;
				}
			}
			if (!$found)
				$reg2[$r2] = array( 'nom' => $reg_name, 'nbr' => 1, 'key' => $reg_name);
				$r2++;
		}
	}

// tri
	if (count($reg2) != 0) {
		sort($reg2);
		return array_merge( $reg, $reg2 );
	}
	else
		return $reg;
}

function load_cache($base,&$sorties)
{
	global $dlim;
  global $SETTINGS;

	$txt = $SETTINGS['odir'] . "/$base.txt";

	if ($fd = @fopen($txt,'r')) {
	while( !feof($fd) )
	{
		list($site, $id) = fscanf($fd, "%s %s\n");
		list($date, $cot) = fscanf($fd, "%s %s\n");
		$cot = str_replace('_',' ',$cot);
		$nom = ucfirst(html_entity_decode(trim(fgets($fd,256)),ENT_QUOTES));
		$lien = trim(fgets($fd,256));
		$reg = html_entity_decode(trim(fgets($fd,256)),ENT_QUOTES);
		$part = trim(fgets($fd,256));
		
		if ($date >= $dlim)
		{
			$sorties[] = array( 'date' => $date, 'nom' => $nom, 'reg' => $reg, 'site' => $site,
				'part' => $part, 'lien' => $lien, 'cot' => $cot, 'id' => $id );
		}
	}
	fclose($fd);
//	if ($date < $dlim)
//		array_pop($sorties);
	}
}

function loadclean_cache($base,&$tmp)
{
	global $dlim;
  global $SETTINGS;

	$old = 0;
	$istart = count($tmp);	// on sauve l'index de depart...
	$txt = $SETTINGS['odir'] . "/$base.txt";
	$ftmp = "$txt.tmp";
	$list_id[] = '0';		// pour supprimer les eventuels doublons...

	if ( (file_exists($ftmp)) && (time() > (@filemtime($ftmp) + 300)) )
	{
		@unlink($ftmp);		// efface le fichier tmp si ca fait trop longtemps...
	}

if ($fd = @fopen($txt,'r'))
{
	while( !feof($fd) )
	{
		list($site, $id) = fscanf($fd, "%s %s\n");
		list($date, $cot) = fscanf($fd, "%s %s\n");
		$nom = html_entity_decode(trim(fgets($fd,256)),ENT_QUOTES);
		$lien = trim(fgets($fd,256));
		$reg = html_entity_decode(trim(fgets($fd,256)),ENT_QUOTES);
		$part = trim(fgets($fd,256));

		if (($site != $base)&&(!feof($fd))) {	// erreur dans le fichier => reset requis !
			fclose($fd);
			@unlink($SETTINGS['odir'] . "/$base.last");
			return;
		}

		$res = array_search($id,$list_id);
		if (($date >= $dlim)&&($res === FALSE))
		{
			$list_id[] = $id;
			$tmp[] = array( 'date' => $date, 'nom' => $nom, 'reg' => $reg, 'site' => $site,
				'part' => $part, 'lien' => $lien, 'cot' => $cot, 'id' => $id );
		}
		else $old++;
	}
	fclose($fd);
//	if ($date >= $dlim)
//		array_pop($sorties);

	$n = count($tmp);
	if ( ($old*5) > ($n-$istart) )	// cleanup requis si 1/6 des sorties est p?im?.
	{
		if ( $fd = @fopen($ftmp,'x+') )	// cleanup en cours ?
		{
			for ($i=$istart; $i<$n; $i++)	// on commence ?l'index de d?art.
			{
				$site = $tmp[$i]['site'];	$id = $tmp[$i]['id'];
				$date = $tmp[$i]['date'];	$cot = $tmp[$i]['cot'];
				$nom = $tmp[$i]['nom'];
				$lien = $tmp[$i]['lien'];
				$reg = $tmp[$i]['reg'];
				$part = $tmp[$i]['part'];
				fwrite($fd,"$site $id\n$date $cot\n$nom\n$lien\n$reg\n$part\n");
			}
			fclose($fd);
			unlink($txt);
			rename($ftmp, $txt);
		}
	}
}
}

function cleanup_cache($base)
{
	global $dlim;
  global $SETTINGS;

	$txt = $SETTINGS['odir'] . "/$base.txt";
	load_cache($txt,$tmp);
	$n = count($tmp);
	$ftmp = "$txt.tmp";
	
	if ( $fd = @fopen($ftmp,'x+') )		// la base n'est pas déjç en train d'etre nettoyée ???
	{
		for ($i=0; $i<$n; $i++)
		{
			$site = $tmp[$i]['site'];	$id = $tmp[$i]['id'];
			$date = $tmp[$i]['date'];	$cot = $tmp[$i]['cot'];
			$nom = $tmp[$i]['nom'];
			$lien = $tmp[$i]['lien'];
			$reg = $tmp[$i]['reg'];
			$part = $tmp[$i]['part'];
			fwrite($fd,"$site $id\n$date $cot\n$nom\n$lien\n$reg\n$part\n");
		}
		fclose($fd);

		unlink($txt);
		rename($ftmp, $txt);
	}
	return $fd;
}

function load_All( &$sorties )
{
	load_cache('nimpcrew',$sorties);
	load_cache('SNGM',$sorties);
//	load_cache('blms',$sorties);
	load_cache('gulliver',$sorties);
	load_cache('CAF38',$sorties);
	loadclean_cache('volo',$sorties);
	loadclean_cache('skitour',$sorties);
	loadclean_cache('c2c',$sorties);
	loadclean_cache('bivouak',$sorties);
	loadclean_cache('OHM',$sorties);
}

/// www.skitour.fr
function update_Skitour($base = 'skitour')
{
  global $SETTINGS;

	$web  = $SETTINGS['odir'] . "/$base.web";
	$txt  = $SETTINGS['odir'] . "/$base.txt";
	$last = $SETTINGS['odir'] . "/$base.last";
	$expire = 10*60;		// en secondes.
	$ftmp = "$txt.tmp";

	if (!file_exists($last)) {
		reset_Skitour();
		return TRUE;
	}

	// mise a jour du fichier $txt ...
	if (@filemtime($web) > @filemtime($last))	// ... si la date est atteinte ...
	{
	  if ( $fd = @fopen($ftmp,'x') )	// update en cours ?
	  {
		fclose($fd);
		$textall = @file_get_contents($web);
		if ($textall !== FALSE) // le site est HS ? on utilise le cache !
		{
			$last_id = (int) trim(@file_get_contents($last));
			$new_id = parse_Skitour($textall,$last_id);
			if ($new_id > $last_id)		// si on a du nouveau ...
			{
				$fd=@fopen($last,'w');	@fwrite($fd,$new_id);	@fclose($fd);
				$fd=@fopen($txt,'a');
				@flock($fd,LOCK_EX);
				@fwrite($fd,$textall);
				@fclose($fd);
			}
			else touch($last);
		}
		else touch($last);
		unlink($ftmp);
	  } elseif (time() > (@filemtime($ftmp) + 3600)) // efface le fichier tmp si ca fait trop longtemps...
		@unlink($ftmp);
	}
	return TRUE;
}

/// www.volopress.net
function update_Volopress($base = 'volo')
{
  global $SETTINGS;

	$web  = $SETTINGS['odir'] . "/$base.web";
	$txt  = $SETTINGS['odir'] . "/$base.txt";
	$last = $SETTINGS['odir'] . "/$base.last";
	$expire = 10*60;		// en secondes.
	$ftmp = "$txt.tmp";

	if (!file_exists($last)) @unlink($txt);

	// mise a jour du fichier $txt ...
	if (@filemtime($web) > @filemtime($last))	// ... si la date est atteinte ...
	{
	  if ( $fd = @fopen($ftmp,'x') )	// update en cours ?
	  {
		fclose($fd);
		$textall = @file_get_contents($web);
		if ($textall !== FALSE)
		{
			$last_id = trim(@file_get_contents($last));
			$new_id = parse_Volopress($textall,$last_id);
			$last_id = trim(@file_get_contents($last));		// relis le last_id, parse_xxx a pris du temps !
			if (strnatcmp($new_id,$last_id) > 0)
			{
				$fd = @fopen($last,'w');	@fwrite($fd,$new_id);	@fclose($fd);
				$fd=@fopen($txt,'a');
				@flock($fd,LOCK_EX);
				@fwrite($fd,$textall);
				@fclose($fd);
			}
			else touch($last);
		}
		else touch($last);
		unlink($ftmp);
	  } elseif (time() > (@filemtime($ftmp) + 3600)) // efface le fichier tmp si ca fait trop longtemps...
		@unlink($ftmp);
	}
	return TRUE;
}

/// www.camptocamp.org
function update_Skirando($base = 'c2c')
{
  global $SETTINGS;

	$web  = $SETTINGS['odir'] . "/$base.web";
	$txt  = $SETTINGS['odir'] . "/$base.txt";
	$last = $SETTINGS['odir'] . "/$base.last";
	$expire = 10*60;		// en secondes.
	$ftmp = "$txt.tmp";

	if (!file_exists($last)) {
		reset_Skirando();
		return TRUE;
	}

	// mise a jour du fichier $txt ...
	if (@filemtime($web) > @filemtime($last))	// ... si la date est atteinte ...
	{
	  if ( $fd = @fopen($ftmp,'x') )	// update en cours ?
	  {
		fclose($fd);
//		$textall = @file_get_contents('http://www.camptocamp.org/outings/list/1');
		$textall = @file_get_contents($web);
		if ($textall !== FALSE)
		{
			$last_id = (int) trim(@file_get_contents($last));
			$new_id = parse_Skirando($textall,$last_id);
			if ($new_id > $last_id)
			{
				$fd=@fopen($txt,'a');
				@flock($fd,LOCK_EX);
				@fwrite($fd,$textall);
				@fclose($fd);
				$fd = @fopen($last,'w');	@fwrite($fd,$new_id);	@fclose($fd);
			}
			else touch($last);
		}
		else touch($last);
		unlink($ftmp);
	  } elseif (time() > (@filemtime($ftmp) + 3600)) // efface le fichier tmp si ca fait trop longtemps...
		@unlink($ftmp);
	}
	return TRUE;
}


/// www.bivouak.net
function update_Bivouak($base = 'bivouak')
{
  global $SETTINGS;

	$web  = $SETTINGS['odir'] . "/$base.web";
	$txt  = $SETTINGS['odir'] . "/$base.txt";
	$last = $SETTINGS['odir'] . "/$base.last";
	$expire = 10*60;		// en secondes.

	if (!file_exists($last)) @unlink($txt);

	// mise a jour du fichier $txt ...
	if (@filemtime($web) > @filemtime($last))	// ... si la date est atteinte ...
	{
		$textall = @file_get_contents($web);
		if ($textall !== FALSE) // le site est HS, on utilise le cache.
		{
			$last_id = (int) trim(@file_get_contents($last));
			$new_id = parse_Bivouak($textall,$last_id);
			if ($new_id > $last_id)
			{
				$fd = @fopen($last,'w');	@fwrite($fd,$new_id);	@fclose($fd);
				$fd=@fopen($txt,'a');
				@flock($fd,LOCK_EX);
				@fwrite($fd,$textall);
				@fclose($fd);
			}
			else touch($last);
		}
		else touch($last);
	}
	return TRUE;
}

/// www.ohm-chamonix.com
function update_OHM($base = 'OHM')
{
  global $SETTINGS;

	$txt  = $SETTINGS['odir'] . "/$base.txt";
	$last = $SETTINGS['odir'] . "/$base.last";
	$expire = 2*3600;		// 2 heures
	$ftmp = "$txt.tmp";

	if (!file_exists($last)) @unlink($txt);

	// mise a jour du fichier $txt ...
	if (@filemtime($web) > @filemtime($last))	// ... si la date est atteinte ...
	{
	  if ( $fd = @fopen($ftmp,'x') )	// update en cours ?
	  {
		fclose($fd);
		$textall = @file_get_contents('http://www.ohm-chamonix.com/fiche.php?id=01&ling=Fr');
		if ($textall !== FALSE) // le site est HS, on utilise le cache.
		{
			$last_id = (int) trim(@file_get_contents($last));
			$new_id = parse_OHM($textall,$last_id);
			$last_id = trim(@file_get_contents($last));		// relis le last_id, parse_xxx a pris du temps !
			if ($new_id > $last_id)
			{
				$fd = @fopen($last,'w');	@fwrite($fd,$new_id);	@fclose($fd);
				$fd=@fopen($txt,'a');
				@flock($fd,LOCK_EX);
				fwrite($fd,$textall);
				@fclose($fd);
			}
			else touch($last);
		}
		else touch($last);
		unlink($ftmp);
	  } elseif (time() > (@filemtime($ftmp) + 3600)) // efface le fichier tmp si ca fait trop longtemps...
		@unlink($ftmp);
	}
	return TRUE;
}

///////// RSS FUNCTIONS ////////////

// nimp.crew.free.fr
function update_NimpCrew($base = 'nimpcrew')
{
  global $SETTINGS;

	$txt = $SETTINGS['odir'] . "/$base.txt";
	$expire = 30*60;	// en secondes.
	$cur_month = date('m');	$cur_year = date('Y');
	
	if (@filemtime($web) > @filemtime($txt))
	{
		$textall = @file_get_contents('http://nimp.crew.free.fr/last10_rss.php');
		if ($textall !== FALSE)
		{
			$entries = explode('</item>',substr($textall,strpos($textall,'<item>')));
			$n = count($entries) - 1;
			$textall = '';
			for($i = 0; $i< $n; $i++)
			{
				$entry = explode('</',$entries[$i]);
				unset($regs);
				ereg('\[([^,]*), ([0-5].[1-9])',$entry[2],$regs); $reg = $regs[1]; $cot = $regs[2];
				if ($regs[2])
				{
					$lien = substr($entry[1],strpos($entry[1],'<link>')+6);
					$nom = substr($entry[0],strpos($entry[0],' ')+1);
					ereg('([0-9]{1,2}).([0-9]{1,2})',$entry[0],$regs);
					
					if (($regs[2]) > $cur_month) {
						$date = ($cur_year-1) . sprintf("-%02d-%02d",$regs[2],$regs[1]);
					}	else	{
						$date = sprintf("$cur_year-%02d-%02d",$regs[2],$regs[1]);
					}
					$textall .= "NimpCrew\n$date $cot\n$nom\n$lien\n$reg\n\n";
				}
			}
			$fd=@fopen($txt,'w');
			@flock($fd,LOCK_EX);
			@fwrite($fd,$textall);
			@fclose($fd);
		}
		else touch($txt);
	}
	return TRUE;
}

// blms.free.fr
function update_BLMS($base = 'blms')
{
	global $dlim;
  global $SETTINGS;

	$txt = $SETTINGS['odir'] . "/$base.txt";
	$expire = 60*60;	// en secondes.
	
	if (@filemtime($web) > @filemtime($txt))
	{
		$textall = @file_get_contents('http://blms.free.fr/Dev_MBO/meta_nat.php');
		if ($textall !== FALSE)
		{
			$entries = explode('</tr>',$textall);
			$n = count($entries) - 2;
			$textall = '';
			for($i = 1; $i< $n; $i++)
			{
				$items = explode('</td>',$entries[$i]);
				$date = trim(strip_tags($items[0]));
				if ($date > $dlim)
				{
					$part = trim(strip_tags($items[1]));
					$reg = trim(strip_tags($items[2]));
					$nom = trim(strip_tags($items[3]));
					$cot = trim(strip_tags($items[4]));
					unset($regs);
					ereg('href="([^"]+)',$items[7],$regs);
					if ($regs[1]) {
						$lien = $regs[1];
					} else {
						$lien = 'http://blms.free.fr/Dev_MBO/liste.php?type1=ski';
					}
					$textall .= "BLMS\n$date $cot\n$nom\n$lien\n$reg\n$part\n";
				}
			}
			$fd=@fopen($txt,'w');
			@flock($fd,LOCK_EX);
			@fwrite($fd,$textall);
			@fclose($fd);
		}
		else touch($txt);
	}
	return TRUE;
}

function get_mois($mois)
{
	switch(substr($mois,0,1)) {
		case 'j' :	if (substr($mois,0,2) == 'ja') { $m = '01'; }
					elseif (substr($mois,0,4) == 'juin') { $m = '06'; }
					else { $m = '07'; }
					break;
		case 'm' :	if (substr($mois,0,3) == 'mai') { $m = '05'; }
					else { $m = '03'; }
					break;
		case 'a' :	if (substr($mois,0,2) == 'av') { $m = '04'; }
					else { $m = '08'; }
					break;
		case 'f' :	$m = '02'; break;
		case 's' :	$m = '09'; break;
		case 'o' :	$m = '10'; break;
		case 'n' :	$m = '11'; break;
		case 'd' :	$m = '12'; break;
		default :	$m = 0;
	}
	return $m;
}

// CAF Isere
function update_CAFisere($base = 'CAF38')
{
	global $dlim;
  global $SETTINGS;

	$web = $SETTINGS['odir'] . "/$base.web";
	$txt = $SETTINGS['odir'] . "/$base.txt";
	$expire = 60*60;	// en secondes.
	
	if (@filemtime($web) > @filemtime($txt))
	{
		$textall = @file_get_contents($web);
		if ($textall !== FALSE)
		{
			$entries = explode('<td colspan="2" class="normal">',$textall);
			$n = count($entries) -1;
			$textall = '';
			for($i = 1; $i< $n; $i++)
			{
				$p1 = strpos($entries[$i],'<strong>');
				$date = trim(strip_tags(substr($entries[$i],0,$p1)));
				$p2 = strpos($entries[$i],'</b>',$p1);
				$other = substr($entries[$i],$p1,$p2);
				$items = explode(' ',$date);
				$mois = get_mois($items[2]);
				$date = "{$items[3]}-$mois-{$items[1]}";
				if ($date > $dlim)
				{
					$items = explode('-',$other);
					$nom = trim(strip_tags($items[0]));
					$reg = trim(strip_tags($items[1]));
					$cot = trim(strip_tags($items[2]));
					$cot = trim($cot,'() ');
					$lien = "http://www.clubalpin-grenoble.com/crrandoski.php";
					$textall .= "CAF38\n$date $cot\n$nom\n$lien\n$reg\n\n";
				}
			}
			$fd=@fopen($txt,'w');
			@flock($fd,LOCK_EX);
			@fwrite($fd,$textall);
			@fclose($fd);
		}
		else touch($txt);
	}
}

function update_SNGM($base = 'SNGM')
{
  global $SETTINGS;

	$web = $SETTINGS['odir'] . "/$base.web";
	$txt = $SETTINGS['odir'] . "/$base.txt";
	$expire = 60*60;	// en secondes.
	$ftmp = "$txt.tmp";
	
	if ( @filemtime($web) > @filemtime($txt))
	{
		if ( $fd = @fopen($ftmp,'x+') )
		{
			$textall = @file_get_contents($web);
			if ($textall !== FALSE)
			{
				parse_SNGM($textall);
				fwrite($fd,$textall);
				fclose($fd);
				@unlink($txt);
				rename($ftmp,$txt);
			}
			else touch($txt);
		}
		elseif (time() > (@filemtime($ftmp) + 3600)) // efface le fichier tmp si ca fait trop longtemps...
			@unlink($ftmp);
	}
	return TRUE;
}

function update_Gulliver($base = 'gulliver')
{
  global $SETTINGS;

	$web  = $SETTINGS['odir'] . "/$base.sa.web";
	$web2 = $SETTINGS['odir'] . "/$base.sr.web";
	$txt  = $SETTINGS['odir'] . "/$base.txt";
	$expire = 60*60;	// en secondes.
	$buffer = '';
	$ftmp = "$txt.tmp";
	$ok = FALSE;
	
	if ( @filemtime($web) > @filemtime($txt)) {
	    if  ( $fd = @fopen($ftmp,'x+') )
	    {
		$textall = @file_get_contents($web2);
		if ($textall !== FALSE)
		{
			parse_Gulliver($textall);
			fwrite($fd,$textall);
			$ok = TRUE;
		}
		$textall = @file_get_contents($web);
		if ($textall !== FALSE)
		{
			parse_Gulliver($textall);
			fwrite($fd,$textall);
			$ok = TRUE;
		}
		
		if ($ok === TRUE)
		{
			fclose($fd);
			@unlink($txt);
			rename($ftmp,$txt);
		}
		else
		{
			touch($txt);
			unlink($ftmp);
		}
	    } elseif (time() > (@filemtime($ftmp) + 3600)) // efface le fichier tmp si ca fait trop longtemps...
		@unlink($ftmp);
	}
	return TRUE;
}


////////// PARSE FUNCTIONS ///////////////


//////////////////////////
// $textall = @file_get_contents('http://www.gulliver.it/scialpinismo/');
// renvoie dans $textall un buffer pret a etre ecrit dans le fichier cache.
function parse_Gulliver(&$textall)
{
	// on garde que la partie int?essante.
	$p1 = strpos($textall,'nome itinerario');
	$p2 = strpos($textall,'</table>',$p1);
	$textall = substr($textall,$p1,$p2-$p1);
	$entries = explode('</tr>',$textall);
	$n = count($entries)-1;
	$textall = '';

	for ($i = 2;$i<$n; $i++)
	{
		$items = explode('</td>',$entries[$i]);
    		$nom = explode('</a>', $items[2]);
    		$nom = trim(strip_tags($nom[0]));
		$cot = trim(strip_tags($items[4]));
		$date = trim(strip_tags($items[5]));
		// recupere l'ID de l'itinéraire (la sortie n'est pas directement disponible...)
		preg_match('/\/itinerario\/([0-9]+)\//i', $items[2], $regs);	$id = $regs[1];
		// recupere la region :
		unset($regs);
		if (preg_match_all('/\([^\)]+\)/',$items[2], $regs) > 0) {
			$reg2 = end($regs[0]);
			$nom = substr($nom, 0, - strlen($reg2) - 1);
			$reg = 'Italie ' . $reg2;
		} else {
			$reg='Italie';
		}
		// interprete la date :
		preg_match("/([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{2})/", $date, $regs);
		$date = sprintf("20%02d-%02d-%02d", $regs[3], $regs[2], $regs[1]);
		$textall .= "gulliver $id\n$date $cot\n$nom\nhttp://www.gulliver.it/itinerario/$id/\n$reg\n\n";
	}
}

//////////////////////////
// $textall = @file_get_contents('http://www.montagneinfo.net/flux/activites.php?NoIDActivite=11');
// renvoie dans $textall un buffer pret a etre ecrit dans le fichier cache.
function parse_SNGM(&$textall)
{
	$entries = explode('</item>',substr($textall,strpos($textall,'<item>')));
	$n = count($entries) - 1;
	$textall = '';
	for($i = 0; $i< $n; $i++)
	{
		$entry = explode('</',$entries[$i]);
		unset($regs);
		ereg('>([0-9]{2})/([0-9]{2})/([0-9]{4}) - (.*)',$entry[0],$regs);
		$date = "{$regs[3]}-{$regs[2]}-{$regs[1]}";
		$nom = htmlentities($regs[4],ENT_NOQUOTES,'UTF-8');
		$lien = substr($entry[1],strpos($entry[1],'<link>')+6);
		$reg = substr($entry[2],strpos($entry[2],'Massifs :')+10);
		$reg = substr($reg,0,strpos($reg,' Secteurs'));
		$reg = ucwords(strtolower(trim($reg)));
		$textall .= "SNGM\n$date\n$nom\n$lien\n$reg\n\n";
	}
}

// http://meta.camptocamp.org/outings/query?activity_ids=10&system_id=1&limit=200
/*   <item><title>Tête Pelouse : Voie Normale</title>
   		<pubDate>2007-11-26T12:00:00Z</pubDate>
   		<author>Camptocamp.org (Camptocamp.org)</author>
   		<description>HautGiffre-AigRouges , 2475m , skirando , PD-/S2 , NW , fr</description>
   		<link>http://www.camptocamp.org/outings/108464/fr</link>
   	</item>
*/

//////////////////////////
// $textall : contenu de "http://www.camptocamp.org/outings/list/orderby/date/order/desc/page/$page"
// $last_id : ne garde que les sorties dont l'id > $last_id
// renvoie dans $textall un buffer pret a etre ecrit dans le fichier cache.
//    et en return value : $new_id (l'id le plus recent).
function parse_Skirando(&$textall,$last_id)
{
	global $dlim;
// on garde que la partie interessante.
	$entries = explode('</tr>',substr($textall,strpos($textall,'<tbody>')));
	$textall = '';
	$new_id = $last_id;

	$n = count($entries)-1;
	for ($i = 0;$i<$n; $i++)
	{
		$items = explode('</td>',$entries[$i]);
		$lien = substr($items[1],strpos($items[1],'<a href="..')+9);
		$lien = substr($lien,0,strpos($lien,'">'));
		ereg('/outings/([0-9]+)',$lien,$regs);	$id = $regs[1];
		if ($id > $last_id)
		{
			$nom = trim(strip_tags($items[1]));
			$date = trim(strip_tags($items[2]));
			$cot = trim(strip_tags($items[6]));
			$reg = trim(strip_tags($items[9]));
			$part = trim(strip_tags($items[12]));
// interprete la date :
			$jma = explode(' ',$date);
			if (strlen($jma[0]) == 1) $jma[0] = "0{$jma[0]}";
			$date = "{$jma[2]}-" . get_mois($jma[1]) . "-{$jma[0]}";
// pour etre ecrit plus tard :
			if ($date < $dlim) break;	// pas plus vieux que 1 mois.
			$textall .= "c2c $id\n$date $cot\n$nom\nhttp://www.camptocamp.org/outings/$id\n$reg\n$part\n";
				if ($id > $new_id) $new_id = $id;
		}
	}
	return $new_id;
}

// cherche la cot d'une volo-course si dispo (et ajoute les participants !)
function volo_cot($url,&$parts)
{
	$textall = @file_get_contents($url);
	if ($textall === FALSE)
		return '';
		
	$textall = substr($textall,strpos($textall,'course_cmt'));
	$textall = substr($textall,0,strpos($textall,'</div>'));
	$items = explode('</p>',$textall);

// recupere les participants.
	if ( preg_match_all('/\b[A-Z]{3}\b/',$items[3],$regs) > 0)
	{
		$parts .= ' + ' . implode(' ',$regs[0]);
	}

// recupere la (ou les) cot.
	if ( preg_match_all('/\b[1-4][.][1-3]|\b5[.][1-6]/',$items[1],$regs) > 0 )
	{
		$cotmax = '0.0';
		$cotmin = '9.9';
		foreach($regs[0] as $ccot)
		{
			if ($ccot > $cotmax)
				$cotmax = $ccot;
			if ($ccot < $cotmin)
				$cotmin = $ccot;
		}
		if ($cotmin == $cotmax)
		{
			return $cotmin;
		}
		return "$cotmin-$cotmax";
	}
	return '';
}


//////////////////////////
// $textall = @file_get_contents('http://www.volopress.net/volo/spip.php?rubrique2');
// $last_id : ne garde que les sorties dont l'id > $last_id
// renvoie dans $textall un buffer pret a etre ecrit dans le fichier cache.
//    et en return value : $new_id (l'id le plus recent).
function parse_Volopress(&$textall,$last_id)
{
// on garde que la partie intéressante.
	$textall = substr($textall,strpos($textall,'row_first'));
	$textall = substr($textall,0,strpos($textall,'</table>'));
	$volo = explode('</tr>',$textall);
	$textall = '';
	
	$new_id = $last_id;
	for ($i=1; $i<25; $i++)
	{
		$items = explode('</td>',$volo[$i]);
		ereg("sortie([0-9]+)[.]html",$items[1],$regs);
		$id = $regs[1];
		if ($id > $last_id)
		{
			$date = trim(strip_tags($items[0]));
			$lien = "http://www.volopress.net/volo/sortie$id.html";
			
			$pos = strpos($items[1],'</span>');
			$nom = htmlentities(trim(strip_tags(substr($items[1],0,$pos))),ENT_NOQUOTES,'UTF-8');
			$voie = htmlentities(trim(strip_tags(substr($items[1],$pos)),', '),ENT_NOQUOTES,'UTF-8');

			$reg = htmlentities(trim(strip_tags($items[2])),ENT_NOQUOTES,'UTF-8');
			$part = trim(strip_tags($items[4]));
		// recupere la cot (et les participants) :
//			$cot = volo_cot($lien, $part);
			$cot = '';
			$textall .= "volo $id\n$date $cot\n$nom, $voie\n$lien\n$reg\n$part\n";
			if ($id > $new_id) $new_id = $id;
		}
		else break;
	}
	return $new_id;
}


//////////////////////////
// $textall = @file_get_contents('http://www.skitour.fr/topos/?nbr=50&p=1');
// $last_id : ne garde que les sorties dont l'id > $last_id
// renvoie dans $textall un buffer pret a etre ecrit dans le fichier cache.
//    et en return value : $new_id (l'id le plus recent).
function parse_Skitour(&$textall,$last_id)
{
	global $dlim;
// on garde que la partie int?essante.
	$entries = explode('</tr>',substr($textall,strpos($textall,'<table class="topos">')));
	$textall = '';

// extrait l'ID de la derniere sortie.
//	ereg(',([0-9]+)',$entries[1],$regs);	$new_id = $regs[1];

//	if ($new_id > $last_id)		// si on a du nouveau ...
	{
		$n=count($entries)-1;
		for($i=1;$i<$n;$i++)
		{
			$items = explode('</td>',$entries[$i]);
			$lien = substr($items[1],strpos($items[1],'<a href="..')+11);
			$lien = substr($lien,0,strpos($lien,'">'));
// extrait l'ID de la sortie.
//			$id = strip_tags($items[0]);
			ereg(',([0-9]+)',$lien,$regs);	$id = $regs[1];
			if ($id > $last_id)
			{
				$nom = trim(strip_tags($items[1]));
				$alt = trim(strip_tags($items[2]));
				$voie = trim(strip_tags($items[3]));
				if (substr($voie,0,8) == 'Variante') {
					$voie = substr($voie, 11);
				} else $voie = "$nom, $voie";
				$reg = trim(strip_tags($items[4]));
				$cot = trim(strip_tags($items[6]));
				$part = trim(strip_tags($items[7]));
				$date = trim(strip_tags($items[8]));
// interprete la date :
				ereg ("([0-9]{2}).([0-9]{2}).([0-9]{2})", $date, $regs);
				$date = "20{$regs[3]}-{$regs[2]}-{$regs[1]}";
// pour etre ecrit plus tard :
				if ($date < $dlim) break;	// pas plus vieux que 1 mois.
				$textall .= "skitour $id\n$date $cot\n$voie\nhttp://www.skitour.fr$lien\n$reg\n$part\n";
				if ($id > $new_id) $new_id = $id;
			}
		}
	}
	return $new_id;
}


//////////////////////////
// $textall = @file_get_contents('http://www.bivouak.net/index.php?id_sport=1');
// $last_id : ne garde que les sorties dont l'id > $last_id
// renvoie dans $textall un buffer pret a etre ecrit dans le fichier cache.
//    et en return value : $new_id (l'id le plus recent).
function parse_Bivouak(&$textall,$last_id)
{
	global $dlim;
	$cur_month = date('m');	$cur_year = date('Y');
// on garde que la partie int?essante.
	$textall = substr($textall,strpos($textall,'titre_dernieres_sorties.gif'));
	$textall = substr($textall,0,strpos($textall,'</table>'));
	$entries = explode('</tr>',$textall);
	$textall = '';

// extrait l'ID de la sortie.
	ereg('-([0-9]+)-sport-1',$entries[3],$regs);	$new_id = $regs[1];
	if ($new_id > $last_id)
	{
		$n = count($entries)-1;
		for ($i = 3;$i<$n; $i++)
		{
			$items = explode('</td>',$entries[$i]);
			$start = strpos($items[1],'<a href="..') + 11;
			$stop = strpos($items[1],'" >',$start);
			$lien = substr($items[1],$start,$stop - $start);
// extrait l'ID de la sortie.
			ereg('-([0-9]+)-sport-1',$lien,$regs);		$id = $regs[1];
			if ($id > $last_id)
			{
				$date = trim(strip_tags($items[0]));
				$nom = trim(strip_tags($items[1]));
				$reg = trim(strip_tags($items[2]));
				$cot = trim(strip_tags($items[3]));
				$part = trim(strip_tags($items[4]));
// interprete la date :
				ereg ("([0-9]{2}).([0-9]{2})", $date, $regs);
				if (($regs[2]) > $cur_month) {
					$date = ($cur_year-1) . "-{$regs[2]}-{$regs[1]}";
				}	else	{
					$date = "$cur_year-{$regs[2]}-{$regs[1]}";
				}
				if ($date < $dlim) break;	// pas plus vieux que 1 mois.
				$textall .= "bivouak $id\n$date $cot\n$nom\nhttp://www.bivouak.net$lien\n$reg\n$part\n";
				if ($id > $new_id) $new_id = $id;
			}
		}
	}
	return $new_id;
}

//////////////////////////
// $textall = @file_get_contents('http://www.ohm-chamonix.com/HIV/OHMCourListe.php');
// $last_id : ne garde que les sorties dont l'id > $last_id
// renvoie dans $textall un buffer pret a etre ecrit dans le fichier cache.
//    et en return value : $new_id (l'id le plus recent).
function parse_OHM(&$textall,$last_id)
{
	global $dlim;
// on garde que la partie int?essante.
	$textall = substr($textall,strpos($textall,'<table class="cahierBG"'));
	$start = strpos($textall,'<tr>');
	$stop = strpos($textall,'</table>');
	$textall = substr($textall,$start,$stop-$start);
	$entries = explode('<tr>',$textall);
	$n = count($entries);
	$textall = '';
	
	$new_id = $last_id;
	for ($i = 1;$i<$n; $i++)
	{
		$items = explode('</td>',$entries[$i]);
		if (strpos($items[2],'ski') !== FALSE)
		{	// skirando ? on affiche !
			$date = trim(strip_tags($items[0]));
			$part = trim(strip_tags($items[3]));
			$nom = trim(strip_tags($items[1]));
// recupere l'ID :
			eregi('course=([0-9]+)',$items[1],$regs);	$id = $regs[1];
			if ( ($id > $last_id) && ($date >= $dlim) )
			{	// r?up?e le massif :
				$lien = "http://www.ohm-chamonix.com/fiche.php?id=01&course=$id&ling=Fr";
				$detail = @file_get_contents($lien, "r");
				$detail = substr($detail,strpos($detail,'<table class="cahierBG"'));
				$detail = substr($detail,strpos($detail,'</tr>'),strpos($detail,'</table>'));
				$det_it = explode('</td>',$detail);
				$reg = ucwords(strtolower(trim(strip_tags($det_it[1]))));
				$up = trim(strip_tags($det_it[12]));
				$dn = trim(strip_tags($det_it[13]));
				$textall .= "OHM $id\n$date\n$nom ($up / $dn)\n$lien\n$reg\n$part\n";
				if ($id > $new_id) $new_id = $id;
			}
		}
	}
	return $new_id;
}


/////////// RESET FUNCTIONS /////////

function reset_Skitour($nread = 500, $base = 'skitour' )
{
  global $SETTINGS;

	$txt  = $SETTINGS['odir'] . "/$base.txt";
	$last = $SETTINGS['odir'] . "/$base.last";
	$ftmp = "$txt.tmp";

	echo "<p>Indexing skitour.fr ...";
	if ( $fd = @fopen($ftmp,'x') )		// pas d'autre tentative ?
	{
		fclose($fd);
		$textall = @file_get_contents("http://www.skitour.fr/topos/dernieres-sorties.php?nbr=$nread");
		$retry = 0;
		while (($textall === FALSE)&&($retry < 3))	// echec de temps en temps, r?ssaye 3 fois.
		{
			echo ' retry...';
			sleep(2);
			$textall = @file_get_contents('http://www.skitour.fr/topos/dernieres-sorties.php?nbr=$nread');
			$retry++;
		}
		if ($textall !== FALSE)
		{
			$new_id = parse_Skitour($textall,0);
			$fd=@fopen($ftmp,'w');
			@fwrite($fd,$textall);
			@fclose($fd);
			$fd=@fopen($last,'w');	@fwrite($fd,$new_id);	@fclose($fd);
			@unlink($txt);
			rename($ftmp,$txt);
			echo ' done.</p>';
		}
		else
		{
			echo ' failed !</p>';
			unlink($ftmp);
		}
//		cleanup_cache($txt);
	}
}

function reset_Skirando($nread = 120, $base = 'c2c' )
{
  global $SETTINGS;

	$txt  = $SETTINGS['odir'] . "/$base.txt";
	$last = $SETTINGS['odir'] . "/$base.last";
	$ftmp = "$txt.tmp";

	echo "<p>Indexing camptocamp.org ...";
	if ( $fd = @fopen($ftmp,'x') )		// pas d'autre tentative ?
	{
		fclose($fd);
//		$textall = file_get_contents('http://meta.camptocamp.org/outings/query?activity_ids=10&system_id=1&limit=500');
		$textall = file_get_contents($SETTINGS['odir'] . "/$base.web");
		echo $textall;
		$new_id = 0;
		$new_id = parse_Skirando($textall,$new_id);
		$fd=@fopen($ftmp,'a');
		@fwrite($fd,$textall);
		@fclose($fd);
		$fd = @fopen($last,'w');	@fwrite($fd,$new_id);	@fclose($fd);
		@unlink($txt);
		rename($ftmp,$txt);
		echo ' done.</p>';
	}
}

// FIND FUNCTIONS ...
function kick_zeurch($keys, $str_data)
{
	foreach($keys as $key)
	{
		if ( !eregi($key,$str_data) )
			return FALSE;
	}
	return TRUE;
}

function sans_accent($chaine)
{
   $accent  ="ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿ";
   $noaccent="aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyyby";
   return strtr(trim($chaine),$accent,$noaccent);
} 

?>
