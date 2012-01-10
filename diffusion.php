<?php /*
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
*/ ?>
<html>
<head>
<title>Meta-Skirando : diffusion</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="description" content="Le moteur de recherche du Ski de Rando. Les conditions de neige pour le ski de randonnée en France et ailleurs !" />
<meta name="keywords" content="ski de rando, ski alpinisme, ski extrême, pente raide, alpes, pyrénées, neige, météo, skitour, skirando, blms, nimp crew, volopress, ohm chamonix, sngm, bivouak" />
<link href="style.css" rel="stylesheet" type="text/css" />
<?php

extract($_GET);

require "sites.inc.php";

if (isset($_GET['go']))
{
	if (count($site) >= 8) {
		$sites = 'all';
	} elseif (!empty($site)) {
		$sites = implode('+',$site);
	}
	if ((empty($_GET['zon']))&&(!empty($zonA)))
		$zon = implode('|',$zonA);
	$lien = "ski_rss.php?days=$days&nbr=$nbr";
	if (!empty($sites))
		$lien .= "&site=$sites";
	if (!empty($zon))
		$lien .= "&zon=$zon";
	if (!empty($part))
		$lien .= "&aut=$part";
	if (!empty($cotmin))
		$lien .= "&cotmin=$cotmin";
}
else
	$lien = 'ski_rss.php';

echo "<link href=\"$lien\" rel=\"alternate\" type=\"application/rss+xml\" title=\"Les dernieres sorties de ski de rando\" />\n";

echo '</head><body>';

include 'menu.inc';

?>



<!--
<p class="menu"><span class="menu">
<a href="index.php">Accueil</a> ||
<a href="prefs.php" title="D&eacute;finir mes pr&eacute;f&eacute;rences">Pr&eacute;f&eacute;rences</a></span></p>
-->



<div style="position: absolute; top: 0px; right: 0px;"><img src="gfx/surf_small2.png"></div>
<div style="padding: 40px 50px; float: right;">&nbsp;</div>

<h1>Diffusez Meta-Skirando !</h1>
<p>
Pour cela, plusieurs possibilités pour votre site :
<ul>
	<li>Mettre un lien vers Méta-Skirando (facile !)</li>
	<li>Mettre en place une <a href="#box">boite de recherche</a> (pratique !)</li>
	<li>Afficher des sorties via RSS (enrichissez le contenu de votre site !)</li>
</ul>
</p>

<h2>Le flux RSS du Ski de
Rando :</h2>
<p>Affichez les sorties de ski de rando qui vous intéressent sur votre site (à l'aide d'un <a href="http://www.globalsyndication.com/rss-parser">petit script PHP</a>), mais aussi sur l'acceuil personalisé de google ! <br>
Exemples :
<ul>
<li>Il est possible de récupérer les sorties dont vous êtes l'auteur sur le site où vous contribuez.</li>
<li>Si vous êtes fan de LTA chez volopress et de David Zijp chez skitour, récupérez juste leurs sorties ! (en sélectionnant les sites "volopress" et "skitour" et dans le champs auteurs "LTA|David Zijp"</li>
<li>Vous avez un site web régional : affichez toutes les dernieres sorties sur cette région !</li>
</ul>
</p>

<?php

if (isset($_GET['go']))
{
	echo "\n\n<p><b>Voici le fil RSS correspondant à cette requête :</b> <a href=\"$lien\">$lien</a></p>\n\n";
}

	load_All($sorties);
	$regs = make_region_list($sorties);

?>

<form method="get">
<table style="width: 100%; text-align: left;" cellpadding="5" cellspacing="2">
<tbody>
<tr bgcolor="#ccccff">

<td style="width: 50%; vertical-align: top;"><b>Sites :</b><br>
<div style="margin-left: 5%;">
<select size="4" name="site[]" multiple="multiple">
<option value="all">* tous * </option>
<option value="skrd">camptocamp.org </option>
<option value="sktr">skitour.fr </option>
<option value="bivk">bivouak.net </option>
<option value="volo">volopress.fr </option>
<option value="sngm">montagneinfo.net (SNGM) </option>
<option value="ohm">OHM-Chamonix </option>
<option value="nimp">Nimp'Crew </option>
<option value="blms">BLMS </option>
</select>
</div><br>

<b>Auteurs :</b> <input size="20" name="part" type="text"><br>
<div style="margin-left: 5%;">(<i>expression r&eacute;guli&egrave;re : plusieurs auteurs sont &agrave; s&eacute;parer par</i> | )
</div><br>

<b>Difficult&eacute; :</b> &agrave; partir de
<select name="cotmin">
<option value="">1.1 (ou F) </option>
<option value="2">2.1 (ou PD-) </option>
<option value="3">3.1 (ou AD-) </option>
<option value="4">4.1 (ou D-) </option>
<option value="5">5.1 (ou TD-) </option>
</select>
<br>
<br>
Afficher au plus
<select name="nbr">
<option value="10">10 </option>
<option value="20">20 </option>
<option value="30">30 </option>
<option value="50">50 </option>
<option value="100">100 </option>
</select>
sorties sur les
<select name="days">
<option value="3">3 </option>
<option value="7">7 </option>
<option value="15">15 </option>
<option value="21">21 </option>
<option value="31">31 </option>
</select>
derniers jours. </td>
<td style="width: 50%;"><b>R&eacute;gions :</b><br>
<div style="margin-left: 5%;">S&eacute;lectionner dans la
liste : (<i>selection multiple avec la touche</i> ctrl)<br>
<select size="8" name="zonA[]" multiple="multiple">
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
		$key = $regs[$i]['key'];
		echo "<option value=\"$key\">$nom </option>\n";
	}
?>
</select>
<br>
ou sp&eacute;cifier un filtre : <br>
<input size="40" name="zon"><br>
(<i>expression r&eacute;guli&egrave;re :
plusieurs r&eacute;gions sont &agrave; s&eacute;parer par</i> |
)</div>
</td>
</tr>
</tbody>
</table>
<div style="text-align: center;"><br>
<input name="go" value="Oui, c'est &ccedil;a !" type="submit"> </div>
</form>

<hr>

<h2><a name="box">Les boites de recerche :</a></h2>
<table cellpadding="5" width="100%">
<tbody>
<tr>
<td width="50%">La boite <i>Kick Zeurch</i>, qui effectue une
recherche sur tous les champs (site, auteur, itin&eacute;raire,
r&eacute;gion) sur tout ou une partie d'un mot.<br>
</td>
<td width="50%">La boite <i>R&eacute;gion</i>, qui effectue une
recherche par r&eacute;gions. Vous pouvez y mettre les
r&eacute;gions qui vous plaisent !<br>
</td>
</tr>
<tr bgcolor="#ccccff">
<td>
<div style="text-align: center;"> </div>
<form method="get" action="http://metaskirando.free.fr/index.php">
<div style="text-align: center;"><i>Kick
Zeurch</i> :<br>
&nbsp;<input title="rechercher une sortie avec M&eacute;ta-skirando" size="20"
name="str" type="text"> <br>
<input name="kz" value="Quoi de neuf ?" type="submit"></div>
</form>
</td>
<td style="text-align: center;">
<form method="get" name="msr-regs"
action="http://metaskirando.free.fr/index.php"><b>Massif
:<br>
&nbsp;</b>
<select name="zon"
onchange="document.forms['msr-regs'].submit()">
<option value=""></option>
<option value="Aravis|Bornes">Aravis-Bornes</option>
<option value="Belledonne">Belledonne</option>
<option value="Beaufort">Beaufortain</option>
<option value="voluy">D&eacute;voluy</option>
<option value="Pyr">Pyr&eacute;n&eacute;es</option>
</select>
</form>
</td>
</tr>
</tbody>
</table>
<p>Le code <i>Kick Zeurch</i> &agrave; copier dans votre page web :
</p>
<pre>&lt;form method="get" action="http://metaskirando.free.fr/index.php"&gt;<br>&lt;i&gt;Kick Zeurch&lt;/i&gt; :&lt;br&gt;<br>&lt;input title="rechercher une sortie avec M&eacute;ta-skirando" size="20" name="str" type="text"&gt;<br>&lt;br&gt;&lt;input name="kz" value="Quoi de neuf ?" type="submit"&gt;<br>&lt;/form&gt;</pre>
<p>Le code <i>R&eacute;gions</i> &agrave; copier dans votre page web,
et &agrave; personaliser avec vos r&eacute;gions :</p>
<pre>&lt;form method="get" name="msr-regs" action="http://metaskirando.free.fr/index.php"&gt;<br>&lt;b&gt;Massif&lt;/b&gt; :&lt;br&gt;<br>&lt;select name="zon" onchange="document.forms['msr-regs'].submit()"&gt;<br> &lt;option value=""&gt;&lt;/option&gt;<br> &lt;option value="Aravis|Bornes"&gt;Aravis-Bornes&lt;/option&gt;<br> &lt;option value="Belledonne"&gt;Belledonne&lt;/option&gt;<br> &lt;option value="Beaufort"&gt;Beaufortain&lt;/option&gt;<br> &lt;option value="voluy"&gt;D&eacute;voluy&lt;/option&gt;<br> &lt;option value="Pyr"&gt;Pyr&eacute;n&eacute;es&lt;/option&gt;<br>&lt;/select&gt;&lt;/form&gt;<br></pre>
<br>

<?php include 'bottom.inc'; ?>

</body></html>
