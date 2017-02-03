<?php

namespace PIG_Space;

class SVG_Circle implements SVG_Shape
{
	/**
	 * @var string
	 */
	private $template;
	/**
	 * Center X
	 *
	 * @var int
	 */
	private $x0 = 0;
	/**
	 * Center Y
	 *
	 * @var int
	 */
	private $y0 = 0;
	/**
	 * @var string
	 */
	private $radius = '10';
	/**
	 * @var string
	 */
	private $fillColor = 'black';


	/**
	 * SVG_Rectangle constructor.
	 *
	 * @param array $args
	 */
	public function __construct( $args = [] ) {
		$this->setArgs( $args );
	}


	/**
	 * Parse array of arguments and apply if correctly set
	 *
	 * @param array $args
	 */
	public function setArgs($args = [])
	{
		$this->setTemplate();

		if ( ! empty($args)) {
			if (isset($args['x0'])) {
				$this->x0 = $args['x0'];
			}
			if (isset($args['y0'])) {
				$this->y0 = $args['y0'];
			}
			if (isset($args['radius'])) {
				$this->radius = $args['radius'];
			}
			if (isset($args['fillColor'])) {
				$this->fillColor = $args['fillColor'];
			}
		}
	}


	/**
	 * Set a markup template for sprintf
	 */
	private function setTemplate()
	{
		$this->template = '<circle cx="%d" cy="%d" r="%s" fill="%s"/>';
	}


	/**
	 * Apply args to template
	 *
	 * @return string
	 */
	public function getShape()
	{
		return sprintf(
			$this->template,
			$this->x0,
			$this->y0,
			$this->radius,
			$this->fillColor
		);
	}
}
