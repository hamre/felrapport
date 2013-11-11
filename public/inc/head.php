<head>
	<title>Felanmälan</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="css/screen.css">
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
        <script type="text/javascript">
            jQuery(document).ready(function() {
            jQuery(".content").hide();
            //toggle the componenet with class msg_body
            jQuery(".heading").click(function()
            {
                jQuery(this).next(".content").slideToggle(500);
            });
            });
        </script>        
	<link href="css/ui-lightness/jquery-ui-1.10.3.custom.css" rel="stylesheet">
	<script src="js/jquery-1.9.1.js"></script>
	<script src="js/jquery-ui-1.10.3.custom.js"></script>
	  <script>
  $(function() {
    $( "#datepicker" ).datepicker();
	$( "#datepicker" ).datepicker("option", "dateFormat", "yy-mm-dd");
	$( "#datepicker" ).datepicker("option", "showAnim", "clip");
  });
  
  $(function() {
    $( "#datepicker2" ).datepicker();
	$( "#datepicker2" ).datepicker("option", "dateFormat", "yy-mm-dd");
	$( "#datepicker2" ).datepicker("option", "showAnim", "clip");
  });
  </script>
</head>