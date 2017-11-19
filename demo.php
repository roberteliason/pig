<?php

spl_autoload_register(function ($class) {

	// project-specific namespace prefix
	$prefix = 'PIG_Space';

	// base directory for the namespace prefix
	$base_dir = __DIR__ . '/classes/';

	// does the class use the namespace prefix?
	$len = strlen($prefix);
	if (strncmp($prefix, $class, $len) !== 0) {
		// no, move to the next registered autoloader
		return;
	}

	// get the relative class name
	$relative_class = substr($class, $len);

	// replace the namespace prefix with the base directory, replace namespace
	// separators with directory separators in the relative class name, append
	// with .php
	$file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

	// if the file exists, require it
	if (file_exists($file)) {
		require $file;
	}
});

$seed   = 'The term procedural refers to the process that computes a particular function. Fractals are geometric patterns which can often be generated procedurally. Commonplace procedural content includes textures and meshes. Sound is often also procedurally generated, and has applications in both speech synthesis as well as music. It has been used to create compositions in various genres of electronic music by artists such as Brian Eno who popularized the term "generative music".[1]';
$seed  .= 'While software developers have applied procedural generation techniques for years, few products have employed this approach extensively. Procedurally generated elements have appeared in earlier video games: The Elder Scrolls II: Daggerfall takes place in a mostly procedurally generated world, giving a world roughly twice the actual size of the British Isles.[clarification needed] Soldier of Fortune from Raven Software uses simple routines to detail enemy models, while its sequel featured a randomly-generated level mode. Avalanche Studios employed procedural generation to create a large and varied group of detailed tropical islands for Just Cause. No Man\'s Sky, a game developed by games studio Hello Games, is all based upon procedurally generated elements.';
//$seed  .= 'The modern demoscene uses procedural generation to package a great deal of audiovisual content into relatively small programs.';
//$seed  .= 'New methods and applications are presented annually in conferences such as the IEEE Conference on Computational Intelligence and Games and Artificial Intelligence and Interactive Digital Entertainment.[2]';

$colors = [ 'rgba(255,220,190,0.15)',
		    'rgba(190,255,220,0.15)',
		    'rgba(220,190,255,0.15)',
		    'rgba(255,220,250,0.10)',
		    'rgba(150,255,220,0.10)',
		    'rgba(220,250,255,0.10)', ];

$backgroundColor = 'transparent';

//$ThePIG = New PIG_Space\Generators\PIG(
//	$seed,
//	$colors,
//	$backgroundColor,
//	50, 50, 16, 12, 4200
//);

//$ThePIG = New PIG_Space\Generators\Round_PIG(
//	$seed,
//	$colors,
//	$backgroundColor,
//	20, 36, 36, 2000
//);

//$ThePIG = New PIG_Space\Generators\FancyRound_PIG(
//	$seed,
//	$colors,
//	$backgroundColor,
//	40, 42, 42, 2300
//);

$ThePIG = New PIG_Space\Generators\Logo_PIG(
	$seed,
	$colors,
	$backgroundColor,
	55, 35, 25, 4200
);

//$ThePIG->getRawDataFromSeed();
$ThePIG->saveSVG('shapes.svg');
