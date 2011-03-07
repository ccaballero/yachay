<?php

include('libs/Yeah/Utils.php');
include('libs/Yeah/Settings/Config.php');

$config = new Yeah_Settings_Config;

if (empty($config->key)) {
	echo "<p>Por favor, configure la variable key del fichero Config.php, como sigue:</p>";
	echo "<b>KEY: </b>";
	echo generatecode('alphanum', NULL, 32);
} else {
	echo "<p>El key de la aplicacion, esta configurado.</p>";
}
