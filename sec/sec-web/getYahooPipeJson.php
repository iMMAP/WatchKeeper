<?php
$string = file_get_contents("http://pipes.yahoo.com/pipes/pipe.run?_id=bd16836175a605fd76122a9a70b9192b&_render=json");

$json=json_decode($string,true);
// var_dump($json['value']['items'][0]);

foreach ($json['value']['items'] as $key => $value){
	// var_dump($value);

	$pic = $value['media:content']['url'];
	if ($pic==''){$pic='images/no-images.jpg';}
	echo "<li>";
	echo "	<div class=\"jqsectioninner\">";
	// echo "		<div class=\"contlogo\"><img src=\"".$pic."\" width=\"128\" height=\"62\" /></div>";
	echo "		<div class=\"contheading\"><a target=\"_blank\" href=\"".$value['link']."\">".$value['title']."</a>";
	echo "		<span class=\"ch2\"></span></div>";
	echo "	</div>";
	echo "</li>";
}

?>