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
	header("Content-type: text/xml");
	echo '<?xml version="1.0" encoding="iso-8859-1"?><rss version="0.91">';
?>

<channel>
<title>Les dernières sorties de ski de rando</title>
<link>http://metaskirando.free.fr/</link>
<language>fr-FR</language>

<?php
	extract($_GET);
	require "sites.inc.php";
	
	if ( (empty($_GET['site'])) || ($_GET['site'] == 'all') )
	{
		load_All($sorties);
	}
	else
	{
		if (stristr($site,'nimp'))
			load_cache('nimpcrew',$sorties);
		if (stristr($site,'sngm'))
			load_cache('SNGM',$sorties);
		if (stristr($site,'blms'))
			load_cache('blms',$sorties);
		if (stristr($site,'CAF3'))
			load_cache('CAF38',$sorties);
		if (stristr($site,'gull'))
			load_cache('gulliver',$sorties);
		if (stristr($site,'volo'))
			loadclean_cache('volo',$sorties);
		if (stristr($site,'sktr'))
			loadclean_cache('skitour',$sorties);
		if (stristr($site,'skrd'))
			loadclean_cache('c2c',$sorties);
		if (stristr($site,'bivk'))
			loadclean_cache('bivouak',$sorties);
		if (stristr($site,'ohm'))
			loadclean_cache('OHM',$sorties);
	}
	
	if (isset($_GET['days']))
	{
		$dlim = date('Y-m-d',time()-$days*24*3600);
	}

if (empty($sorties))
{
	echo "<item><title>Pas de sorties pour ce(s) site(s).</title></item></channel></rss>";
	exit();
}

	foreach($sorties as $data)
	{
		$is_ok = true;
		if ($data['date'] <= $dlim)
			$is_ok = false;
		elseif ( (!empty($_GET['zon'])) && (!eregi($_GET['zon'],$data['reg'])) )
			$is_ok = false;
		elseif ( (!empty($_GET['aut'])) && (!eregi($_GET['aut'],$data['part'])) )
			$is_ok = false;
		elseif ( (!empty($_GET['cotmin'])) ) //&& (!eregi('volo|ohm|sngm',$data['site'])) )
		{
			$cot = substr($data['cot'],0,1);
			switch($cot) {
				case '1' : case '2' : case '3' : case '4' : case '5' : break;
				case 'F' : $cot = 1; break;
				case 'P' : $cot = 2; break;
				case 'A' : $cot = 3; break;
				case 'D' : $cot = 4; break;
				case 'T' : $cot = 5; break;
				case 'E' : if ( substr($data['cot'],1,1) == 'D' ) { $cot = 5; break; }
				default : $cot = 2;
			}
			if ($cot < $_GET['cotmin'])
				$is_ok = false;
		}

		if ($is_ok)
			$found[] = $data;
	}

if (empty($found))
{
	echo "<item><title>Pas de sorties récentes pour ce filtre.</title></item>\n";
}
else
{
	rsort($found);

	$nmax = min(count($found),100);
	if (!empty($_GET['nbr']))
		$nmax = min($nmax,$_GET['nbr']);

	for ($i=0; $i<$nmax; $i++)
	{
		$date = $found[$i]['date'];
		$nom = html_entity_decode($found[$i]['nom'],ENT_QUOTES);
		$site = $found[$i]['site'];
		$reg = html_entity_decode($found[$i]['reg'],ENT_QUOTES);
		$part = html_entity_decode($found[$i]['part'],ENT_QUOTES);
		$lien = str_replace('&','&amp;',$found[$i]['lien']);
		$cot = trim(html_entity_decode($found[$i]['cot'],ENT_QUOTES));
		if ($cot != '')
			$cot = ", $cot";
		
		echo "<item><title>$date: $nom ($reg)$cot</title>\n";
		echo "<link>$lien</link>\n";
		echo "<description>par $part [$site]</description></item>\n\n";
	}
}

?>
</channel>
</rss>
