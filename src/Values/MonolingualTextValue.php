<?php

namespace DataValues;

/**
 * Class representing a monolingual text value.
 *
 * @since 0.1
 *
 * @license GPL-2.0+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class MonolingualTextValue extends DataValueObject {

	/**
	 * @var string
	 */
	private $languageCode;

	/**
	 * @var string
	 */
	private $text;

	/**
	 * @since 0.1
	 *
	 * @param string $languageCode
	 * @param string $text
	 *
	 * @throws IllegalValueException
	 */
	public function __construct( $languageCode, $text ) {
		if ( !is_string( $languageCode ) || $languageCode === '' ) {
			throw new IllegalValueException( '$languageCode must be a non-empty string' );
		}
		if ( !is_string( $text ) ) {
			throw new IllegalValueException( '$text must be a string' );
		}

		$this->languageCode = $languageCode;
		$this->text = $text;
	}

	/**
	 * @see Serializable::serialize
	 *
	 * @return string
	 */
	public function serialize() {
		return serialize( [ $this->languageCode, $this->text ] );
	}

	/**
	 * @see Serializable::unserialize
	 *
	 * @param string $value
	 */
	public function unserialize( $value ) {
		list( $languageCode, $text ) = unserialize( $value );
		$this->__construct( $languageCode, $text );
	}

	/**
	 * @see DataValue::getType
	 *
	 * @return string
	 */
	public static function getType() {
		return 'monolingualtext';
	}

	/**
	 * @see DataValue::getSortKey
	 *
	 * @return string
	 */
	public function getSortKey() {
		// TODO: we might want to re-think this key. Perhaps the language should simply be omitted.
		return $this->languageCode . $this->text;
	}

	/**
	 * @see DataValue::getValue
	 *
	 * @return self
	 */
	public function getValue() {
		return $this;
	}

	/**
	 * Returns the text.
	 *
	 * @since 0.1
	 *
	 * @return string
	 */
	public function getText() {
		return $this->text;
	}

	/**
	 * Returns the language code.
	 *
	 * @since 0.1
	 *
	 * @return string
	 */
	public function getLanguageCode() {
		return $this->languageCode;
	}

	/**
	 * @see DataValue::getArrayValue
	 *
	 * @return string[]
	 */
	public function getArrayValue() {
		return [
			'text' => $this->text,
			'language' => $this->languageCode,
		];
	}

	/**
	 * Constructs a new instance of the DataValue from the provided data.
	 * This can round-trip with @see getArrayValue
	 *
	 * @since 0.1
	 *
	 * @param string[] $data
	 *
	 * @return static
	 * @throws IllegalValueException
	 */
	public static function newFromArray( array $data ) {
		self::requireArrayFields( $data, [ 'language', 'text' ] );

		return new static( $data['language'], $data['text'] );
	}

}
