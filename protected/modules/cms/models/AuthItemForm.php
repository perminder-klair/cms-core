<?php

/**
 * Form model for updating an authorization item.
 */
class AuthItemForm extends CFormModel
{
	/**
	 * @var string item name.
	 */
	public $name;
	/**
	 * @var string item description.
	 */
	public $description;
	/**
	 * @var string business rule associated with the item.
	 */
	public $bizrule;
	/**
	 * @var string additional data for the item.
	 */
	public $data;
	/**
	 * @var string the item type (0=operation, 1=task, 2=role).
	 */
	public $type;

	/**
	 * Returns the attribute labels.
	 * @return array attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'name' => Yii::t('AuthModule.main', 'System name'),
			'description' => Yii::t('AuthModule.main', 'Description'),
			'bizrule' => Yii::t('AuthModule.main', 'Business rule'),
			'data' => Yii::t('AuthModule.main', 'Data'),
			'type' => Yii::t('AuthModule.main', 'Type'),
		);
	}

	/**
	 * Returns the validation rules for attributes.
	 * @return array validation rules.
	 */
	public function rules()
	{
		return array(
			array('description', 'required'),
			array('name', 'required', 'on' => 'create'),
			array('name', 'length', 'max' => 64),
		);
	}
	
    /**
	 * Returns the authorization item type as a string.
	 * @param string $type the item type (0=operation, 1=task, 2=role).
	 * @param boolean $plural whether to return the name in plural.
	 * @return string the text.
	 * @throws CException if the item type is invalid.
	 */
	public static function getItemTypeText($type, $plural = false)
	{
		// todo: change the default value for $plural to false.
		$n = $plural ? 2 : 1;
		switch ($type)
		{
			case CAuthItem::TYPE_OPERATION:
				$name = Yii::t('AuthModule.main', 'operation|operations', $n);
				break;

			case CAuthItem::TYPE_TASK:
				$name = Yii::t('AuthModule.main', 'task|tasks', $n);
				break;

			case CAuthItem::TYPE_ROLE:
				$name = Yii::t('AuthModule.main', 'role|roles', $n);
				break;

			default:
				throw new CException('Auth item type "' . $type . '" is valid.');
		}
		return ucfirst($name);
	}
}
