<?php

namespace PIG_Space\Generators;

use PIG_Space\SVG\SVG_Rectangle as SVG_Rectangle;
use PIG_Space\SVG\SVG_Circle as SVG_Circle;

class Round_PIG extends PIG
{
	protected $shapeRadius   = 0;
	protected $shapeDiameter = 0;

	/**
	 * PIG constructor.
	 *
	 * @param string $seed
	 * @param array  $colors
	 * @param string $backgroundColor
	 * @param int    $radius
	 * @param int    $shapesCountX
	 * @param int    $shapesCountY
	 */
	public function __construct(
		$seed = '',
		$colors = [],
		$backgroundColor = '',
		$radius = 0,
		$shapesCountX = 0,
		$shapesCountY = 0
	) {
		parent::__construct();

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

		$this->shapeDiameter = 2 * $this->shapeRadius;
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
		$x0  = (($int % $this->shapesCountX) * $this->shapeDiameter) + $this->shapeRadius;
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
		$y0  = (($int % $this->shapesCountY) * $this->shapeDiameter) + $this->shapeRadius;
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
		return (int)$this->shapesCountX * $this->shapeDiameter;
	}


	/**
	 * @return int
	 */
	protected function getCanvasHeight()
	{
		return (int)$this->shapesCountY * $this->shapeDiameter;
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

		$output = sprintf(
			          $svgHeader,
			          $canvasWidth,
			          $canvasHeight
		          ) . PHP_EOL;

		$output .= "\t" . $background->getShape() . PHP_EOL;

		foreach ($this->proceduralGenerator() as $key => $shape) {
			$rectangle = New SVG_Circle(
				[
					'x0'        => $shape['x0'],
					'y0'        => $shape['y0'],
					'radius'    => $this->shapeRadius,
					'fillColor' => $shape['c'],
				]
			);

			$output .= "\t" . $rectangle->getShape() . PHP_EOL;
		}
		$output .= '</svg>';

		return $output;
	}

}