<?php
	echo '<p>Updating ' . $POST['page_id'] . '</p>';
	include 'includes/connection.php';
	$submit = 'update additional.current set reported = 1 where page_id = ' . $_POST['page_id'] . ';';
	echo $submit;
	if ($conn->query($submit) === TRUE) {
		echo '\nupdated';
	} else {
		echo $conn->error;
	}

	header("Location: index.php?page_id=" . $_POST['page_id']);
?>
