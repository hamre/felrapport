<?php 
include("../sys/core/init.inc.php");
$help = new user;
$help->protect_page();
include("inc/overall/header_overall.php"); 
?>
<h1>På denna sida får du hjälp att lägga in ett fel!</h1>
<br />
<img src="assets/buss.png" alt="Buss"><br />
Först väljer du vilken buss du vill felanmäla.<br /><br />
<img src="assets/buss1.png" alt="Buss2"><br />
Sedan väljer du om felet kan vänta (Låg), bör fixas så snabbt som möjligt (Normal) eller om bussen ej bör gå i trafik (Kritiskt).<br /><br />
<img src="assets/buss2.png" alt="Buss3"><br />
Sedan beskriver du felet så utförligt som möjligt.<br /><br />
<img src="assets/buss3.png" alt="Buss4"><br />
Sista du behöver göra är att ange vad du heter så meckarna kan kontakta dig om dom behöver ytterligare information om felet.<br />
Sedan trycker du på "Lägg till" så läggs din felrapport in och meckarna kan fixa felet.<br /><br />
<img src="assets/buss4.png" alt="Buss5"><br />
Under "Ej lagade fel för {Fordon}" ser du fel som har lagts in men ännu ej blivit fixade. Kolla där först innan du lägger till ett fel så du inte lägger in
samma fel flera gånger.<br /><br />
<img src="assets/buss5.png" alt="Buss6"><br />
Under "Lagade fel den senaste månaden för {Fordon}" ser du dom fel som lagats en månad tillbaka i tiden. Denna är mest till för meckarna för att
se om samma fel dyker upp många gånger under en kort tidsperiod.<br /><br />
Det var allt. Behöver du ännu mera hjälp eller har någon fråga kontakta då <strong>Inger, Henrik eller Jennie</strong> så kan dom svara på dina frågor.
<?php include("inc/overall/footer_overall.php"); ?>