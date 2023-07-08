<?php
	include "includes/connection.php";
	include "includes/regex.php";
	include "includes/namespace.php";
	include "includes/textprocessor.php";
	echo $_POST['page_id'];
	if(isset($_POST['page_id'])) {
		echo $_POST['page_id'];
		$start = $_POST['page_id'];
	} else {
		$start = null;
	}
	echo $start;
	
	function addLines($result) {
		$bmatch = false;
		$start = 0;
		foreach($result as $row) {
			//echo 'Start Regex';
			if (checkRegex($row['text']) || checkRegex($row['page_title'])) {
				echo '<div class="table-container">';
					echo '<table>';
						echo '<tr>';
							echo '<th>Page id</th>';
							echo '<th>Page title</th>';
							echo '<th>Last revision</th>';
						echo '</tr>';
						echo '<tr id=' . $row['page_id'] . '>';
							echo '<td>' . $row['page_id'] . '</td>';
							$pageTitle = namespaceTitle($row['ns_name'], $row['page_title']);
							$pageTitle = namespaceText($pageTitle);
							echo '<td>' . processPage($pageTitle) . '</td>';
							echo '<td>' . $row['revision_timestamp'] . '</td>';
						echo '</tr>';
						echo '<tr>';
							echo '<td colspan ="3"><div class="contrib"><p>';
							echo processPage($row['text']);
							echo '</p></div></td>';
						echo '</tr>';
					echo '</table>';
				echo '</div>';
				echo '<div class="management">';
					include "includes/connection.php";
					$revquery = "select count(*) as 'Count' from additional.current where reported = 0 and skipped = 0 and flagged = 1 and exported = 0";
					$revresult = $conn->query($revquery);
					$reviews = $revresult->fetch_assoc();
					$reviews = $reviews['Count'];
					echo '<div class="remaining">Articles left to review: ';
						echo $reviews;
					echo '</div>';
					echo '<div class="options">';
						echo '<form method = "post" action="submitreport.php">';
							echo '<input name="page_id" value = ' . $row['page_id'] . ' style="display:none;" />';
							echo '<input type="submit" name="report" value="Report">';
						echo '</form>';
						echo '<form method = "post" action="skipreport.php">';
							echo '<input name="page_id" value = ' . $row['page_id'] . ' style="display:none;" />';
							echo '<input type="submit" name="report" value="Skip">';
						echo '</form>';
					echo '</div>';
					echo '<div class="results">';
						echo '<p>This page matched on the following results:</p><h3>TitleMatches</h3>';
						echo matchedRegex($row['page_title']);
						echo '<h3>PageMatches</h3>';
						echo matchedRegex($row['text']);
					echo '</div>';
				echo '</div>';

				return true;
			}
			$start = $row['page_id'];
		}
		return false;
	}
	
	function getBatch($limit = 50, $offset = 0, $namespace, $start) {
		include "includes/connection.php";
/*		if (!$start) {
			$startQuery =  "Select page_id from additional.current where reported = 0 and skipped = 0 ";
			$startQuery .= "and exported = 0 and flagged = 1";
			$startQuery .= "order by namespace desc, page_id desc limit 1";
			$startResult = $conn->query($startQuery);
			foreach ($startResult as $rStart) {
				$start = $rStart['page_id'];
			}
		}*/
		if ($offset != 0) {
			$offset *= $limit;
		}
		//echo "{$offset}\n";
		$setQuery = "select page_id, page_title, revision_timestamp, text, ns_name from additional.current c\n";
		$setQuery .= "inner join additional.namespace n on n.ns_id = c.namespace\n";
		$setQuery .= "where flagged = 1 and reported =0 and skipped = 0 and exported = 0\n";
		if ($namespace) {
			$setQuery .= "and namespace in ({$namespace})\n";
		} else	{
			$setQuery .= "and namespace > 0\n";
		}
		if ($start) {
			$setQuery .= 'and page_id > ' . $start . ' ';
		}
		$setQuery .= "order by namespace, page_title\n";
		$setQuery .= "limit {$limit} offset {$offset};\n";
//		echo $setQuery;
		$conn = mysqli_connect($server, $user, $pass);
		return $conn->query($setQuery);
	}

	$matches = 0;
	$result = getBatch(50, 0, null, $start, $conn);

	echo '<html>';
		echo '<head>';
			echo '<title>Wook datamine</title>';
			echo '<link rel="stylesheet" href="assets/styles.css" type="text/css" />';
		echo '</head>';
		echo '<body>';
			$i = 0;
			while (!$matches && $result != null) {
				$matches = addLines($result);
				$i += 1;
				$result = getBatch(50, $i, null, $start, $conn);
			}
		echo '</body>';
	echo '</html>';
?>
