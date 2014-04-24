<?php

$chars = array_merge(range('a', 'z'), range('A', 'Z'));

echo createText(rand(10, 50))."<br/>";

$titles = array();

$start = microtime(true);

for ($i = 0; $i < 100000; $i++) {
	array_push($titles, createSentence());
}

$end = microtime(true);

echo "Berechnungszeit: ".($end - $start);

function createText($num_sentences) {
	$txt = '';
	for ($i = 0; $i < $num_sentences; $i++) {
		$sentence = createSentence();
		$txt .= " $sentence";
	}
	return $txt;
}

function createSentence($min, $max) {
	$wc = rand($min, $max);
	$txt = createWord();
	for ($i = 0; $i < $wc; $i++) {
		$word = createWord();
		$txt .= " $word";
	}
	$txt .= '.';
	return $txt;
}

function createWord() {
	global $chars;
	shuffle($chars);
	return substr(implode($chars), 0, rand(3, 10));
}