
UBBMarkup
=========

UBBMarkup makes mixing PHP and HTML easy by staying in the world of PHP. UBB Markup is a slim template engine, but has no own syntax.

I started this project because mixing PHP and HTML drove me nuts. I don't like escaping and I don't like to end and begin the php parts of one file. But I also don't want to use a third language extra for templateing. So this is my take on it.



Examples
--------

```php

m("section.meta"); /* <section class="meta"> */
m("/section"); /* </section> */

m("title", "Web Page"); /* <title>Web Page</title> */

m("a", "href", "http://apple.com", "Apple"); /* <a href="http://apple.com">Apple</a> */

m("option", "selected", "selected","Yes"); /* <option selected>Yes</option> */

m("#content"); /* <div id="content"> */
m("/"); /* </div> */

m("article#post.featured", "class", "new"); /* <article id="post" class="featured new"> */
m("/article"); /* </article> */

m("body", "class", undefined); /* <body> */
```



How does it work?
-----------------

- First argument is the tag
- The following arguments are interpreted as pairs of attributes and values
- If the last argument is not a value it is intepreted as inner text and the tag gets closed after it

```php
m(tag, attribute, value, attribute, value, attribute, value);
m(tag, attribute, value, attribute, value, inner text);
m(tag, inner text);
```


Demo
----

```php
require_once "class.ubbmarkup.php";

$ubb_markup = new UBBMarkup();

// Define Global Convenience Function
function m() {
	print(call_user_func_array(array($GLOBALS["ubb_markup"], "create_element"), func_get_args()));
}

// Alternative Local Convenience Function
// $m = function() use ($ubb_markup) {
//   print(call_user_func_array(array($ubb_markup, "create_element"), func_get_args()));
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
m("!DOCTYPE","html","html");
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
```


Output
------
```html
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>UBBMarkup Demo Page</title>
</head>
<body>
	<div id="content">
		<h1>Uberlinks</h1>
		<ul class="linklist">
			<li class="first"><a href="https://github.com/uberbruns" title="My Github Profile">My Github Profile</a></li>
			<li><a href="https://twitter.com/stephenfry" title="Stephen Fry on Twitter">Stephen Fry on Twitter</a></li>
			<li class="pony"><a href="http://ponyfac.es" title="Say it with a pony">Say it with a pony</a></li>
			<li><a href="http://xkcd.com/927/" title="Standards">Standards</a></li>
			<li class="last"><a href="http://www.youtube.com/watch?v=pOyDW_Y2Emo" title="Hypercritcal Song">Hypercritcal Song</a></li>
		</ul>
	</div>
</body>
</html>
```



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