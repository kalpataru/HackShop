<?php
include "../libchart/classes/libchart.php";
$default_opts = array(
  'http'=>array(
    'method'=>"GET",
    'header'=>"Accept-language: en\r\n" .
              "Cookie: foo=bar",
    'proxy'=>"tcp://10.3.100.211:8080"
  )
);

$default = stream_context_set_default($default_opts);
function fread_url($url,$proxy)
{
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_PROXY, $proxy);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HEADER, 1);
	$curl_scraped_page = curl_exec($ch);
	curl_close($ch);

	return $curl_scraped_page;
}
$nume = $_GET['q'];
//$nume="nikon D5200 slr";
//flipkart

$query= $nume." flipkart";
$results = json_decode(file_get_contents( 
          'http://ajax.googleapis.com/ajax/services/search/web?v=1.0&q='.
           urlencode($query)));
//echo $results;
$url=$results->responseData->results[0]->url;

$var1 = fread_url($url,'10.3.100.211:8080');
preg_match_all("/<span class=\"fk-font-finalprice fk-font-big fk-bold final-price\".*span>/", $var1, $matches1);
$price_flipkart=$matches1[0][0];
//echo $price_flipkart."<br>";
//echo strlen($matches1[0][0]);
$p_flipkart=(int)substr($price_flipkart,69,strlen($price_flipkart)-69);
//echo "Flipkart price : ".$p1;

//amazon

$query= $nume." amazon";
$results = json_decode(file_get_contents( 
          'http://ajax.googleapis.com/ajax/services/search/web?v=1.0&q='.
           urlencode($query)));
//echo $results;
$url=$results->responseData->results[0]->url;
//echo $url;
$var1 = fread_url($url,'10.3.100.211:8080');
preg_match_all("/<b class=\"priceLarge\".*b>/", $var1, $matches2);
$price_amazon=$matches2[0][0] ;
//echo $price_amazon;
$p2=substr($price_amazon,23,strlen($price_amazon)-27);
$p_amazon=(int)(((float)$p2)*53.84);
//echo "Amazon price : ".$p;



//infibeam
$query= $nume." infibeam";
$results = json_decode(file_get_contents( 
          'http://ajax.googleapis.com/ajax/services/search/web?v=1.0&q='.
           urlencode($query)));
//print_r($results);
$url=str_replace("%3F","?",$results->responseData->results[0]->url);
$url=str_replace("%3D","=",$url);
//echo $url;
$var1 = fread_url($url,'10.3.100.211:8080');
preg_match_all("/<span class=\"infiPrice amount price\".*span>/", $var1, $matches3);
//print_r($matches3);
$price_infibeam=$matches3[0][0];
//echo $price_flipkart."<br>";
//echo strlen($matches1[0][0]);
$p_infibeam=(int)str_replace(",","",substr($price_infibeam,37,strlen($price_infibeam)-37));
//echo "Infibeam price : ".$p_infibeam;


$chart = new VerticalBarChart();

$dataSet = new XYDataSet();
$dataSet->addPoint(new Point("Flipkart", $p_flipkart));
$dataSet->addPoint(new Point("Amazon", $p_amazon));
$dataSet->addPoint(new Point("Infibeam", $p_infibeam));
$chart->setDataSet($dataSet);
$chart->setTitle("Price Comparision for the Selected Product");
$chart->render("generated/demo1.png");
echo "complete";
?>



