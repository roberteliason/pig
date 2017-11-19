<?php

namespace PIG_Space;


class InfiniteSeed Extends \SplDoublyLinkedList
{
	/**
	 * InfiniteSeed constructor.
	 *
	 * @param string $seed
	 */
	public function __construct($seed)
	{
		if ( ! empty($seed)) {
			$chars = str_split($seed);
			foreach ($chars as $char) {
				$this->push($char);
			}
		}
		$this->rewind();
	}


	/**
	 * @return mixed
	 */
	public function getNext() {
		// Turing machine!
		$value = $this->current();
		$this->currentSet( $this->bitShiftChar( $value ) );

		$this->next();
		$value = $this->current();

		/**
		 * If we hit the end, start over
		 * MoebiusPoop!
		 */
		if ( NULL === $value ) {
			$this->rewind();
			$value = $this->current();
		}
		return $value;
	}


	/**
	 * Update the current node
	 *
	 * @param $value
	 */
	public function currentSet( $value ) {
		$this->offsetSet( $this->key(), $value );
	}


	/**
	 * Shift the passed char to the next higher
	 *
	 * @param $char
	 *
	 * @return string
	 */
	protected function bitShiftChar($char) {
		$ascii = ord($char);
		$shiftedChar = chr($ascii + 1);

		return $shiftedChar;
	}
}