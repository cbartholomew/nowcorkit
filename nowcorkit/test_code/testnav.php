<!DOCTYPE html>
<head>
<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu-v.css" />
<link rel="stylesheet" href="css/theme/jquery-ui-1.8.16.custom.css" type="text/css" media="screen" title="no title" charset="utf-8">
<script type="text/javascript" src="js/ddsmoothmenu.js"></script>
<script src="lib/src/jquery-1.7.min.js" type="text/javascript" charset="utf-8"></script>
<script src="lib/src/jquery-ui-1.8.16.js" type="text/javascript" charset="utf-8"></script>

/***********************************************
* Smooth Navigational Menu- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/

</script>

<script type="text/javascript">

ddsmoothmenu.init({
	mainmenuid: "smoothmenu1", //menu DIV id
	orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
	classname: 'ddsmoothmenu', //class added to menu's outer DIV
	//customtheme: ["#1c5a80", "#18374a"],
	contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})

ddsmoothmenu.init({
	mainmenuid: "smoothmenu2", //Menu DIV id
	orientation: 'v', //Horizontal or vertical menu: Set to "h" or "v"
	classname: 'ddsmoothmenu-v', //class added to menu's outer DIV
	//customtheme: ["#804000", "#482400"],
	contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})

</script>
</head>
<html>
<body>
	<h2>Example 1</h2>

	<div id="smoothmenu1" class="ddsmoothmenu">
	<ul>
	<li><a href="http://www.dynamicdrive.com">Item 1</a></li>
	<li><a href="#">Folder 0</a>
	  <ul>
	  <li><a href="#">Sub Item 1.1</a></li>
	  <li><a href="#">Sub Item 1.2</a></li>
	  <li><a href="#">Sub Item 1.3</a></li>
	  <li><a href="#">Sub Item 1.4</a></li>
	  <li><a href="#">Sub Item 1.2</a></li>
	  <li><a href="#">Sub Item 1.3</a></li>
	  <li><a href="#">Sub Item 1.4</a></li>
	  </ul>
	</li>
	<li><a href="#">Folder 1</a>
	  <ul>
	  <li><a href="#">Sub Item 1.1</a></li>
	  <li><a href="#">Sub Item 1.2</a></li>
	  <li><a href="#">Sub Item 1.3</a></li>
	  <li><a href="#">Sub Item 1.4</a></li>
	  <li><a href="#">Sub Item 1.2</a></li>
	  <li><a href="#">Sub Item 1.3</a></li>
	  <li><a href="#">Sub Item 1.4</a></li>
	  </ul>
	</li>
	<li><a href="#">Item 3</a></li>
	<li><a href="#">Folder 2</a>
	  <ul>
	  <li><a href="#">Sub Item 2.1</a></li>
	  <li><a href="#">Folder 2.1</a>
	    <ul>
	    <li><a href="#">Sub Item 2.1.1</a></li>
	    <li><a href="#">Sub Item 2.1.2</a></li>
	    <li><a href="#">Folder 3.1.1</a>
			<ul>
	    		<li><a href="#">Sub Item 3.1.1.1</a></li>
	    		<li><a href="#">Sub Item 3.1.1.2</a></li>
	    		<li><a href="#">Sub Item 3.1.1.3</a></li>
	    		<li><a href="#">Sub Item 3.1.1.4</a></li>
	    		<li><a href="#">Sub Item 3.1.1.5</a></li>
			</ul>
	    </li>
	    <li><a href="#">Sub Item 2.1.4</a></li>
	    </ul>
	  </li>
	  </ul>
	</li>
	<li><a href="http://www.dynamicdrive.com/style/">Item 4</a></li>
	</ul>
	<br style="clear: left" />
	</div>


	<h2 style="margin-top:200px">Example 2</h2>

	<div id="smoothmenu2" class="ddsmoothmenu-v">
	<ul>
	<li><a href="http://www.dynamicdrive.com">Item 1</a></li>
	<li><a href="#">Folder 0</a>
	  <ul>
	  <li><a href="#">Sub Item 1.1</a></li>
	  <li><a href="#">Sub Item 1.2</a></li>
	  <li><a href="#">Sub Item 1.3</a></li>
	  <li><a href="#">Sub Item 1.4</a></li>
	  <li><a href="#">Sub Item 1.2</a></li>
	  <li><a href="#">Sub Item 1.3</a></li>
	  <li><a href="#">Sub Item 1.4</a></li>
	  </ul>
	</li>
	<li><a href="#">Folder 1</a>
	  <ul>
	  <li><a href="#">Sub Item 1.1</a></li>
	  <li><a href="#">Sub Item 1.2</a></li>
	  <li><a href="#">Sub Item 1.3</a></li>
	  <li><a href="#">Sub Item 1.4</a></li>
	  <li><a href="#">Sub Item 1.2</a></li>
	  <li><a href="#">Sub Item 1.3</a></li>
	  <li><a href="#">Sub Item 1.4</a></li>
	  </ul>
	</li>
	<li><a href="#">Item 3</a></li>
	<li><a href="#">Folder 2</a>
	  <ul>
	  <li><a href="#">Sub Item 2.1</a></li>
	  <li><a href="#">Folder 2.1</a>
	    <ul>
	    <li><a href="#">Sub Item 2.1.1</a></li>
	    <li><a href="#">Sub Item 2.1.2</a></li>
	    <li><a href="#">Folder 3.1.1</a>
			<ul>
	    		<li><a href="#">Sub Item 3.1.1.1</a></li>
	    		<li><a href="#">Sub Item 3.1.1.2</a></li>
	    		<li><a href="#">Sub Item 3.1.1.3</a></li>
	    		<li><a href="#">Sub Item 3.1.1.4</a></li>
	    		<li><a href="#">Sub Item 3.1.1.5</a></li>
			</ul>
	    </li>
	    <li><a href="#">Sub Item 2.1.4</a></li>
	    </ul>
	  </li>
	  </ul>
	</li>
	<li><a href="http://www.dynamicdrive.com/style/">Item 4</a></li>
	</ul>
	<br style="clear: left" />
	</div>	
	
	

</body>
</html>