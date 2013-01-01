<?php

require_once "class.ubbmarkup.php";

$ubb_markup = new UBBMarkup();

// Global Convenience Function
function m() {
	print(call_user_func_array(array($GLOBALS["ubb_markup"], "create_element"), func_get_args()));
}

// Alternative Local Convenience Function
// $m = function() use ($ubb_markup) {
//   print(call_user_func_array(array($ubb_markup, "create_markup"), func_get_args()));
// };


// Content
$title = "UBBMarkup Demo Page";
$link_list = array(
	array("class" => "first", "href" => "https://github.com/uberbruns", "text" => "My Github Profile"),
	array("class" => "", "href" => "https://twitter.com/stephenfry", "text" => "Stephen Fry on Twitter"),
	array("class" => "pony", "href" => "http://ponyfac.es", "text" => "Say it with a pony"),
	array("class" => "", "href" => "http://xkcd.com/927/", "text" => "Standards"),
	array("class" => "last", "href" => "http://www.youtube.com/watch?v=pOyDW_Y2Emo", "text" => "Hypercritcal Song"),
);


// Print Markup
m("!DOCTYPE","html","html"); // html="html" will be compiled to "html"
m("html", "lang", "en");
m("head");
m("meta", "charset", "utf-8");
m("title", $title);
m("/head");

m("body");
m("#content");
m("h1", "Uberlinks");

m("ul.linklist");
foreach ($link_list as $item) {
	m("li", "class", $item["class"]);
	m("a", "href", $item["href"], "title", $item["text"], $item["text"]);
	m("/li");
}
m("/ul");

m("/");
m("/body");

m("/html");


?>