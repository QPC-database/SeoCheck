<?php
class Controller
{

	/*
	* 
	*	Converts strings to booleans for ease of handling
	* 
	*/
	public function strtoboo($str) {
		return filter_var( $str, FILTER_VALIDATE_BOOLEAN);
	}

	/*
	* 
	*	Regex strips the ga code from the sites source code
	* 
	*/
	public function getAnalytics($str){
		$source = file_get_contents($str);
		$regex = preg_match('/ua-[0-9]{5,}-[0-9]{1,}/i', $source, $matches);
		return strtolower($matches[0]);
	}

	/*
	* 
	*	Compares the sites GA code to the DB GA code
	* 
	*/
	public function checkGA($row, $ga) {
		$dbGa = strtolower($row->ga_code);
		if($ga !== $dbGa) {
			return false; 
		} else {
			return true;
		}
	}

	public function indexError( $indexNeeded, $crawlable ) {
		if( $indexNeeded ) {
			if( !$crawlable ) {
				if( HTML_EMAIL ) {
					return "<b style='color: red'>not indexable when it should be!</b>";
				} else {
					return "not indexable when it should be!";
				}
			} else {
				return false;
			}
		} elseif( !$indexNeeded ) {
			if( $crawlable ) {
				if( HTML_EMAIL ) {
					return "<b style='color: red'>indexable when it shouldn't be!</b>";
				} else {
					return "indexable when it shouldn't be!";
				}
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
}
