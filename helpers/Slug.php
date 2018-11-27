<?php
namespace app\helpers;
class Slug
{
	public static function generateSlug($text)
	{
		$text = preg_replace('~[^\pL\d]+~u', '-', $text);

		// transliterate
		$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

		// remove unwanted characters
		$text = preg_replace('~[^-\w]+~', '', $text);

		// trim
		$text = trim($text, '-');

		// remove duplicate -
		$text = preg_replace('~-+~', '-', $text);

		// lowercase
		$text = strtolower($text);

		if (empty($text)) {
		return '';
		}

		return $text;
	}

	// $text = preg_replace('/\s+/','-', $text); 
 //    return $text = rawurldecode($text); 
}
?>