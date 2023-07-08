<?php
	function namespaceTitle($namespace, $title) {
		$fullTitle;
		if ($namespace === 'MAIN') {
			$fullTitle  = $title;
		} else {
			$fullTitle = ucfirst(strtolower($namespace));
			$fullTitle .= ':' . $title;
		}
		return $fullTitle;
	}

	function namespaceText($title) {
		return str_replace('_', ' ', $title);
	}
?>
