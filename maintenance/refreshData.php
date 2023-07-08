<?php
	include_once "./includes/connection.php";
	$conn->query("truncate table additional.current");
	$getExisting = "select page_id, revision_id from additional.current;";
	$existing = $conn->query($getExisting);
	//Base reloaded script
	$getReloaded = "select page_id, page_title, rev_id, rev_timestamp, old_text, page_namespace, page_len, 0, 0, 0, 0 from wook.page p \n";
	$getReloaded .= "inner join wook.revision r on r.rev_id = p.page_latest\n";
	$getReloaded .= "inner join wook.slots s on s.slot_revision_id = r.rev_id\n";
	$getReloaded .= "inner join wook.content c on c.content_id = s.slot_content_id\n";
	$getReloaded .= "inner join wook.text t on t.old_id = right(c.content_address, length(c.content_address)-3)\n";
	$insert = "insert into additional.current " . $getReloaded;
	$conn->query($insert);
	echo "Begin update of existing data\n";
	foreach ($existing as $eRow) {
		$reloadLine = $getReloaded . "where page_id = " . $eRow['page_id'];
		$reloadResult = $conn->query($reloadLine);
		$firstResult = $reloadResult->fetch_assoc();
		echo $firstResult['page_id'] . "\n";
		echo $eRow['page_id'];
		echo $firstResult['rev_id'] . "\n";
		if ($reloadResult && $firstResult['rev_id'] != $eRow['revision_id']) {
			echo "updating " . $firstResult['page_title'] . " in namespace " . $firstResult['page_namespace'] . "\n";
			$updateRow = "update additional.current\n";
			$updateRow .= "set page_title = " . $firstResult['page_title'] .  ", ";
			$updateRow .= "revision_id = " . $firstResult['rev_id'] . ", ";
			$updateRow .= "revision_timestamp = " . $firstResult['rev_timestamp'] . ", ";
			$updateRow .= "text = " . $firstResult['old_text'] . ", ";
			$updateRow .= "namespace = " . $firstResult['page_namespace'] . ", ";
			$updateRow .= "page_len = " . $firstResult['page_len'] . ", ";
			$updateRow .= "reported = 0 ";
			$updateRow .= "skipped = 0 ";
			$updateRow .= "exported = 0 ";
			$updateRow .= "flagged = 0\n";
			$updateRow .= "where page_id = " . $firstResult['page_id'];
//			echo $updateRow. "\n";
			try {
				$conn->query($updateRow);
			} catch(Exception $e) {
				echo "Error: " . $e->getMessage() . "\n" . $updateRow;
				exit();
			}
		}
	}
	// echo $getReloaded;
	$reloaded = $conn->query($getReloaded);
