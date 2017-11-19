<?php

namespace PIG_Space\Generators;

use PIG_Space\InfiniteSeed;
use PIG_Space\SVG\SVG_Logo;
use PIG_Space\SVG\SVG_Rectangle as SVG_Rectangle;
use PIG_Space\SVG\SVG_Circle as SVG_Circle;
use PIG_Space\SVG\SVG_CircularGradient as SVG_CircularGradient;
use PIG_Space\SVG\SVG_GaussianFilter as SVG_GaussianFilter;

class Logo_PIG extends PIG
{
	protected $shapeSize = 0;
	protected $gradient;
	protected $filter;
	protected $logo;

	/**
	 * PIG constructor.
	 *
	 * @param string $seed
	 * @param array  $colors
	 * @param string $backgroundColor
	 * @param int    $size
	 * @param int    $shapesCountX
	 * @param int    $shapesCountY
	 * @param int    $iterations
	 */
	public function __construct(
		$seed = '',
		$colors = [],
		$backgroundColor = '',
		$size = 0,
		$shapesCountX = 0,
		$shapesCountY = 0,
		$iterations = 999
	) {
		parent::__construct();

		if (empty($seed)) {
			$seed = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';
		}
		$this->seed = new InfiniteSeed($seed);

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

		if (empty($size)) {
			$this->shapeSize = 10;
		} else {
			$this->shapeSize = $size;
		}

		if (empty($iterations) && ! is_numeric($iterations)) {
			$this->iterations = 999;
		} else {
			$this->iterations = intval($iterations);
		}

		$this->logo          = New SVG_Logo();
	}

	/**
	 * Get X of center of shape
	 *
	 * @param  string $char
	 *
	 * @return int
	 */
	protected function getX0($char)
	{
		$int = $this->convertCharToDecimal($char);
		$x0  = (($int % $this->shapesCountX) * $this->shapeSize) + $this->shapeSize;
		if ($x0 > ($this->getCanvasWidth() - $this->shapeSize)) {
			return $this->getCanvasWidth() - $this->shapeSize * 2;
		}

		return $x0;
	}


	/**
	 * Get Y of center of shape
	 *
	 * @param  string $char
	 *
	 * @return int
	 */
	protected function getY0($char)
	{
		$int = $this->convertCharToDecimal($char);
		$y0  = (($int % $this->shapesCountY) * $this->shapeSize) + $this->shapeSize;
		if ($y0 > ($this->getCanvasHeight() - $this->shapeSize)) {
			return $this->getCanvasHeight() - $this->shapeSize * 2;
		}

		return $y0;
	}


	/**
	 * @return int
	 */
	protected function getCanvasWidth()
	{
		return (int)$this->shapesCountX * $this->shapeSize;
	}


	/**
	 * @return int
	 */
	protected function getCanvasHeight()
	{
		return (int)$this->shapesCountY * $this->shapeSize;
	}


	/**
	 * Convert the seed into shape data
	 *
	 * @return array
	 */
	protected function proceduralGenerator()
	{
		$shapes = [];

		for ($i = 0; $i <= $this->iterations; $i += 3) {
			$shapes[] = [
				'x0' => $this->getX0($this->seed->getNext()),
				'y0' => $this->getY0($this->seed->getNext()),
				'c'  => $this->getColor($this->seed->getNext()),
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
		$svgHeader    = '<svg width="%d" height="%d" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">';
		$background   = New SVG_Rectangle(
			['x0' => 0, 'y0' => 0, 'width' => '100%', 'height' => '100%', 'fillColor' => $this->backgroundColor,]
		);

		$output = sprintf(
			          $svgHeader,
			          $canvasWidth,
			          $canvasHeight
		          ) . PHP_EOL;

		$output .= $this->logo->getDefs();

		$output .= "\t" . $background->getShape() . PHP_EOL;

		foreach ($this->proceduralGenerator() as $key => $shape) {
			$circle = New SVG_Logo(
				[
					'x0'        => $shape['x0'],
					'y0'        => $shape['y0'],
					'size'      => $this->shapeSize,
					'fillColor' => $shape['c']
				]
			);

			$output .= "\t" . $circle->getShape() . PHP_EOL;
		}
		$output .= '</svg>';

		return $output;
	}

}