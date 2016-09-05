
<html>
<head>
    <title>XML demo 3: RSS News Viewer</title>
	<link rel="stylesheet" type="text/css" href="css/xmlrss.css" />	      
</head>
<body>
  <?php
  $weatherlocs = array('Boston'=> 'http://w1.weather.gov/xml/current_obs/KBOS.xml',
				  'New York'=>'http://w1.weather.gov/xml/current_obs/display.php?stid=KJFK',
				  'Los Angeles'=>'http://w1.weather.gov/xml/current_obs/display.php?stid=KLAX',
				  'Miami'=>'http://w1.weather.gov/xml/current_obs/display.php?stid=KMIA'
				);
	 $newspapers = array('NYTimes'=>'http://rss.nytimes.com/services/xml/rss/nyt/HomePage.xml',
				  'DailyNews'=>'http://feeds.nydailynews.com/nydnrss',
				  'Mercury News'=>'http://feeds.mercurynews.com/mngi/rss/CustomRssServlet/568/200735.xml'
				);			

  ?>
  <h1>RSS Feeds</h1>
  <?php
 
  create_form($weatherlocs, "weather");
 
  
  create_form2($newspapers, "news");
   
  
  ?>
  </body>
</html>
<div id='form'>

<?php

  
  
function handle_form( $myweather ) {
	  ini_set('user_agent', 'Mozilla/4.0(compatible;MSIE6.0)');
	  
	  $xml= new SimpleXMLElement(file_get_contents($myweather));
      $location = $xml-> location;
      $obsertime = $xml-> observation_time;
      $weather = $xml-> weather;
      $temperature = $xml-> temperature_string;
      
      echo "<h1>$location</h1>";
      echo "<h2>$obsertime</h2>";
      echo "<h3>$weather</h3>";
      echo "<h4>$temperature</h4>";
      
     
	  //$rss = simplexml_load_file( $myweather);
 	  //$doc = new DOMDocument();
	  //$doc->preserveWhiteSpace = false;
	  //$doc->formatOutput = true;
      //$doc->load($myweather);
 
     //print $doc->saveXML();
 	  
 	  /**
      $title =  $rss->channel->title;
      echo "<h1>$title</h1>";
      # I would like to do this:
      #     foreach ($rss->channel->item as $item) {
      # or this:
      #     foreach ($rss->item as $item) {
      # but which one depends on the rss version in use.
      $items = $rss->channel->item; # try, works some versions
      if (!$items)
        $items = $rss->item; # works other versions
      foreach ( $items as $item ) {
      	echo "<div class='news'>
      			<h2>$item->title<h2>\n";
        echo '<a href="' . $item->link . '">' . $item->title . '</a><br>';
        echo $item->description . "<br><br>\n";
        echo "</div>";
      }**/
      
}


function create_form( $warray, $menuname ){
?>
<form method="get" id='f1'>
	<fieldset>
		<legend>Weather!</legend>
		<?php create_menu( $warray, $menuname ); ?>
		<input type="submit" name="getweather" value="Get My Weather!">
		<?php if ( isset( $_GET['getweather'] ) ) {
  	handle_form( $_GET['weather'] );	
  } ?>
	</fieldset>	
</form>
<?php
}


function create_menu($warray, $menuname){

	$current_weather = isset( $_GET['weather'] ) ?  $_GET['weather'] : "";
	echo "<select name='$menuname'>";
	foreach ( $warray as $key=> $value ) {
		if ( $current_weather == $value )  {
			echo "<option value='$value' selected>$key</option>";
		} else {
			echo "<option value='$value'>$key</option>";
		}
	}
	echo '</select>';
}
?>
</div>

<div id='form2'>
<?php


function handle_form2( $nfeed ) {
	  $rss = simplexml_load_file( $nfeed );
 	  
      $title =  $rss->channel->title;
      echo "<h1>$title</h1>";
      # I would like to do this:
      #     foreach ($rss->channel->item as $item) {
      # or this:
      #     foreach ($rss->item as $item) {
      # but which one depends on the rss version in use.
      $items = $rss->channel->item; # try, works some versions
      if (!$items)
        $items = $rss->item; # works other versions
      foreach ( $items as $item ) {
      	echo "<div class='news'>
      			<h2>$item->title<h2>\n";
        echo '<a href="' . $item->link . '">' . $item->title . '</a><br>';
        echo $item->description . "<br><br>\n";
        echo "</div>";
      }
}

function create_form2( $narray, $menuname ){
?>

<form method="get" id='f2'>
	<fieldset>
		<legend>News</legend>
		<?php create_menu2( $narray, $menuname ); ?>
		<input type="submit" name="getnews" value="Get My News!">
		<?php if ( isset( $_GET['getnews'] ) ) {
  	handle_form2( $_GET['news'] );	
  } ?>
	</fieldset>
</form>
<?php
}


function create_menu2($narray, $menuname){

	$current_news = isset( $_GET['news'] ) ?  $_GET['news'] : "";
	echo "<select name='$menuname'>";
	foreach ( $narray as $key=> $value ) {
		if ( $current_news == $value )  {
			echo "<option value='$value' selected>$key</option>";
		} else {
			echo "<option value='$value'>$key</option>";
		}
	}
	echo '</select>';
}
?>

</div>
