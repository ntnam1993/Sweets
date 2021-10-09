<?php

namespace App\Helpers;

class Util
{
    /**
     * ハッシュ化ロジック
     *
     * @param string | array ハッシュ化対象
     * @param string アルゴリズムの名前
     *
     * @return string ハッシュ化した文字列
     */
    public function stringToHash($target = '', $algo = 'md5')
    {
        if (empty($target)) {
            return '';
        }

        if (is_array($target)) {
            $strTemp = '';

            foreach ($target as $val) {
                if (is_string($val)) {
                    $strTemp .= $val;
                }
                $target = $strTemp;
            }
        }

        return hash($algo, $target);
    }
}
