<?php

namespace PIG_Space\SVG;

class SVG_Logo implements SVG_Shape
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
	private $size = '10';
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
			if (isset($args['size'])) {
				$this->size = $args['size'];
			}
			if (isset($args['fillColor'])) {
				$this->fillColor = $args['fillColor'];
			}
		}
	}


	public function getDefs() {
		$defs  = '	<defs>';
		$defs .= '		<symbol id="logo" data-name="logo" viewBox="0 0 257.48 257.16">';
        $defs .= '    		<path d="M158.58,174.94c-4,0-8.37-.27-8.75-.31a3.18,3.18,0,0,1-3-3.34h0V91.79h0a3.38,3.38,0,0,1,.95-2.39,3.74,3.74,0,0,1,2.62-1c1.7-.06,3.3-.06,4.72-.06,23,0,44.41,4.73,57,14.66,7,5.52,13.38,14.83,13.38,28.86,0,16.72-9.63,25.23-13.91,28.86C199.25,170.37,179.18,174.94,158.58,174.94Zm93.31-75.19a6.51,6.51,0,0,1-4.12-1.61,64.85,64.85,0,0,0-9.24-6.63C216.86,78.58,185,74.32,154.26,74.32c-11,0-31,.47-38.52,2.05a8.07,8.07,0,0,0-4.08,1.85c-1.09,1.11-1.27,2.32-1.27,4.19V180h0a5.27,5.27,0,0,0,1.38,3.74,5.61,5.61,0,0,0,2.9,1.43c8.71,1.73,28.33,3,45.75,3,15.78,0,48.69-.78,74.1-14.35a84.31,84.31,0,0,0,13.23-8.93,6.38,6.38,0,0,1,4.12-1.59,5.63,5.63,0,0,1,3.93,1.44c1.18,1.14,1.65,2.67,1.65,5v68.58c0,6.52-1.34,10.69-4.75,14.1s-7.6,4.75-14.09,4.75H18.85c-5.46,0-10.2-.84-14.09-4.73S0,243.75,0,238.31V18.85C0,12.4,1.34,8.14,4.75,4.73S12.47,0,18.85,0H238.61c6.48,0,10.69,1.33,14.1,4.75s4.75,7.72,4.75,14.1V93.6a6.21,6.21,0,0,1-1.57,4.62A5.49,5.49,0,0,1,251.89,99.75ZM82.38,81.16c0-2-.31-3.29-1.33-4.31a5.8,5.8,0,0,0-4-1.28H51.89a5.8,5.8,0,0,0-4,1.28c-1,1-1.33,2.27-1.33,4.31v100c0,2,.31,3.29,1.33,4.32a5.85,5.85,0,0,0,4,1.28H77a5.85,5.85,0,0,0,4-1.28c1-1,1.33-2.28,1.33-4.32Z"/>';
        $defs .= '		</symbol>';
    	$defs .= '	</defs>';

    	return $defs;
	}


	/**
	 * Set a markup template for sprintf
	 */
	private function setTemplate()
	{
		$this->template = '<use xlink:href="#logo" x="%d" y="%d" width="%d" height="%d" fill="%s"/>';
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
			$this->size,
			$this->size,
			$this->fillColor
		);
	}
}
