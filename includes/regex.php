<?php
	function checkRegex($myText) {
		//echo 'Enter Regex Check';
		$holds = regexHolds();
		foreach($holds as $key=>$value) {
			$myText = str_replace($value, $key, $myText);
		}
		$rMatch = myRegex();
		foreach ($rMatch as $irMatch) {
			//echo $irMatch;
			if (preg_match($irMatch, $myText)) {
				return true;
			}
		}
		return false;
	}

	function updateRegex($myText) {
		$holds = regexHolds();
		foreach($holds as $key=>$value) {
			$myText = str_replace($value, $key, $myText);
		}
		$desired = myRegex();
		foreach($desired as $a=>$rMatch) {
			preg_match($rMatch, $myText, $myMatches);
			foreach ($myMatches as $cMatch) {
				$myText = str_replace($cMatch, '<span class="highlight">' . $cMatch . '</span>', $myText);
			}
		}
		return $myText;
	}
	
	function matchedRegex($myText) {
		$matchList = '<ul>';
		$holds = regexHolds();
		foreach($holds as $key=>$value) {
			$myText = str_replace($value, $key, $myText);
		}
		$desired = myRegex();
		foreach($desired as $a=>$rMatch) {
			preg_match($rMatch, $myText, $myMatches);
			foreach ($myMatches as $cMatch) {
				// Need a reference of the match for debugging
				$matchList .= '<li>' . $rMatch . '=>' . $cMatch . '</li>';
			}
		}
		return $matchList .= '</ul>';
	}
	function myRegex() {
		return array(
			//Racial
			'/\s[Nn][Ii!1][Gg]{1,2}[AaEe34][^LlKk][^Ii]/', //Nigger etc
			'/\s[Cc][Oo0]{2}[Nn]\s/', //Coon
			'/([Kk][Ii!1][Kk][Ii!1][Ee3]|[Kk][Ii!1][Kk][Ee3])/', //Kike
			'/[Gg][YyIi][Pp][SsPpOo]/', //Gypsy variants
			'/[Gg][Oo0]{2}[Kk]/', 
			'/[Aa4][Bb][Oo0][^A-Za-z]/', //Abo
			'/[Ww][Oo0][Gg]/', //Wog/Gollywog
			//Homo/Transphobic
			'/[Ff][Aa4][Gg][^EeOo]/', //Fag
			'/[Gg][Aa4][Yy][^MmNn][Oo]/', //Gay - L in position 4 could be an indicator of a slur: Gaylord
			'/\s[Dd][Ii!1Yy][Kk][Ee3Yy]/', //Dkye, trying a short hand to see what shows for now
			'/[Tt][Rr][Aa4][Nn]{1,2}[YyIi!][^FfKk]/', //Tranny
			'/[Hh][Ee3][Rr][Mm]^i/', //Hermaprodite
			'/[Pp][Oo0]{2}[Ff]/', //Poof
			// Genitalia
			'/[Bb][Ii!1][Aa]?[Tt][Cc][Hh]/', //Bitch
			'/[Pp][Ee3][Nn][Ii!][Ss]/', //Penis
			'/[Vv][Aa4][Gg][Ii!][Nn][Aa4]/', //Vagina
			'/[^a-zA-Z][Pp][Uu][Ss$]{2}/', //Pussy
			'/([Cc][Uu][Nn][Tt]|[Cc][Uu][Nn][NnIi!1][Ii!1Ee3]^n)/', //Cunt
			'/(\s[Tt][Ww][Aa4][Tt]|[Tt][Ww]@)/', //Twat
			'/\s[Dd][Ii!1Yy][CcKk][^a-jA-Jl-zL-Z]/', //Dick
			'/[Cc][Oo0][CcKk][^OoPp]^i/', //Cock
			'/[Mm][Ii!1][Dd][Gg][Ee][Tt]/', //Midget
			//'/[Vv][Ee3][Rr][Gg][Aa4]\s/', //Verga (spanish for penis)
			'/[Bb][Rr][E3][Aa4][Ss$][Tt]/', //Breast
			'/[Bb][Oo0]{2}[Bb]/', //Boob
			'/[^a-sA-Su-zU-Z][Tt][Ii!][Tt][Ss$TtIi!\s]/', //Tit
			'/([^b-zB-Z][Aa4][Ss$]{2}[^AaEeIiOoUu]|[^B-Zb-z][Aa4][Rr][Ss$][Ee3])/', //Ass/Arse
			'/[Bb][Uu][Tt]{2}[^Oo]/', //Butt
			// Mental/Neurological
			'/[^PpEe0-9][^Ss\:][Tt][Aa4][Rr][Dd][^iyoa]?/', //Tard
			'/[Pp][Aa4][Ss$][Tt][Ii!1][Cc]/', //Spastic
			//Sexualisation
			'/[Ww\s][Hh][Oo0][Aa4]?[Rr]?[Ee3][^Vv]/', //Whore/Hoe
			'/[^TtCcDd][Rr][Aa4][Pp][Ee3I!Yy]/', //Rapist, Rape, Rapy
			'/[Ss$][Mm][Aa4][Ss$][Hh]/', //Smash
			'/[Nn][Aa4][Kk][Ee3Ii!][^Nn]/', //Nudity - Naked
			'/[Nn][Uu][Dd][Ee3Ii!]/', //Nudity - Nude
			'/[Bb][Ii!][Kk][Ii!][Nn][Ii!]/', //Bikini
			'/[Ss$][Ee3][CcKkXx][YyKkIi!]/', //Sex/Secks/Sexy (variants of)
			'/[Ii!][Nn][Cc][Ee3][Ss$][Tt]/', //Incest
			'/[Pp][Aa4][Nn][Tt][Ii!Yy]/', //Panties
			'/[Pp][Oo0Rr]{2}[Nn][^EeGg]/', //Porn/Pron
			'/[Pp][Rr][Oo0][Bb][Ee3Ii!]/', //Probe
			'/[^Ii][^Nn][Tt][Ee3][Ss$][Tt][Ii!Ee3][CcEe3]?[^DdNnRr]/', //Testicles/Testies etc
			'/[Bb][Aa4][Ll]{2}[Ss$]/', //Balls
			'/[PP][Ii!][Ss$]{2}/', //Requested as pissant or variants of, might as well capture all instances of piss
			'/[Gg][Uu][Rr][Ll][Ss$Zz]/', //Gurls Gurls Gurls (to quote Motley)
			'/[Kk][Ii!][Nn][Kk]/', //Kink(y)
			'/[^a-zA-z][LlGg][Aa4][Ss4][Hh]/', //Lash/Gash
			'/[Bb][Oo0][Nn][Dd][Aa4]/', //Lazy grab for bondage
			'/[Tt][Uu][Rr][Nn][Ee3][Dd]\s[Oo0][Nn]/', //Turn(ed) on
			'/[Pp][Ee3][Rr][Vv]/', //Perv
			'/[Pp][Ii!][Mm][Pp]/', //Pimp
			'/[Bb][Uu][Ss$][Tt]/', //Bust
			'/[\s\n\r\t][Ss][Nn][Uu]\s/', // Quick and dirty for snu snu
			'/[Hh][Oo0]{2}[Kk][Ee3][Rr]/', //Hooker
			// Other concerning things
			'/[^RrOo][Pp][Ee3Aa4][Aa4Ee3]?[Dd][Oo0]/', //Peadophile, added due to an issue with Peado entry vandalism historically
			//'/[Nn][Oo0][Nn][Cc][Ee3]/', //Added Nonce just incase it comes up as the above was noted (its a british thing)
			'/[Nn][Aa4][Zz][Ii!]/', //Nazis, a good old staple
			'/[Ss4][Cc][Aa4][Ll][Pp]/', //Scalp
			'/[Tt][Uu][Bb][Ee3][Tt][OO0][Pp]/', //Tubetop (guessing they're after something far worse than a piece of clothing
			'/[Mm][Ee3][Nn][Aa4][Gg]_/', // Quick method of grabbing Menage a Trois
			'/[PP][Oo0][Gg][Rr][Oo0][Mm]/', //Pogrom
			'/[Yy][Ii!1][Dd]/', //Yid
			'/[Cc][Aa4][Bb][Aa4][Ll]/' // Cabal
			
		);
	}

	function regexHolds() {
		return array(
			'Regex69' => 'Assassin probe',
			'Regex69B' => 'assassin probe',
			'Regex70' => 'Dark Eye probe',
			'Regex1' => 'Talfaglio',
			'Regex2' => 'TheDeathofAgenKolar',
			'Regex3' => 'Pfagh',
			'Regex4' => 'Daunted Gypsy',
			'Regex5' => 'Wikipedia\:Gypsy \(MST3K\)',
			'Regex6' => 'Fagerbakke',
			'Regex7' => 'bitchx\Ssourceforge',
			'Regex7' => 'Necrófago',
			'Regex8' => 'retardant',
			'Regex9' => 'Verga Mer',
			'Regex10' => 'Fagin',
			'Regex11' => 'Advergaming',
			'Regex12' => 'Therm',
			'Regex13' => 'StarDrive',
			'Regex14' => 'Hermann',
			'Regex15' => 'Platypuss',
			'Regex16' => 'Mistwater',
			'Regex17' => 'saltwater',
			'Regex18' => 'TARDIS',
			'Regex19' => 'torpedo',
			'Regex20' => 'parsec',
			'Regex21' => 'pronoun',
			'Regex22' => 'tardis',
			'Regex22' => 'pronun',
			'Regex23' => 'Trap!',
			'Regex24' => 'Pronun',
			'Regex25' => 'Pronoun',
			'Regex26' => 'Pronunciation',
			'Regex27' => 'Skyscrape',
			'Regex28' => 'skyscrape',
			'Regex29' => 'Canadian',
			'Regex30' => 'canadian',
			'Regex31' => 'Supervisor',
			'Regex32' => 'supervisor',
			'Regex33' => 'grenade',
			'Regex34' => 'probe droid',
			'Regex34B' => 'Probe droid',
			'Regex35' => 'Titillated',
			'Regex36' => 'snake',
			'Regex37' => 'superpowers',
			'Regex38' => 'supervises',
			'Regex39' => 'perp',
			'Regex40' => 'McJediProbie',
			'Regex41' => 'harpoon',
			'Regex42' => 'robust',
			'Regex43' => 'butter',
			'Regex44' => 'impervious',
			'Regex45' => 'inadequate',
			'Regex46' => 'tardy',
			'Regex47' => 'supervision',
			'Regex48' => 'Nuke',
			'Regex49' => 'combustion',
			'Regex50' => 'Hoersch',
			'Regex51' => 'Grenade',
			'Regex52' => 'rebuttal',
			'Regex53' => 'Wars3',
			'Regex54' => 'wars3',
			'Regex55' => 'Dickinson',
			'Regex56' => 'Butter',
			'Regex57' => 'butter',
			'Regex58' => 'Petranaki',
			'Regex59' => 'petranaki',
			'Regex60' => 'Snake',
			'Regex61' => 'snake',
			'Regex62' => 'Spoon',
			'Regex63' => 'spoon',
			'Regex64' => 'ThatNerdWhoEditsWikis',
			'Regex65' => 'Spinnaker',
			'Regex66' => 'Combust',
			'Regex67' => 'combust',
			'Regex68' => 'Bondara',
			'Regex72' => 'Scalpel',
			'Regex71' => 'scalpel',
			'Regex73' => 'Longprobe',
			'Regex74' => 'longprobe',
			'Regex75' => 'Mind prob',
			'Regex76' => 'mind prob',
			'Regex77' => 'Mind Prob',
		);
	}
?>
