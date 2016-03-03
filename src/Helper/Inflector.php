<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
// +----------------------------------------------------------------------+
// | Akelos PHP Application Framework                                     |
// +----------------------------------------------------------------------+
// | Copyright (c) 2002-2006, Akelos Media, S.L.  http://www.akelos.com/  |
// | Released under the GNU Lesser General Public License                 |
// +----------------------------------------------------------------------+
// | You should have received the following files along with this library |
// | - COPYRIGHT (Additional copyright notice)                            |
// | - DISCLAIMER (Disclaimer of warranty)                                |
// | - README (Important information regarding this library)              |
// +----------------------------------------------------------------------+
/**
 * Inflector for pluralize and singularize English nouns.
 *
 * This Inflector is a port of Ruby on Rails Inflector.
 *
 * It can be really helpful for developers that want to
 * create frameworks based on naming conventions rather than
 * configurations.
 *
 * It was ported to PHP for the Akelos Framework, a
 * multilingual Ruby on Rails like framework for PHP that will
 * be launched soon.
 *
 * @author Bermi Ferrer Martinez
 * @copyright Copyright (c) 2002-2006, Akelos Media, S.L. http://www.akelos.org
 * @license GNU Lesser General Public License
 * @since 0.1
 * @version $Revision 0.1 $
 */

namespace Laztopaz\PotatoORM;

trait Inflector
{
	/**
	 * Pluralizes English nouns.
	 *
	 * @access public
	 * @static
	 * @param    string    $word    English noun to pluralize
	 * @return string Plural noun
	 */
	public static function pluralize($word)
	{
		$plural = array(
			'/(quiz)$/i'               => "$1zes",
			'/^(ox)$/i'                => "$1en",
			'/([m|l])ouse$/i'          => "$1ice",
			'/(matr|vert|ind)ix|ex$/i' => "$1ices",
			'/(x|ch|ss|sh)$/i'         => "$1es",
			'/([^aeiouy]|qu)y$/i'      => "$1ies",
			'/(hive)$/i'               => "$1s",
			'/(?:([^f])fe|([lr])f)$/i' => "$1$2ves",
			'/(shea|lea|loa|thie)f$/i' => "$1ves",
			'/sis$/i'                  => "ses",
			'/([ti])um$/i'             => "$1a",
			'/(tomat|potat|ech|her|vet)o$/i'=> "$1oes",
			'/(bu)s$/i'                => "$1ses",
			'/(alias)$/i'              => "$1es",
			'/(octop)us$/i'            => "$1i",
			'/(ax|test)is$/i'          => "$1es",
			'/(us)$/i'                 => "$1es",
			'/s$/i'                    => "s",
			'/$/'                      => "s"
		);
		$uncountable = array('equipment', 'information', 'rice', 'money', 'species', 'series', 'fish', 'sheep');
		$irregular = array(
			'person' => 'people',
			'man' => 'men',
			'child' => 'children',
			'sex' => 'sexes',
			'move' => 'moves');
		$lowercased_word = strtolower($word);
		foreach ($uncountable as $_uncountable){
			if(substr($lowercased_word,(-1*strlen($_uncountable))) == $_uncountable){
				return $word;
			}
		}
		foreach ($irregular as $_plural=> $_singular){
			if (preg_match('/('.$_plural.')$/i', $word, $arr)) {
				return preg_replace('/('.$_plural.')$/i', substr($arr[0],0,1).substr($_singular,1), $word);
			}
		}
		foreach ($plural as $rule => $replacement) {
			if (preg_match($rule, $word)) {
				return preg_replace($rule, $replacement, $word);
			}
		}
		return false;
	}
	
}