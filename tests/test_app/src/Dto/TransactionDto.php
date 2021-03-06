<?php
/**
 * !!! Auto generated file. Do not directly modify this file. !!!
 * You can either version control this or generate the file on the fly prior to usage/deployment.
 */

namespace TestApp\Dto;

/**
 * Transaction DTO
 *
 * @property \TestApp\Dto\CustomerAccountDto $customerAccount
 * @property float $value
 * @property string|null $comment
 * @property \Cake\I18n\FrozenDate $created
 */
class TransactionDto extends \CakeDto\Dto\AbstractImmutableDto {

	const FIELD_CUSTOMER_ACCOUNT = 'customerAccount';
	const FIELD_VALUE = 'value';
	const FIELD_COMMENT = 'comment';
	const FIELD_CREATED = 'created';

	/**
	 * @var \TestApp\Dto\CustomerAccountDto
	 */
	protected $customerAccount;

	/**
	 * @var float
	 */
	protected $value;

	/**
	 * @var string|null
	 */
	protected $comment;

	/**
	 * @var \Cake\I18n\FrozenDate
	 */
	protected $created;

	/**
	 * Some data is only for debugging for now.
	 *
	 * @var array
	 */
	protected $_metadata = [
		'customerAccount' => [
			'name' => 'customerAccount',
			'type' => '\TestApp\Dto\CustomerAccountDto',
			'required' => true,
			'defaultValue' => null,
			'dto' => 'CustomerAccount',
			'collectionType' => null,
			'associative' => false,
			'key' => null,
			'serializable' => false,
			'toArray' => false,
		],
		'value' => [
			'name' => 'value',
			'type' => 'float',
			'required' => true,
			'defaultValue' => null,
			'dto' => null,
			'collectionType' => null,
			'associative' => false,
			'key' => null,
			'serializable' => false,
			'toArray' => false,
		],
		'comment' => [
			'name' => 'comment',
			'type' => 'string',
			'required' => false,
			'defaultValue' => null,
			'dto' => null,
			'collectionType' => null,
			'associative' => false,
			'key' => null,
			'serializable' => false,
			'toArray' => false,
		],
		'created' => [
			'name' => 'created',
			'type' => '\Cake\I18n\FrozenDate',
			'required' => true,
			'defaultValue' => null,
			'dto' => null,
			'collectionType' => null,
			'associative' => false,
			'key' => null,
			'serializable' => false,
			'toArray' => false,
			'isClass' => true,
		],
	];

	/**
	* @var array
	*/
	protected $_keyMap = [
		'underscored' => [
			'customer_account' => 'customerAccount',
			'value' => 'value',
			'comment' => 'comment',
			'created' => 'created',
		],
		'dashed' => [
			'customer-account' => 'customerAccount',
			'value' => 'value',
			'comment' => 'comment',
			'created' => 'created',
		],
	];

	/**
	 * @param \TestApp\Dto\CustomerAccountDto $customerAccount
	 *
	 * @return static
	 */
	public function withCustomerAccount(\TestApp\Dto\CustomerAccountDto $customerAccount) {
		$new = clone $this;
		$new->customerAccount = $customerAccount;
		$new->_touchedFields[self::FIELD_CUSTOMER_ACCOUNT] = true;

		return $new;
	}

	/**
	 * @return \TestApp\Dto\CustomerAccountDto
	 */
	public function getCustomerAccount() {
		return $this->customerAccount;
	}

	/**
	 * @return bool
	 */
	public function hasCustomerAccount() {
		return $this->customerAccount !== null;
	}

	/**
	 * @param float $value
	 *
	 * @return static
	 */
	public function withValue($value) {
		$new = clone $this;
		$new->value = $value;
		$new->_touchedFields[self::FIELD_VALUE] = true;

		return $new;
	}

	/**
	 * @return float
	 */
	public function getValue() {
		return $this->value;
	}

	/**
	 * @return bool
	 */
	public function hasValue() {
		return $this->value !== null;
	}

	/**
	 * @param string|null $comment
	 *
	 * @return static
	 */
	public function withComment($comment) {
		$new = clone $this;
		$new->comment = $comment;
		$new->_touchedFields[self::FIELD_COMMENT] = true;

		return $new;
	}

	/**
	 * @return string|null
	 */
	public function getComment() {
		return $this->comment;
	}

	/**
	 * @throws \RuntimeException If value is not set.
	 *
	 * @return string
	 */
	public function getCommentOrFail() {
		if (!isset($this->comment)) {
			throw new \RuntimeException('Value not set for field `comment` (expected to be not null)');
		}

		return $this->comment;
	}

	/**
	 * @return bool
	 */
	public function hasComment() {
		return $this->comment !== null;
	}

	/**
	 * @param \Cake\I18n\FrozenDate $created
	 *
	 * @return static
	 */
	public function withCreated(\Cake\I18n\FrozenDate $created) {
		$new = clone $this;
		$new->created = $created;
		$new->_touchedFields[self::FIELD_CREATED] = true;

		return $new;
	}

	/**
	 * @return \Cake\I18n\FrozenDate
	 */
	public function getCreated() {
		return $this->created;
	}

	/**
	 * @return bool
	 */
	public function hasCreated() {
		return $this->created !== null;
	}

}
