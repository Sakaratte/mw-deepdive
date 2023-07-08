<?php
	include_once "connection.php";
	include_once "regex.php";
	$qry = "select page_id, ns_name, page_title, text from additional.current c inner join additional.namespace n on n.ns_id = c.namespace where exported = 0 and (flagged = 0 or flagged is null);";
	$data = $conn->query($qry);
	echo "Begin Regex Validation\n";
	$expressions = myRegex();
	foreach ($data as $row) {
		echo $row['ns_name'] . ":" . $row['page_title'] . "\n";
		$flag = 0;
		$current = $row['page_title'];
		while ($flag == 0) {
			foreach (regexHolds() as $hold=>$holdVal){
				$current = str_replace($holdVal, $hold, $current);
			}
			foreach ($expressions as $check=>$reg) {
				if (preg_match($reg, $row['page_title'])||preg_match($reg, $current)) {
					echo "Match Found\n";
					$update = "update additional.current set flagged = 1 where page_id = " . $row['page_id'] . ";";
					$conn->query($update);
					$flag = 1;
				}
			} 
			$flag = 1;
		}
	}
	echo "Checks complete"
?>
