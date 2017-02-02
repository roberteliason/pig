<?php

/**
 * Procedural Illustration Generator
 *
 * @todo derive color set from seed
 */
class PIG
{
	private $shapesCountX = 0;
	private $shapesCountY = 0;
	private $shapeX = 0;
	private $shapeY = 0;
	private $seed = '';
	private $colors = [];
	private $backgroundColor = '';


	/**
	 * PIG constructor.
	 *
	 * @param string $seed
	 * @param array  $colors
	 * @param string $backgroundColor
	 * @param int    $width
	 * @param int    $height
	 * @param int    $shapesCountX
	 * @param int    $shapesCountY
	 */
	public function __construct(
		$seed = '',
		$colors = [],
		$backgroundColor = '',
		$width = 0,
		$height = 0,
		$shapesCountX = 0,
		$shapesCountY = 0
	) {
		if (empty($seed)) {
			$this->seed = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';
		} else {
			$this->seed = $seed;
		}

		if (empty($colors)) {
			$this->colors = ['white', 'gray', 'black'];
		} else {
			$this->colors = $colors;
		}

		if (empty($backgroundColor)) {
			$this->backgroundColor = 'light-gray';
		} else {
			$this->backgroundColor = $backgroundColor;
		}

		if (empty($width)) {
			$this->shapeX = 10;
		} else {
			$this->shapeX = $width;
		}

		if (empty($height)) {
			$this->shapeY = 10;
		} else {
			$this->shapeY = $height;
		}

		if (empty($shapesCountX)) {
			$this->shapesCountX = 20;
		} else {
			$this->shapesCountX = $shapesCountX;
		}

		if (empty($shapesCountY)) {
			$this->shapesCountY = 15;
		} else {
			$this->shapesCountY = $shapesCountY;
		}
	}


	/**
	 * @return int
	 */
	public function getCanvasWidth()
	{
		return (int)$this->shapesCountX * $this->shapeX;
	}


	/**
	 * @return int
	 */
	public function getCanvasHeight()
	{
		return (int)$this->shapesCountY * $this->shapeY;
	}


	/**
	 * Get the count of color array
	 *
	 * @return int
	 */
	public function getNumberOfColors()
	{
		return count($this->colors);
	}


	/**
	 * Convert UTF-8 to ASCII for later use
	 *
	 * @return string
	 */
	protected function transliteratSeed()
	{
		$this->seed = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $this->seed);
	}


	/**
	 * Get the numeric value of the ASCII char
	 *
	 * @param  string $char
	 *
	 * @return int
	 */
	protected function convertCharToDecimal($char)
	{
		return ord($char);
	}


	/**
	 * Get X of upper left corner of shape
	 *
	 * @param  string $char
	 *
	 * @return int
	 */
	protected function getX0($char)
	{
		$int = $this->convertCharToDecimal($char);

		return ($int % $this->shapesCountX) * $this->shapeX;
	}


	/**
	 * Get Y of upper left corner of shape
	 *
	 * @param  string $char
	 *
	 * @return int
	 */
	protected function getY0($char)
	{
		$int = $this->convertCharToDecimal($char);

		return ($int % $this->shapesCountY) * $this->shapeY;
	}


	/**
	 * Map a color to a given integer value
	 *
	 * @param string $char
	 *
	 * @return string
	 */
	protected function getColor($char)
	{
		$int        = $this->convertCharToDecimal($char);
		$colorIndex = floor($int % $this->getNumberOfColors());

		return $this->colors[$colorIndex];
	}


	/**
	 * Convert the seed into shape data
	 *
	 * @return array
	 */
	public function proceduralGenerator()
	{
		$seedLength = strlen($this->seed);
		$iterations = $seedLength - ($seedLength % 3);
		$shapes     = [];
		echo("$iterations iterations" . PHP_EOL);

		for ($i = 0; $i <= $iterations; $i += 3) {
			$shapes[] = [
				'x0' => $this->getX0($this->seed[$i]),
				'y0' => $this->getY0($this->seed[$i + 1]),
				'c'  => $this->getColor($this->seed[$i + 2]),
			];
		}

		return $shapes;
	}


	/**
	 * Output the PIG as SVG
	 *
	 * @return string
	 */
	public function renderSVG()
	{
		$canvasWidth  = $this->getCanvasWidth();
		$canvasHeight = $this->getCanvasHeight();
		$svgHeader    = '<svg width="%d" height="%d" version="1.1" xmlns="http://www.w3.org/2000/svg">';
		$rectangle    = '<rect x="%d" y="%d" width="%s" height="%s" fill="%s"/>';

		$output = sprintf(
			          $svgHeader,
			          $canvasWidth,
			          $canvasHeight
		          ) . PHP_EOL;

		$output .= "\t" . sprintf(
				$rectangle,
				0,
				0,
				'100%',
				'100%',
				$this->backgroundColor
			) . PHP_EOL;

		foreach ($this->proceduralGenerator() as $key => $shape) {
			$output .= "\t" . sprintf(
					$rectangle,
					$shape['x0'],
					$shape['y0'],
					$this->shapeX,
					$this->shapeY,
					$shape['c']
				) . PHP_EOL;
		}
		$output .= '</svg>';

		return $output;
	}


	/**
	 * Write SVG output to file
	 *
	 * @param string $filename
	 */
	public function saveSVG($filename = 'pig.svg')
	{
		$svg  = $this->renderSVG();
		$path = dirname(__FILE__) . '/' . $filename;
		var_dump($path);

		file_put_contents($path, $svg);
	}


	/**
	 * Dump raw seed conversion to STD OUT
	 */
	public function getRawDataFromSeed()
	{
		foreach ($this->proceduralGenerator() as $key => $value) {
			echo("X0={$value['x0']}, Y0={$value['y0']}, Color={$value['c']}" . PHP_EOL);
		}
	}
}

$ThePIG = New PIG(
	'lkjhagpiauJLKJHFÖWKBÖFBÖWGDI¨.,§ÖWGfi¸<>ß≈ç+4uwpi!"#€%&/()(="€)?=)(€egfökawegöjhsrögjhöaugaigptaweJLKJHFÖWKBÖFBÖWGDI¨.,§ÖWGfi¸<>ß≈ç+4uwpi!"#€%&/()(="€)?=)(€egfökawegöjhsrögjhöaugaigptaweöfhöakjhgökharfiyaiwuefWKBÖFBÖWGDI¨.,§ÖWGfi¸<>ß≈ç+4uwpi!"#€%&/()(="€)?=)(€egfökawegöjhsrögjhöaugaigptaJLKJHFÖWKBÖFBÖWGDI¨.,§ÖWGfi¸<>ß≈ç+4uwpi!"#€%&/()(="€)?=)(€egfökawegöjhsrögjhöaugaigptawe',
	[
		'rgba(255,220,190,0.5)',
		'rgba(190,255,220,0.5)',
		'rgba(220,190,255,0.5)',
		'rgba(255,220,250,0.25)',
		'rgba(150,255,220,0.25)',
		'rgba(220,250,255,0.25)'
	],
	'rgba(0, 0, 0, 0.5)',
	50, 50, 16, 12
);
$ThePIG->getRawDataFromSeed();
$ThePIG->saveSVG('shapes.svg');
