<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Protegeme extends Model
{
	public function remplaza_caracteres_fotos($string)
	{
		$string = trim($string);
         $string = str_replace(
             array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
             array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
             $string
         );
         $string = str_replace(
             array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
             array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
             $string
         );
         $string = str_replace(
             array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
             array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
             $string
         );

         $string = str_replace(
             array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
             array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
             $string
         );
         $string = str_replace(
             array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
             array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
             $string
         );
         $string = str_replace(
             array('ñ', 'Ñ', 'ç', 'Ç'),
             array('n', 'N', 'c', 'C',),
             $string
         );
         //Esta parte se encarga de eliminar cualquier caracter extraño
         $string = str_replace(
             array("\\", "¨", "º", " ", "~",
                  "#", "@", "|", "!", "\"",
                  "·", "$", "%", "&", "/",
                  "(", ")", "?", "'", "¡",
                  "¿", "[", "^", "`", "]",
                  "+", "}", "{", "¨", "´",
                  ">", "< ", ";", ",", ":",
                  " ", "=", "*", "~","°"),
             '_',
             $string
         );
         return $string;
	}
	public function remplaza_caracteres($string){
         $string = trim($string);
         $string = str_replace(
             array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
             array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
             $string
         );
         $string = str_replace(
             array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
             array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
             $string
         );
         $string = str_replace(
             array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
             array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
             $string
         );

         $string = str_replace(
             array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
             array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
             $string
         );
         $string = str_replace(
             array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
             array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
             $string
         );
         $string = str_replace(
             array('ñ', 'Ñ', 'ç', 'Ç'),
             array('n', 'N', 'c', 'C',),
             $string
         );
         //Esta parte se encarga de eliminar cualquier caracter extraño
         $string = str_replace(
             array("\\", "¨", "º", ".", "~",
                  "#", "@", "|", "!", "\"",
                  "·", "$", "%", "&", "/",
                  "(", ")", "?", "'", "¡",
                  "¿", "[", "^", "`", "]",
                  "+", "}", "{", "¨", "´",
                  ">", "< ", ";", ",", ":",
                  " ", "=", "*", "~","°"),
             '',
             $string
         );
         return $string;
     }
	// define( 'SAFE_HTML_VERSION', 'safe_html.php/0.6' );

/*	if ( isset($_GET['source']) and !empty( $_GET['source'] ) && $_GET['source']=='safe_html' ) {
	  header('Content-Type: text/plain');
	  exit( file_get_contents( __FILE__ ) );
	}*/

	// first, an HTML attribute stripping function used by safe_html()
	//   after stripping attributes, this function does a second pass
	//   to ensure that the stripping operation didn't create an attack
	//   vector.
	
	public function strip_attributes ($html, $attrs) {
	  if (!is_array($attrs)) {
	    $array= array( "$attrs" );
	    unset($attrs);
	    $attrs= $array;
	  }
	  
	  foreach ($attrs AS $attribute) {
	    // once for ", once for ', s makes the dot match linebreaks, too.
	    $search[]= "/".$attribute.'\s*=\s*".+"/Uis';
	    $search[]= "/".$attribute."\s*=\s*'.+'/Uis";
	    // and once more for unquoted attributes
	    $search[]= "/".$attribute."\s*=\s*\S+/i";
	  }
	  $html= preg_replace($search, "", $html);

	  // do another pass and strip_tags() if matches are still found
	  foreach ($search AS $pattern) {
	    if (preg_match($pattern, $html)) {
	      $html= strip_tags($html);
	      break;
	    }
	  }

	  return $html;
	}

	public function js_and_entity_check( $html ) {
	  // anything with ="javascript: is right out -- strip all tags if found
	  $pattern= "/=[\S\s]*s\s*c\s*r\s*i\s*p\s*t\s*:\s*\S+/Ui";
	  if (preg_match($pattern, $html)) {
	    return TRUE;
	  }
	  
	  // anything with encoded entites inside of tags is out, too
	  $pattern= "/<[\S\s]*&#[x0-9]*[\S\s]*>/Ui";
	  if (preg_match($pattern, $html)) {
	    return TRUE;
	  }
	  
	  return FALSE;
	}

	// the safe_html() function
	//   note, there is a special format for $allowedtags, see ~line 90
	public function safe_html ($html, $allowedtags="") {

	  // check for obvious oh-noes
	  if ( $this->js_and_entity_check( $html ) ) {
	    $html= strip_tags($html);
	    return $html;
	  }

	  // setup -- $allowedtags is an array of $tag=>$closeit pairs, 
	  //   where $tag is an HTML tag to allow and $closeit is 1 if the tag 
	  //   requires a matching, closing tag
	  if ($allowedtags=="") {
	    $allowedtags= array ( "p"=>1, "br"=>0, "a"=>1, "img"=>0, 
	                        "li"=>1, "ol"=>1, "ul"=>1, 
	                        "b"=>1, "i"=>1, "em"=>1, "strong"=>1, 
	                        "del"=>1, "ins"=>1, "u"=>1, "code"=>1, "pre"=>1, 
	                        "blockquote"=>1, "hr"=>0
	                        );
	  }
	  elseif (!is_array($allowedtags)) {
	    $array= array( "$allowedtags" );
	  }

	  // there's some debate about this.. is strip_tags() better than rolling your own regex?
	  // note: a bug in PHP 4.3.1 caused improper handling of ! in tag attributes when using strip_tags()
	  $stripallowed= "";
	  foreach ($allowedtags AS $tag=>$closeit) {
	    $stripallowed.= "<$tag>";
	  }

	  //print "Stripallowed: $stripallowed -- ".print_r($allowedtags,1);
	  $html= strip_tags($html, $stripallowed);

	  // also, lets get rid of some pesky attributes that may be set on the remaining tags...
	  // this should be changed to keep_attributes($htmlm $goodattrs), or perhaps even better keep_attributes
	  //  should be run first. then strip_attributes, if it finds any of those, should cause safe_html to strip all tags.
	  $badattrs= array("on\w+", "style", "fs\w+", "seek\w+");
	  $html= $this->strip_attributes($html, $badattrs);

	  // close html tags if necessary -- note that this WON'T be graceful formatting-wise, it just has to fix any maliciousness
	  foreach ($allowedtags AS $tag=>$closeit) {
	    if (!$closeit) continue;
	    $patternopen= "/<$tag\b[^>]*>/Ui";
	    $patternclose= "/<\/$tag\b[^>]*>/Ui";
	    $totalopen= preg_match_all ( $patternopen, $html, $matches );
	    $totalclose= preg_match_all ( $patternclose, $html, $matches2 );
	    if ($totalopen>$totalclose) {
	      $html.= str_repeat("</$tag>", ($totalopen - $totalclose));
	    }
	  }
	  
	  // check (again!) for obvious oh-noes that might have been caused by tag stipping
	  if ( $this->js_and_entity_check( $html ) ) {
	    $html= strip_tags($html);// ."<!--xss stripped after processing-->";
	    return $html;
	  }
	  return $html;
	}

	
}
