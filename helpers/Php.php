<?php

namespace app\helpers;

use Exception;
use ReflectionClass;
use Yii;
use yii\helpers\FileHelper;

/**
 * helper of Php
 *
 * @author Lamnx <nguyenxuanlam1987@gmail.com>
 */
class Php
{

    /**
     * Validate class
     * @param string $class namespace
     * @param array $params
     * @param string $error
     */
    public static function validateClass($class, $params, &$error = null)
    {
        try {
            if (class_exists($class)) {
                if (isset($params['extends'])) {
                    if (ltrim($class, '\\') !== ltrim($params['extends'], '\\') && !is_subclass_of($class, $params['extends'])) {
                        $error = "'$class' must extend from {$params['extends']} or its child class.";
                        return false;
                    }
                }

                return true;
            } else {
                $error = "Class '$class' does not exist or has syntax error.";
                return false;
            }
        } catch (Exception $e) {
            $error = "Class '$class' does not exist or has syntax error.";
            return false;
        }
    }

    public static function validateCallback($class, $method = null, &$error = null)
    {
        try {
            if (is_array($class)) {
                if ($method) {
                    $error = 'Method cannot be provided with class as array';
                    return false;
                }

                $class = $class[0];
                $method = $class[1];
            }

            if (!$method) {
                if (is_object($class)) {
                    $error = 'Object given with no method';
                    return false;
                }
            }

            $method = strval($method);

            if (!is_string($method)) {
                $error = 'Method to check is not a string';
                return false;
            }

            if (class_exists($class)) {
                if (isset($params['extends'])) {
                    if (ltrim($class, '\\') !== ltrim($params['extends'], '\\') && !is_subclass_of($class, $params['extends'])) {
                        $error = "'$class' must extend from {$params['extends']} or its child class.";
                        return false;
                    }
                }

                if ($error === null) {
                    $isObject = is_object($class);

                    if ($isObject) {
                        
                    }

                    $reflectionClass = new ReflectionClass($class);


                    if (!$method || !$reflectionClass->hasMethod($method)) {
                        $error = "method $method is invalid";
                        return false;
                    }

                    $reflectionMethod = $reflectionClass->getMethod($method);

                    if ($reflectionMethod->isAbstract() || !$reflectionMethod->isPublic()) {
                        $error = 'Invalid method configuration.';
                        return false;
                    }

                    $isStatic = $reflectionMethod->isStatic();

                    if ($isStatic && $isObject) {
                        $error = 'method_static';
                        return false;
                    } else if (!$isStatic && !$isObject) {
                        $error = 'method_not_static';
                        return false;
                    }

                    return true;
                }
            } else {
                $error = "Class '$class' does not exist or has syntax error.";
                return false;
            }
        } catch (Exception $e) {
            $error = "Class '$class' does not exist or has syntax error.";
            return false;
        }
    }

    /**
     * Generate class name of export file
     *
     * @param $name
     *
     * @return string
     */
    public static function generateClassName($name)
    {
        $name = trim($name, '\\');
        if (strpos($name, '\\') !== false) {
            $name = substr($name, strrpos($name, '\\') + 1);
        }
        $class = 'm' . gmdate('ymd_His') . '_' . $name;

        return $class;
    }

    /**
     * Generate code into file template
     *
     * @param string $templateFileAlias
     * @param array $params
     *
     * @return string
     */
    public static function generateSourceCode($templateFileAlias ,$params)
    {
        return Yii::$app->view->renderFile(Yii::getAlias($templateFileAlias), $params);
    }


    /**
     * Create file migrate form data export
     *
     * @param string $name
     * @param string $tableName
     * @param string $columns
     * @param string $values
     * @param bool $downloadFile
     * @param bool $removeFile
     * @param string $exts
     *
     * @return bool
     * @throws Exception
     */
    public static function createFileMigrate ($name, $tableName, $columns, $values, $migrationPath, $templateFileAlias,$downloadFile = true, $removeFile = true, $exts = 'php') {
        if (!preg_match('/^[\w\\\\]+$/', $name)) {
            throw new Exception('The migration name should contain letters, digits, underscore and/or backslash characters only.');
        }

        $className = self::generateClassName($name);
        $path = Yii::getAlias($migrationPath);

        if (!is_dir($path)) {
            FileHelper::createDirectory($path);
        }
        $migrationPath = $path;
        $file = $migrationPath . DIRECTORY_SEPARATOR . $className . '.' . $exts;
        $content = self::generateSourceCode($templateFileAlias, [
            'table' => $tableName,
            'columns' => $columns,
            'className' => $className,
            'rows' => $values
        ]);

        FileHelper::createDirectory($migrationPath);

        if (file_put_contents($file, $content)) {
            if ($downloadFile) {
                return ExportHelper::downloadFile($file, $removeFile);
            }
            exit;
        }

        return false;
    }
}
