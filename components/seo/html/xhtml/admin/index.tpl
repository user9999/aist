<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<title><!--title--></title>
<meta http-equiv="Content-Type" content="text/html;charset=windows-1251" />
<meta name="keywords" content="-@content@-" />
<meta name="description" content="-@description@-" />
<meta name="author" content="Vlad" />
<meta name="copyright" content="http://good-job.ws" />
<style type="text/css">
@import url('main.css');
div.advert{padding-top:20px;border-bottom:2px dotted black;text-align:center;
}
</style>
<script src="JsHttpRequest.js"></script>

<script type="text/javascript" language="JavaScript">
function doLoad(value) {
        var req = new JsHttpRequest();
       	req.onreadystatechange = function() {
        	if (req.readyState == 4) {
          		for(i=0;i<=document.getElementById('sel_ph').length;i++){
				document.getElementById('sel_ph').options[i]=null;
			}
			for(var prop in req.responseJS){
				document.getElementById('sel_ph').options[prop]=new Option(req.responseJS[prop],req.responseJS[prop]);
			}
			
        	}
    	}

    	req.open(null, 'load.php', true);
    	req.send( { q: value } );
}
</script>
</head>
<body>
<div class="content">
<table>
<tr style="vertical-align:top;"><td style="width:170px"><!--admin/menu-->
<!--l_block-->
</td><td>
<!--content-->
</td><td style="width:100px">
<!--block-->
</td></tr>
</table>




</div>
</body>
</html>