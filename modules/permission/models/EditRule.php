<?php

namespace app\modules\permission\models;

use yii\base\Model;
use Yii;

/**
 * This is the model class for table "auth_rule".
 *
 * @property string $name
 * @property resource $data
 * @property int $created_at
 * @property int $updated_at
 *
 * @property AuthItem[] $authItems
 */
class EditRule extends Model
{
    public $class;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['class'], 'required'],
            [['class'], 'string', 'max' => 255],
            [['class'], 'validateClass'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'class' => 'Class',
        ];
    }

    public function validateClass($attribute, $params)
    {
        if ($this->hasErrors($attribute)) {
            return false;
        }

        if (!$this->_classExists($this->$attribute)) {
            $this->addError($attribute, "Class '{$this->{$attribute}}' does not exist or has syntax error.");
            return false;
        }

        $method = 'execute';
        $reflectionClass = new \ReflectionClass($this->$attribute);

        if (!$reflectionClass->hasMethod($method)) {
            $this->addError($attribute, 'invalid_method: ' . $method);
            return false;
        }

        $reflectionMethod = $reflectionClass->getMethod($method);

        if ($reflectionMethod->isAbstract() || !$reflectionMethod->isPublic()) {
            $this->addError($attribute, 'Invalid method configuration.');
            return false;
        }

        if ($reflectionMethod->isStatic()) {
            $this->addError($attribute, 'Method is static.');
            return false;
        }

        return true;
    }

    protected function _classExists($className)
    {
        return class_exists($className) && in_array($className, get_declared_classes());
    }
}
