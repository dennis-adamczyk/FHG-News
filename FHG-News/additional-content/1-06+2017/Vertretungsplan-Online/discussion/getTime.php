<?
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
include "$root/core/init.php";

$time = $_POST['TIME'];

$seconds = time() - $time;

$minutes = 0;
$hours = 0;
$days = 0;
$weeks = 0;
$months = 0;
$years = 0;

while ($seconds >= 60) {
  $seconds -= 60;
  $minutes++;
}

while ($minutes >= 60) {
  $minutes -= 60;
  $hours++;
}

while ($hours >= 24) {
  $hours -= 24;
  $days++;
}

while ($days >= 7) {
  $days -= 7;
  $weeks++;
}

while ($weeks >= 4) {
  $weeks -= 4;
  $months++;
}

while ($months >= 12) {
  $months -= 12;
  $years++;
}

if ($years != 0) {
	if (years == 1) {
		echo "vor einem Jahr";
	} else {
		echo "vor " . $years . " Jahren";
	}
} else if ($months != 0) {
	if ($months == 1) {
		echo "vor einem Monat";
  } else {
		echo "vor " . $months . " Monaten";
	}
} else if ($weeks != 0) {
	if ($weeks == 1) {
		echo "vor einer Woche";
	} else {
		echo "vor " . $weeks . " Wochen";
	}
} else if ($days != 0) {
	if ($days == 1) {
  	echo "vor einem Tag";
	} else {
		echo "vor " . $days . " Tagen";
	}
} else if ($hours != 0) {
	if ($hours == 1) {
		echo "vor einer Stunde";
	} else {
		echo "vor " . $hours . " Stunden";
	}
} else if ($minutes != 0) {
	if ($minutes == 1) {
		echo "vor einer Minute";
	} else {
		echo "vor " . $minutes . " Minuten";
	}
} else if ($seconds != 0) {
	if ($seconds == 1) {
		echo "vor einer Sekunde";
	} else {
		echo "vor " . $seconds . " Sekunden";
	}
}

?>
