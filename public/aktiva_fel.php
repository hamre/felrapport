<?php 
include("../sys/core/init.inc.php");
$l = new user;
$l->protect_page();
$l->admin_protect();
include("inc/overall/header_overall.php"); 

$bussar = $l->db->prepare("SELECT DISTINCT bussar.regnr,bussar.id,bussar.typ,fel.aktiv FROM bussar INNER JOIN fel ON bussar.regnr=fel.regnr WHERE fel.aktiv = 1 ORDER BY bussar.regnr ASC");
$bussar->execute();

$result = $bussar->fetchAll();

print('<div class="layer1">');
print('Denna sida visar alla aktiva fel och sorterar dom med KRITISKA fel först. Dessa fel kan alltså vara äldre än dom som ligger under dom.<br />');
foreach($result AS $buss) {
	$fel = $l->get_fel($buss['regnr']);
		print('<br /><strong>'.$buss['regnr'].' - '.$buss['typ'].'</strong><br />');

	foreach($fel AS $f) {
		/*print('<table cellspacing="2"><tr><td><form target="_blank" action="print_fel.php" method="get"><input type="hidden" name="regnr" value="'.$buss['regnr'].'"><input type="hidden" name="id" value="'.$f['id'].'"><input type="submit" name="send" value="Skriv ut/Läs   "></form></td>');
		print('<td><form action="buss_ready.php" method="post"><input type="hidden" name="regnr" value="'.$buss['regnr'].'"><input type="hidden" name="id" value="'.$f['id'].'"><input type="submit" name="klar" value="Klarmarkera"></form></td>');
                if($f['allvar'] == 2) {
                    print('<td><font color="red"> - KRITISK</font></td></tr>');
                }
                print('</table>');*/
            print('<p class="heading">LÄS');
            if($f['allvar'] == 2) {
                print(' - KRITISK');
            }
            print(' - Felet inlagt: '.$f['datum']);
            print('</p>');
            print('<div class="content">'.$f['beskrivning']);
            print('<br /><table cellspacing="2"><tr><td><form action="print_fel.php" method="get"><input type="hidden" name="regnr" value="'.$buss['regnr'].'"><input type="hidden" name="id" value="'.$f['id'].'"><input type="submit" value="Skriv ut"></form></td>');
            print('<td><form action="buss_ready.php" method="post"><input type="hidden" name="regnr" value="'.$buss['regnr'].'"><input type="hidden" name="id" value="'.$f['id'].'"><input type="submit" value="Klarmarkera"></form></td></tr></table></div>');
            
            }
}
print('</div>');

include("inc/overall/footer_overall.php"); 
?>