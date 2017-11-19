<?php

namespace PIG_Space\Generators;

use PIG_Space\InfiniteSeed;
use PIG_Space\SVG\SVG_Rectangle as SVG_Rectangle;
use PIG_Space\SVG\SVG_Circle as SVG_Circle;
use PIG_Space\SVG\SVG_CircularGradient as SVG_CircularGradient;
use PIG_Space\SVG\SVG_GaussianFilter as SVG_GaussianFilter;

class FancyRound_PIG extends PIG
{
	protected $shapeRadius   = 0;
	protected $shapeDiameter = 0;
	protected $gradient      = null;
	protected $filter        = null;

	/**
	 * PIG constructor.
	 *
	 * @param string $seed
	 * @param array  $colors
	 * @param string $backgroundColor
	 * @param int    $radius
	 * @param int    $shapesCountX
	 * @param int    $shapesCountY
	 * @param int    $iterations
	 */
	public function __construct(
		$seed = '',
		$colors = [],
		$backgroundColor = '',
		$radius = 0,
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

		if (empty($radius)) {
			$this->shapeRadius = 10;
		} else {
			$this->shapeRadius = $radius;
		}

		if (empty($iterations) && !is_numeric($iterations)) {
			$this->iterations = 999;
		} else {
			$this->iterations = intval($iterations);
		}

		$this->shapeDiameter = 2 * $this->shapeRadius;
		$this->gradient      = New SVG_CircularGradient(['name' => 'radialGradient', 'colors' => $this->colors]);
		$this->filter        = New SVG_GaussianFilter(['name' => 'blur', 'amount' => 0.5]);
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
		$x0  = (($int % $this->shapesCountX) * $this->shapeRadius) + $this->shapeRadius;
		if ($x0 > ($this->getCanvasWidth() - $this->shapeRadius)) {
			return $this->getCanvasWidth() - $this->shapeDiameter;
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
		$y0  = (($int % $this->shapesCountY) * $this->shapeRadius) + $this->shapeRadius;
		if($y0 > ($this->getCanvasHeight() - $this->shapeRadius)) {
			return $this->getCanvasHeight() - $this->shapeDiameter;
		}

		return $y0;
	}


	/**
	 * @return int
	 */
	protected function getCanvasWidth()
	{
		return (int)$this->shapesCountX * $this->shapeRadius;
	}


	/**
	 * @return int
	 */
	protected function getCanvasHeight()
	{
		return (int)$this->shapesCountY * $this->shapeRadius;
	}


	/**
	 * Get the count of gradient array
	 *
	 * @return int
	 */
	protected function getNumberOfGradients()
	{
		return count($this->gradient->getGradientNames());
	}


	/**
	 * Map a color to a given integer value
	 *
	 * @param string $char
	 *
	 * @return string
	 */
	protected function getGradient($char)
	{
		$int           = $this->convertCharToDecimal($char);
		$colorIndex    = floor($int % $this->getNumberOfGradients());
		$gradientNames = $this->gradient->getGradientNames();

		return $gradientNames[$colorIndex];
	}


	/**
	 * Convert the seed into shape data
	 *
	 * @return array
	 */
	protected function proceduralGenerator()
	{
		$shapes     = [];

		for ($i = 0; $i <= $this->iterations; $i += 3) {
			$shapes[] = [
				'x0' => $this->getX0($this->seed->getNext()),
				'y0' => $this->getY0($this->seed->getNext()),
				'c'  => 'url(#'.$this->getGradient($this->seed->getNext()).')',
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
		$background   = New SVG_Rectangle(
			['x0' => 0, 'y0' => 0, 'width' => '100%', 'height' => '100%', 'fillColor' => $this->backgroundColor,]
		);

		$output  = sprintf(
			          $svgHeader,
			          $canvasWidth,
			          $canvasHeight
		          ) . PHP_EOL;

		$output .= $this->gradient->getGradients();

		$output .= $this->filter->getFilter();

		$output .= "\t" . $background->getShape() . PHP_EOL;

		foreach ($this->proceduralGenerator() as $key => $shape) {
			$circle = New SVG_Circle(
				[
					'x0'        => $shape['x0'],
					'y0'        => $shape['y0'],
					'radius'    => $this->shapeRadius,
					'fillColor' => $shape['c'],
					'filter'    => 'url(#'.$this->filter->getName().')',
				]
			);

			$output .= "\t" . $circle->getShape() . PHP_EOL;
		}
		$output .= '</svg>';

		return $output;
	}

}