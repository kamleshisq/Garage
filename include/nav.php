<?php 
$currentPage= $_SERVER['SCRIPT_NAME'];
  
// To Get the directory name in 
// which file is stored.
$currentPage = substr($currentPage, 1);
  
// To Show the Current Filename on Page.
$act1=$act2='';
if(strstr("dashboard",$currentPage)) 
	$act1='active';
elseif(strstr("top_cars",$currentPage)) 
	$act2='active';
?>
<ul class="nav">
	<li class="nav-item nav-profile" style="text-align: center;">
		<img src="images/footer-logo.png" style="width:90%;">
	</li>

	

	<li class="nav-item <?php echo $act1?>">

	  <a class="nav-link" href="dashboard.php">

		<i class="menu-icon typcn typcn-document-text"></i>

		<span class="menu-title">Reports</span>

	  </a>

	</li>
<li class="nav-item <?php echo $act2?>">

	  <a class="nav-link" href="top_cars.php">

		<i class="menu-icon typcn typcn-document-text"></i>

		<span class="menu-title">Top Cars</span>

	  </a>

	</li>

	<!--
	<li class="nav-item">

	  <a class="nav-link" href="report.php">

		<i class="menu-icon typcn typcn-document-text"></i>

		<span class="menu-title">Report</span>

	  </a>

	</li>

	

	<li class="nav-item">

	  <a class="nav-link" href="shorts.php">

		<i class="menu-icon typcn typcn-document-text"></i>

		<span class="menu-title">Shorts</span>

	  </a>

	</li>-->

	

	<li class="nav-item">

	  <a class="nav-link" href="logout.php">

		<i class="menu-icon typcn typcn-document-text"></i>

		<span class="menu-title">Logout</span>

	  </a>

	</li>

	

</ul>