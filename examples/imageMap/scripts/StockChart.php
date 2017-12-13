<?php

/* pChart library inclusions */
chdir("../../");
require_once("bootstrap.php");

use pChart\pDraw;
use pChart\pImageMap;
use pChart\pStock;

/* Create the pChart object */
/* 							X, Y, TransparentBackground, ImageMapIndex, ImageMapStorageMode, UniqueID, StorageFolder*/
$myPicture = new pImageMap(700,230,FALSE,"ImageMapStockChart",IMAGE_MAP_STORAGE_FILE,"StockChart","temp");

/* Retrieve the image map */
if (isset($_GET["ImageMap"]) || isset($_POST["ImageMap"])){
	$myPicture->dumpImageMap();
}

/* Populate the pData object */
$myPicture->myData->addPoints([35,28,17,27,12,12,20,15,20,28],"Open");
$myPicture->myData->addPoints([20,17,25,20,25,23,16,29,26,17],"Close");
$myPicture->myData->addPoints([10,11,14,11,9,4,3,7,9,5],"Min");
$myPicture->myData->addPoints([37,32,33,29,29,25,22,34,29,31],"Max");
$myPicture->myData->addPoints([30,20,21,24,22,18,18,24,22,24],"Median");
$myPicture->myData->setAxisDisplay(0,AXIS_FORMAT_CURRENCY,"$");

$myPicture->myData->addPoints(array("Dec 13","Dec 14","Dec 15","Dec 16","Dec 17", "Dec 20","Dec 21","Dec 22","Dec 23","Dec 24"),"Time");
$myPicture->myData->setAbscissa("Time");
$myPicture->myData->setAbscissaName("Time");

/* Turn off Anti-aliasing */
$myPicture->Antialias = FALSE;

/* Draw the border */
$myPicture->drawRectangle(0,0,699,229,["R"=>0,"G"=>0,"B"=>0]);

$myPicture->setFontProperties(array("FontName"=>"pChart/fonts/pf_arma_five.ttf","FontSize"=>6));

/* Define the chart area */
$myPicture->setGraphArea(60,30,650,190);

/* Draw the scale */
$scaleSettings = array("GridR"=>200,"GridG"=>200,"GridB"=>200,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE);
$myPicture->drawScale($scaleSettings);

/* Create the pStock object */
$mystockChart = new pStock($myPicture);

/* Draw the stock chart */
$stockSettings = array("RecordImageMap"=>TRUE,"BoxUpR"=>255,"BoxUpG"=>255,"BoxUpB"=>255,"BoxDownR"=>0,"BoxDownG"=>0,"BoxDownB"=>0,"SerieMedian"=>"Median");
$mystockChart->drawStockChart($stockSettings);

/* Render the picture (choose the best way) */
$myPicture->autoOutput("temp/StockChart.png");

?>