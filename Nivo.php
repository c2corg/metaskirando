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
*/

require_once('./settings.inc.php');

 ?>
<html>
<head>
<title>Meta-Skirando : Nivoses et Météo dans les Alpes.</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="style.css" rel="stylesheet" type="text/css">
<meta name="description" content="Le moteur de recherche du Ski de Rando. Les nivoses de météo france et les bulletins d'avalanche. Prévisions météo montagne dans les Alpes" />
<meta name="keywords" content="ski de rando, ski alpinisme, ski extrême, pente raide, alpes, pyrénées, neige, météo" />
<link rel="canonical" href="http://metaskirando.camptocamp.org/Nivo.php" />
</head>
<body>

<?php include 'menu.inc'; ?>

<h1>Nivologie et précautions</h1>

<p>
<b>En ski de rando, on s'expose à des risques.</b> Une bonne expérience de la montagne, de la neige et un équipement spécial (Arva/Pelle/Sonde) sont nécessaires pour évoluer avec un minimum de sécurité.
Consultez les conseils pratiques et le petit traité de nivologie de l'<a href="http://www.anena.org/">Anena</a>.<br>
Le site camptocamp.org a regroupé beaucoup d'infos sur la neige et les avalanches, en particulier des <a href="http://www.camptocamp.org/articles/107439/fr/neige-et-avalanches-les-ressources-du-net">témoignages d'accidents</a>.<br>
N'hésitez pas à sortir avec des organismes spécialisés (comme le CAF), qui vous formeront à être autonomes.<br>
</p>

<h1><a name='meteo'></a>Prévisions et Observations</h1>

<ul>
<li>Bulletins d'avalanches de Météo France
<?php
	function bra_link_list($deps) {
		foreach ($deps as $dep) {
			if ($dep[0] != 'A') {
				$dep_code = "DEPT$dep";
			} else $dep_code = "ANDORRE";
			echo "<a href=\"http://www.meteofrance.com/previsions-meteo-montagne/bulletin-avalanches/d/AV$dep_code\">$dep</a> ";
		}
	}
?>
<ul><li>Alpes : <?php bra_link_list(array('04','05','06','38','73','74')); ?></li>
<li>Pyrénées : <?php bra_link_list(array('09','31','64','65','66','Andorre')); ?></li>
<li>Corse : <?php bra_link_list(array('2A','2B')); ?></li>
</ul>
<li>Bulletins d'avalanches <a href="http://www.slf.ch/laworg/tab.html">ailleurs en europe</a></li>
<li>Prévisions météo : <a href="http://geo.hmg.inpg.fr/caplain/meteo/mto38.shtml">Caplain</a>, <a href="http://www.meteo-alpes.fr/">Alpes</a>, <a href="http://meteo.chamonix.com/MetPre.php3">Chamonix</a>,
	<a href="http://www.inln.cnrs.fr/meteo.php3">INLN</a>
 et <a href="http://www.meteofrance.com/FR/index.jsp">MeteoCrash.fr</a>. D'autres liens météo sur <a href="http://www.meteo-chamonix.org/">meteo-chamonix.org</a>.
</li>
<li>Observations Météo en temps réel : <a href="http://www.meteociel.fr/">Météociel</a> et <a href="http://www.infoclimat.fr/accueil/">infoclimat</a>.
</li>
<!--
<li>Précipitations sur les reliefs (brut de Météo France, 1mm d'eau correspond à 1cm de neige environ) :
<ul>
<li>Alpes : <a href="http://www.meteo.fr/temps/scm/images/alp/ws06p00xxalp.gif">J-1</a>, <a href="http://www.meteo.fr/temps/scm/images/alp/ws06p24xxalp.gif">J</a>, <a href="http://www.meteo.fr/temps/scm/images/alp/ws06p48xxalp.gif">J+1</a></li>
<li>Pyrénées : <a href="http://www.meteo.fr/temps/scm/images/pyr/ws06p00xxpyr.gif">J-1</a>, <a href="http://www.meteo.fr/temps/scm/images/pyr/ws06p24xxpyr.gif">J</a>, <a href="http://www.meteo.fr/temps/scm/images/pyr/ws06p48xxpyr.gif">J+1</a></li>
</ul>
</li>
<li>Enneigement dans <a href="http://www.meteo.fr/temps/scm/wcalpa.htm">les Alpes</a> et dans <a href="http://www.meteo.fr/temps/scm/wcpyra.htm">les Pyrénées</a>, comparés aux moyennes (brut de Météo France)
</li>
-->
</ul>

<h1><a name='nivo'></a>Stations automatiques</h1>

Les stations automatiques de Météo France sont disséminées dans les montagnes et donnent de précieuses informations sur les chutes de neige, les températures et le vent, en différents endroits :
<ul>
<li><b>Autour de Grenoble</b> : <a href="#Bel">Belledonne</a>, <a href="#Ecr">Ecrins</a>, <a href="#Ver">Vercors</a>, <a href="#Cha">Chartreuse</a></li>
<li><b>Alpes du Nord</b> : <a href="#Aig">Aiguilles Rouges</a>, <a href="#Bau">Bauges</a>, <a href="#Bea">Beaufortain</a>, <a href="#Van">Vanoise</a>, <a href="#Mau">Haute-Maurienne</a>, <a href="#Tar">Haute-Tarentaise</a>, <a href="#Tha">Thabor</a></li>
<li><b>Alpes du Sud</b> : <a href="#Ech">Champsaur</a>, <a href="#Que">Queyras</a>, <a href="#Par">Parpaillon</a>, <a href="#Uba">Ubaye</a>, <a href="#Mer">Mercantour</a></li>
<li><b>Pyrénées</b> : <a href="#PyE">Orientales</a>, <a href="#PyC">Centrales</a>, <a href="#Big">Haute Bigorre</a>, <a href="#PyW">Occidentales</a></li>
<li><b>Corse</b> : <a href="#Cor">Cinto-Rotondo</a></li>
</ul>

<?php
// Parsing mf data.
	$links = file($SETTINGS['odir'] . '/nivo_links.web');
  foreach ($links as $line) {
    if (preg_match('/(ZONE_.*):"(.*)"/', $line, $matches)) {
      ${$matches[1]} = $matches[2];
    }
  }

?>

<center>
<p><a name='Bel' href='<?php echo $ZONE_AIGLE ?>'><img border='1' src='<?php echo $ZONE_AIGLE ?>'></a>
<br><b>Belledonne</b>, sur le Plat du Pin, au-dessus du Rivier d'Allemont, en montant vers le Pic de la Belle Etoile [ <a href="<?php echo $ZONE_AIGLE_SAI ?>">saison</a> ]
</p>
<p><a name='Ecr' href='<?php echo $ZONE_ECRIN ?>'><img border='1' src='<?php echo $ZONE_ECRIN ?>'></a><a href='<?php echo $ZONE_MEIJE ?>'><img border='1' src='<?php echo $ZONE_MEIJE ?>'></a>
<br><b>Ecrins</b>, sur la morraine du glacier de Bonnepierre, non-loin du dôme des Ecrins  [ <a href="<?php echo $ZONE_ECRIN_SAI ?>">saison</a> ] + dans les vallons de la Meije, au-dessus de la Grave (?)  [ <a href="<?php echo $ZONE_MEIJE_SAI ?>">saison</a> ]
</p>
<p><a name='Ver' href='<?php echo $ZONE_LEGUA ?>'><img border='1' src='<?php echo $ZONE_LEGUA ?>'></a><br>
<b>Vercors</b>, commune de Le Gua (à côté du couloir des Sultanes)  [ <a href="<?php echo $ZONE_LEGUA_SAI ?>">saison</a> ]
</p>
<p><a name='Cha' href='<?php echo $ZONE_STHIL ?>'><img border='1' src='<?php echo $ZONE_STHIL ?>'></a><a href="<?php echo $ZONE_PORTE ?>"><img border='1' src="<?php echo $ZONE_PORTE ?>"></a>
<br>
<b>Chartreuse</b>, commune de St-Hilaire du Touvet (1700m) + Col de Porte [ <a href="<?php echo $ZONE_PORTE_SAI ?>">saison</a> ] - Centre d'Etude de la Neige (1325m)  [ <a href="<?php echo $ZONE_PORTE_SAI ?>">saison</a> ]
</p>

<p><a name='Bau' href="<?php echo $ZONE_ALLAN ?>"><img border='1' src="<?php echo $ZONE_ALLAN ?>"></a><br>
<b>Bauges</b>, plan de la Limace (1630m)  [ <a href="<?php echo $ZONE_ALLAN_SAI ?>">saison</a> ]
</p>

<p><a name='Aig' href='<?php echo $ZONE_AIGRG ?>'><img border='1' src='<?php echo $ZONE_AIGRG ?>'></a><br>
<b>Aiguilles Rouges</b>, En face du Mont Blanc  [ <a href="<?php echo $ZONE_AIGRG_SAI ?>">saison</a> ]
</p>
<p><a name='Bea' href='<?php echo $ZONE_GRPAR ?>' title='#IM7'><img border='1' src='<?php echo $ZONE_GRPAR ?>'></a><br>
<b>Beaufortain</b>, les Saisies ? [ <a href="<?php echo $ZONE_GRPAR_SAI ?>">saison</a> ]
</p>
<p><a name='Van' href='<?php echo $ZONE_BELLE ?>'><img border='1' src='<?php echo $ZONE_BELLE ?>'></a><br>
<b>Vanoise</b>, La Plagne [ <a href="<?php echo $ZONE_BELLE_SAI ?>">saison</a> ]
</p>
<p><a name='Mau' href='<?php echo $ZONE_BONNE ?>'><img border='1' src='<?php echo $ZONE_BONNE ?>'></a><br>
<b>Haute-Maurienne</b>, Bonneval-sur-Arc. [ <a href="<?php echo $ZONE_BONNE_SAI ?>">saison</a> ]
</p>
<p><a name='Tar' href='<?php echo $ZONE_CHEVR ?>'><img border='1' src='<?php echo $ZONE_CHEVR ?>'></a><br>
<b>Haute Tarentaise</b>, lac du Chevril ? [ <a href="<?php echo $ZONE_CHEVR_SAI ?>">saison</a> ]
</p>
<p><a name='Tha' href='<?php echo $ZONE_ROCHI ?>'><img border='1' src='<?php echo $ZONE_ROCHI ?>'></a><br>
<b>Thabor</b>, les Rochilles ?  [ <a href="<?php echo $ZONE_ROCHI_SAI ?>">saison</a> ]
</p>

<p><a name='Ech' href='<?php echo $ZONE_ORCIE ?>'><img border='1' src='<?php echo $ZONE_ORCIE ?>'></a><br>
<b>Champsaur</b>, Orcières. [ <a href="<?php echo $ZONE_ORCIE_SAI ?>">saison</a> ]
</p>
<p><a name='Que' href='<?php echo $ZONE_AGNEL ?>'><img border='1' src='<?php echo $ZONE_AGNEL ?>'></a><br>
<b>Queyras</b>, col Agnel.  [ <a href="<?php echo $ZONE_AGNEL_SAI ?>">saison</a> ]
</p>
<p><a name='Par' href="<?php echo $ZONE_PARPA ?>"><img border='1' src="<?php echo $ZONE_PARPA ?>"></a><br>
<b>Parpaillon</b> - Embrunais. [ <a href="<?php echo $ZONE_PARPA_SAI ?>">saison</a> ]
</p>
<p><a name='Uba' href='<?php echo $ZONE_RESTE ?>'><img border='1' src='<?php echo $ZONE_RESTE ?>'></a><br>
<b>Ubaye</b>, Restefond. [ <a href="<?php echo $ZONE_RESTE_SAI ?>">saison</a> ]
</p>
<p><a name='Mer' href="<?php echo $ZONE_MILLE ?>"><img border='1' src="<?php echo $ZONE_MILLE ?>"></a><br>
<b>Mercantour</b>, Lac des Millefonts [ <a href="<?php echo $ZONE_MILLE_SAI ?>">saison</a> ]
</p>

<p><a name='PyE' href='<?php echo $ZONE_CANIG ?>'><img border='1' src='<?php echo $ZONE_CANIG ?>'></a>
<a href="<?php echo $ZONE_PUIGN ?>"><img border='1' src="<?php echo $ZONE_PUIGN ?>"></a>
<br>
<b>Pyrénées Orientales</b>, Canigou [ <a href="<?php echo $ZONE_CANIG_SAI ?>">saison</a> ] + Puigmal  [ <a href="<?php echo $ZONE_PUIGN_SAI ?>">saison</a> ]
</p>

<p>
<a href="<?php echo $ZONE_HOSPI ?>"><img border='1' src='<?php echo $ZONE_HOSPI ?>'></a>
<a href='<?php echo $ZONE_PAULA ?>'><img border='1' src='<?php echo $ZONE_PAULA ?>'></a>
<br>
<b>Pyrénées Orientales</b>, Hospitalet [ <a href="<?php echo $ZONE_HOSPI_SAI ?>">saison</a> ] + Couserans (Port d'Aula) [ <a href="<?php echo $ZONE_PAULA_SAI ?>">saison</a> ]
</p>


<p><a name='PyC' href='<?php echo $ZONE_MAUPA ?>'><img border='1' src='<?php echo $ZONE_MAUPA ?>'></a><br>
<b>Pyrénées Centrales</b>, Luchonnais (Maupas) [ <a href="<?php echo $ZONE_MAUPA_SAI ?>">saison</a> ]
</p>

<p>
<a name='Big' href="<?php echo $ZONE_AIGTE ?>"><img border='1' src='<?php echo $ZONE_AIGTE ?>'></a>
<a href='<?php echo $ZONE_LARDI ?>'><img border='1' src='<?php echo $ZONE_LARDI ?>'></a>
<br>
<b>Haute Bigorre (Pyrénées)</b>, Tunnel de Bielsa (Aiguillettes)  [ <a href="<?php echo $ZONE_AIGTE_SAI ?>">saison</a> ] + Lac d'Ardiden [ <a href="<?php echo $ZONE_LARDI_SAI ?>">saison</a> ]
</p>

<p><a name='PyW' href='<?php echo $ZONE_SOUMC ?>'><img border='1' src='<?php echo $ZONE_SOUMC ?>'></a><br>
<b>Pyrénées Occidentales</b>, Aspe-Ossau (Soum Couy). [ <a href="<?php echo $ZONE_SOUMC_SAI ?>">saison</a> ]
</p>

<p><a name='Cor' href='<?php echo $ZONE_SPOND ?>'><img border='1' src='<?php echo $ZONE_SPOND ?>'></a><a href='<?php echo $ZONE_MANIC ?>'><img border='1' src='<?php echo $ZONE_MANIC ?>'></a><br>
<b>Corse (Cinto-Rotondo)</b>, Sponde [ <a href="<?php echo $ZONE_SPOND_SAI ?>">saison</a> ] + Maniccia [ <a href="<?php echo $ZONE_MANIC_SAI ?>">saison</a> ]
</p>

</center>

<?php include 'bottom.inc'; ?>

</body></html>
