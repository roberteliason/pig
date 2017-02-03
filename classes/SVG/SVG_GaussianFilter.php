<?php

namespace PIG_Space\SVG;


class SVG_GaussianFilter
{
	protected $name = '';
	protected $amount = 0;
	protected $template = '';


	/**
	 * SVG_GaussianFilter constructor.
	 *
	 * @param array $args
	 */
	public function __construct($args = [])
	{
		$this->name   = 'GaussianFilter';
		$this->amount = 3;

		$this->setArgs($args);
		$this->setTemplate();
	}


	/**
	 * @param array $args
	 */
	public function setArgs($args = [])
	{
		if ( ! empty($args)) {
			if (isset($args['name'])) {
				$this->name = $args['name'];
			}

			if (isset($args['amount'])) {
				$this->amount = $args['amount'];
			}
		}
	}


	/**
	 *
	 */
	private function setTemplate()
	{
		$this->template .= "\t" . '<filter id="%s">' . PHP_EOL;
		$this->template .= "\t\t" . '<feGaussianBlur in="SourceGraphic" stdDeviation="%s" />' . PHP_EOL;
		$this->template .= "\t" . '</filter>' . PHP_EOL;
	}


	/**
	 * @return string
	 */
	public function getName() {
		 return $this->name;
	}


	/**
	 * @return string
	 */
	public function getFilter()
	{
		return sprintf( $this->template, $this->name, $this->amount );
	}
}