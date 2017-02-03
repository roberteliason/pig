<?php

namespace PIG_Space\SVG;

class SVG_Rectangle implements SVG_Shape
{
	/**
	 * @var string
	 */
	private $template;
	/**
	 * Upper left corner
	 *
	 * @var int
	 */
	private $x0 = 0;
	/**
	 * Upper left corner
	 *
	 * @var int
	 */
	private $y0 = 0;
	/**
	 * @var string
	 */
	private $width = '10';
	/**
	 * @var string
	 */
	private $height = '10';
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
			if (isset($args['width'])) {
				$this->width = $args['width'];
			}
			if (isset($args['height'])) {
				$this->height = $args['height'];
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
		$this->template = '<rect x="%d" y="%d" width="%s" height="%s" fill="%s"/>';
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
			$this->width,
			$this->height,
			$this->fillColor
		);
	}
}
