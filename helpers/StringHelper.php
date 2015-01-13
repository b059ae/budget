<?php

namespace app\helpers;

use Yii;

class StringHelper
{

    /**
     * Перевод строки в нижний регистр, используя функцию mb_
     * @param string $string
     * @param string $charset
     * @return string
     */
    public static function strtolower($string, $charset=null)
    {
        if ($charset === NULL)
            $charset = Yii::$app->charset;
        return mb_strtolower($string, $charset);
    }

    /**
     * Вырезает часть строки, используя функцию mb_
     * @param string $string
     * @param int $start
     * @param int $length
     * @param string $charset
     * @return string
     */
    public static function strcut($string, $start, $length=null, $charset=null)
    {
        if ($charset === NULL)
            $charset = Yii::$app->charset;
        return mb_strcut($string, $start, $length, $charset);
    }

    /**
     * Имя папки для представлений по объекту модели
     * @param object $modelName
     * @return string
     */
    public static function getViewFolder($modelName) {
        $reflect = new \ReflectionClass($modelName);
        return self::strtolower($reflect->getShortName());
    }

    /**
     * Короткое имя класса
     * @param object $modelName
     * @return string
     */
    public static function getShortName($modelName) {
        $reflect = new \ReflectionClass($modelName);
        return $reflect->getShortName();
    }
}
