<?php

namespace App;

use App\Services\Convertor;

$res = "";

if(@$_POST['proxies']){
	$convertor = new Convertor($_POST['proxies']);
	$res = $convertor->convert();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="style.css">
	<title>proxy convertor</title>
</head>
<body>
	<div class="body">
		<h1>rate us in github <a href="https://github.com/mnr73/v2ray-to-clash-converter">mnr73/v2ray-to-clash-converter</a></h1>
		<hr>
		<form method="post">
			<label for="">paste your proxies here</label>
			<textarea name="proxies" id="" cols="30" rows="10"></textarea>
			<button type="submit">create clash file</button>
		</form>
		<?php if($res){ ?>
		<div class="create-message">file created at: <?php echo $res ?></div>
		<?php } ?>
	</div>
</body>
</html>