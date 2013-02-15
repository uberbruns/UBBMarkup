<?php

/*


The MIT License
---------------

Copyright (c) 2012 Karsten Bruns (karsten{at}bruns{dot}me)

Permission is hereby granted, free of charge, to any person obtaining
a copy of this software and associated documentation files (the
'Software'), to deal in the Software without restriction, including
without limitation the rights to use, copy, modify, merge, publish,
distribute, sublicense, and/or sell copies of the Software, and to
permit persons to whom the Software is furnished to do so, subject to
the following conditions:

The above copyright notice and this permission notice shall be
included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED 'AS IS', WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY
CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT,
TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE
SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/

class UBBMarkup {

	public function create_element() {

		$parsed_input = $this->parse_args(func_get_args());
		$return = $parsed_input["html"];

		// if (!$return) {
		// 	print_r(func_get_args());
		// 	print_r($parsed_input);
		// 	exit;
		// }

		return $return;
			
	}


	protected function close_element($tag) {

		if (!$tag) {
			$tag = "div";
		}

		return sprintf("</%s>", $tag);

	}


	public function parse_args($args, $filter=null) {

		$attr_dict = array();
		$tag = null;
		$text = null;
		$attr = null;
		$val = null;


		// Parse Function Arguments to Tags, Atrributes and Values
		// - First arg is the tag
		// - Any odd numbered argument is an attribute, except if it is the last argument
		// - Any even argument is a value
		// - The last odd-numbered argument is text
		for ($i=0; $i < count($args); $i++) { 
			$arg = $args[$i];
			if ($i == 0) {
				$tag = $arg;
				if (substr($tag, 0, 1) == "/") {
					return array("html" => $this->close_element(substr($tag, 1)), "tag" => $tag);
				} 
			} else if ($i%2 == 1) {
				if ($i < count($args)-1) {
					$attr = $arg;
				} else {
					$text = $arg;
				}
			} else if ($i%2 == 0) {
				$val = $arg;
				if ($val) {
					$attr_dict[$attr] = $val;
				}
			}
		}


		// Tag, Classes, IDs
		$tag = str_replace(".", "&.&", $tag);
		$tag = str_replace("#", "&#&", $tag);
		$tag = trim($tag, "&");
		$tag_components = explode("&", $tag);
		$tag_classes = array();
		$selector_kind = ".";
		$tag = 'div';
		

		for ($i=0; $i < count($tag_components); $i++) { 
			$c = trim($tag_components[$i]);
			if ($c == ".") {
				$selector_kind = ".";
			} else if ($c == "#") {
				$selector_kind = "#";
			} else if ($i == 0) {
				$tag = $c;
			} else {
				if ($selector_kind == ".") {
					$tag_classes[] = $c;
				} else if ($selector_kind == "#") {
					$attr_dict["id"] = $c;
				}
			}
		}


		if (count($tag_classes)) {
			if (!isset($attr_dict["class"])) $attr_dict["class"] = "";
			$attr_dict["class"] = trim(implode(" ", $tag_classes) . " " . $attr_dict["class"]);
		}


		// Print Tag
		$out = "<" . $tag;
		foreach ($attr_dict as $attr => $val) {
			if (!$filter || in_array($attr, $filter)) {
				if ($attr == $val || $val === true || $val === 1) {
					$out .= " " . $attr;
				} else if ($val) {
					$out .= " " . $attr . "=\"" . trim($val) . "\"";
				}
			}
		}
		$out .= ">";


		// Close Tag
		if ($text !== null) {
			$out .= $text;
			$out .= $this->close_element($tag);
			if ($text === FALSE) {
				return array("html" => "", "tag" => $tag);
			}
		}

		return array("html" => $out, "tag" => $tag, "attributes" => $attr_dict, "text" => $text);

	}



}

?>