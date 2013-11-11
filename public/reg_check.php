<?php
include("../sys/core/init.inc.php");
$reg = new user;
$reg->admin_protect();
$reg->protect_page();
if(isset($_POST['regnr']))
{
$name=$_POST['regnr'];
$stmt = $reg->db->prepare("SELECT COUNT(id) FROM bussar WHERE regnr=:regnr");
$stmt->execute(array("regnr" => $name));
$result = $stmt->fetch();
if($result[0]==0)
{
echo "<span style='color:green;'>OK</span>";
}
else
{
echo "<span style='color:red;'>Finns redan i databasen</span>";
}
}
?>