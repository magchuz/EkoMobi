<?php
	// define the path and name of cached file
	$cachefile = './cached-files/'.$_GET["q"].'.php';
	// define how long we want to keep the file in seconds. I set mine to 5 hours.
	$cachetime = 18000;
	// Check if the cached file is still fresh. If it is, serve it up and exit.
	if (file_exists($cachefile) && time() - $cachetime < filemtime($cachefile)) {
   	include($cachefile);
    	exit;
	}
	// if there is either no file OR the file to too old, render the page and capture the HTML.
	ob_start();
?>
<?php
$array_get = file_get_contents('https://api.ecotrackings.com/api/v3/products?token=#GantiDenganTokenMu&limit=5&currency=idr&keyword='.urlencode($_GET["q"]));
$array = json_decode($array_get, true);
$loop = count($array['data']) - 1 ;
?>
<!DOCTYPE html><html><head> <meta charset="utf-8"> <meta name="viewport" content="width=device-width, initial-scale=1"> <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css"> <link rel="stylesheet" href="https://v40.pingendo.com/assets/4.0.0/default/theme.css" type="text/css"> </head><body> <div class="py-2 bg-primary"> <div class="container"> <div class="row"> <div class="col-md-4"> <h1 class="display-1">Ekomobi</h1> </div><div class="col-md-8"> <form class=""> <div class="form-group"><br><input type="text" class="form-control" name="q" placeholder="Nama Produk"> </div><button type="submit" class="btn btn-secondary btn-block">Cari Produk</button> </form> </div></div></div></div><div class="p-0 bg-primary"> <div class="container"> <div class="row"> <div class="col-md-12"> <h5 contenteditable="false">About <?php echo(count($array['data']));?> results (<?php echo number_format(microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"],3); ?> seconds) </h5> </div></div></div></div><?php for ($x=0; $x <=$loop; $x++){echo ' <div class="p-2"> <div class="container"> <div class="row"> <div class="col-md-2"> <img class="d-block mx-auto border border-primary img-fluid" style="width: 200px;" src="'.$array['data'][$x]['product_picture'].'"></div><div class="col-md-10"> <div class="card"> <div class="card-body"> <h5 class="card-title">'.ucwords($array['data'][$x]['product_name']).'</h5> <p class="card-text">Some quick example text to build on the card title and make up the bulk of the cards content.</p><a href="'.$array['data'][$x]['tracking_link'].'" class="btn btn-primary">Beli Produk Ini</a> </div></div></div></div></div></div>';}?> <div class="p-2"> <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script> <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> <pingendo onclick="window.open('https://pingendo.com/', '_blank')" style="cursor:pointer;position: fixed;bottom: 10px;right:10px;padding:4px;background-color: #00b0eb;border-radius: 8px; width:250px;display:flex;flex-direction:row;align-items:center;justify-content:center;font-size:14px;color:white">Made with Pingendo Free&nbsp;&nbsp; <img src="https://pingendo.com/site-assets/Pingendo_logo_big.png" class="d-block" alt="Pingendo logo" height="16"> </pingendo> </div><div class="py-2 bg-dark text-white" > <div class="container"> <div class="row"> <div class="col-md-12 mt-3 text-center"> <p>© Copyright 2018 Pingendo - All rights reserved.</p></div></div></div></div></body></html>
<?php
	// We're done! Save the cached content to a file
	$fp = fopen($cachefile, 'w');
	fwrite($fp, ob_get_contents());
	fclose($fp);
	// finally send browser output
	ob_end_flush();
?>
