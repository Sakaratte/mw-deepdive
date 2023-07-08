<?php
	function processPage($text) {
		$text = htmlspecialchars($text); //set to base and we will pick out the tags we want to restore.
		$text = str_replace("\n", '<br />', str_replace("\n\n", '</p><p>', $text));
		$text = str_replace('&lt;hr', '<hr', $text);
		$text = str_replace('&lt;table', '<table', $text);
		$text = str_replace('&lt;/table', '</table', $text);
		$text = str_replace('&lt;tr', '<tr', $text);
		$text = str_replace('&lt;/tr', '</tr', $text);
		$text = str_replace('&lt;td', '<td', $text);
		$text = str_replace('&lt;/td', '</td', $text);
		$text = str_replace('&lt;pre', '<pre', $text);
		$text = str_replace('&lt;/pre&gt;', '</pre>', $text);
		$text = str_replace('&lt;sup&gt;', '<sup>', $text);
		$text = str_replace('&lt;/sup&gt;', '</sup>', $text);
		$text = str_replace('&lt;strike&gt;', '<strike>', $text);
		$text = str_replace('&lt;/strike&gt;', '</strike>', $text);
		$text = str_replace('&lt;s&gt;', '<s>', $text);
		$text = str_replace('&lt;/s&gt;', '</s>', $text);
		// <span />, <font /> and <div /> can be stylised so done a dirty capture for them.
		$text = str_replace('&lt;span', '<span', $text);
		$text = str_replace('&lt;Span', '<span', $text);
		$text = str_replace('&lt;/span&gt;', '</span>', $text);
		$text = str_replace('&lt;/Span&gt;', '</span>', $text); //Always one who has to upper case
		$text = str_replace('&lt;font', '<font', $text);
		$text = str_replace('&lt;/font', '</font', $text);
		$text = str_replace('&lt;div', '<div', $text);
		$text = str_replace('&lt;/div', '</div', $text);
		$text = str_replace('&lt;big&gt;', '<big>', $text);
		$text = str_replace('&lt;/big&gt;', '</big>', $text);
		$text = str_replace('&lt;small&gt;', '<small>', $text);
		$text = str_replace('&lt;/small&gt;', '</small>', $text);
		$text = str_replace('&lt;sub&gt;', '<sub>', $text);
		$text = str_replace('&lt;/sub&gt;', '</sub>', $text);
		$text = str_replace('&lt;b', '<b', $text);
		$text = str_replace('&lt;/b&gt;', '</b>', $text);
		$text = str_replace('&lt;u&gt;', '<u>', $text);
		$text = str_replace('&lt;/u&gt;', '</u>', $text);
		$text = str_replace('&lt;i&gt;', '<i>', $text);
		$text = str_replace('&lt;/i&gt;', '</i>', $text);
		$text = str_replace('&lt;center&gt;', '<center>', $text);
		$text = str_replace('&lt;/center&gt;', '</center>', $text);
		// May as well send nowiki to the background
		$text = str_replace('&lt;nowiki&gt;', '<span class="nowiki">', $text);
		$text = str_replace('&lt;/nowiki&gt;', '</span>', $text);
		$text = str_replace('&lt;nowiki /&gt;', '', $text);
		// line breaks are handy
		$text = str_replace('&lt;br&gt;', '<br>', $text);
		$text = str_replace('&lt;br /&gt;', '<br>', $text);
		$text = str_replace('&lt;br/&gt;', '<br>', $text);
		$text = str_replace('&lt;br \&gt;', '<br>', $text);
		$text = str_replace('&gt;', '>', $text);
		$text = str_replace('&amp;', '&', $text);
		return updateRegex($text);
	}
?>
