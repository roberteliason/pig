<?php

namespace PIG_Space\SVG;


class SVG_CircularGradient
{
	protected $template;
	protected $name;
	protected $colors;

	public function __construct($args = [])
	{
		$this->setTemplate();
		$this->colors = [
			'rgba(120,255,120,0.5)',
			'rgba(255,120,120,0.5)',
			'rgba(120,120,255,0.5)',
		];
		$this->name   = 'Gradient';
		$this->setArgs($args);
	}


	/**
	 * @param array $args
	 */
	public function setArgs($args = [])
	{
		if ( ! empty($args)) {
			if (isset($args['colors'])) {
				$this->colors = $args['colors'];
			}
		}
	}


	/**
	 * Set a markup template for sprintf
	 */
	private function setTemplate()
	{
		$this->template .= "\t\t" . '<radialGradient id="%s" cx="0.5" cy="0.5" r="0.5" fx="0.25" fy="0.25">' . PHP_EOL;
		$this->template .= "\t\t\t" . '<stop offset="0%%" stop-color="white"/>' . PHP_EOL;
		$this->template .= "\t\t\t" . '<stop offset="100%%" stop-color="%s"/>' . PHP_EOL;
		$this->template .= "\t\t" . '</radialGradient>' . PHP_EOL;
	}


	/**
	 * @return array
	 */
	public function getGradientNames()
	{
		$names = [];
		foreach ($this->colors as $index => $color) {
			$names[] = $this->name . $index;
		}

		return $names;
	}


	/**
	 * @return string
	 */
	public function getGradients()
	{
		$output = "\t" . '<defs>' . PHP_EOL;
		foreach ($this->colors as $index => $color) {
			$output .= sprintf($this->template, $this->name . $index, $color);
		}
		$output .= "\t" . '</defs>';

		return $output;
	}
}