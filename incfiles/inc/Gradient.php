<?php

/* Градиент текста */

class Gradient {

    const mask16 = "0123456789ABCDEF";

    public static function extract16color($color16) {

        $true_color = [0, 0, 0];
        $color16 = mb_substr($color16, 1);

        for ($i = 0; $i < 3; $i++) {

            $color16_temp = [mb_substr($color16, $i * 2, 1), mb_substr($color16, $i * 2 + 1, 1)];

            for ($j = 0; $j < 2; $j++) {

                for ($k = 0; $k < 15; $k++) {

                    if ($color16_temp[$j] == self::mask16[$k]) {

                        $color16_temp[$j] = $k;

                        break;

                    }

                }

            }

            $true_color[$i] = intval($color16_temp[0]) * 16 + intval($color16_temp[1]);

        }

        return $true_color;

    }

    public static function make16color($color10) {

        $true_color = "#";

        for ($i = 0; $i < 3; $i++) {

            $color10_temp = $color10[$i];
            $true_color.= self::mask16[intval($color10_temp / 16)];
            $true_color.= self::mask16[intval($color10_temp % 16)];

        }

        return $true_color;

    }

    public static function make($text, $sColor, $eColor) {

        $text = trim($text);
        $sColor = preg_match("#^\#[a-f0-9]{6}$#i", $sColor) ? strtoupper($sColor) : "#000000";
        $eColor = preg_match("#^\#[a-f0-9]{6}$#i", $eColor) ? strtoupper($eColor) : "#000000";

        $color_move = [0, 0, 0];
        $color_add = [0, 0, 0];
        $length = mb_strlen($text);
        $output = NULL;
        $copy_color = NULL;
        $current_color = NULL;
        $max = 0;

        if ($length > 0) {

            $sColor = self::extract16color($sColor);
            $eColor = self::extract16color($eColor);
            $cColor = $sColor;

            for ($i = 0; $i < 3; $i++) {

                $temp = $sColor[$i] - intval($eColor[$i]);
                $temp_a = abs($temp); 
                $color_add[$i] = $temp_a;

                if ($temp_a > $max) {

                    $max = $temp_a;

                }

                if ($temp < 0) {

                    $color_move[$i] = 1;

                } elseif ($temp > 0) {

                    $color_move[$i] = -1;

                } else {

                    $color_move[$i] = 0;

                }

            }

            for ($i = 0; $i < $length; $i++) {

                $char = mb_substr($text, $i, 1);

                if ($max != 0 && $length != 0) {

                    $koeff_add = $max / $length / $max * 100;

                } else {

                    $koeff_add = 0;

                }

                for ($j = 0; $j < 3; $j++) {

                    $add = intval($color_add[$j]) / 100 * intval($koeff_add) * intval($color_move[$j]);
                    $cColor[$j] += $add;

                }

                $current_color = self::make16color($cColor);

                if ($i == 0) {

                    $output.= '<font color="'.$current_color.'">'.$char;
                    $copy_color = $current_color;

                } else {

                    if ($current_color == $copy_color || $char == " ") {

                        $output.= $char;

                    } else {

                        $output.= '</font><font color="'.$current_color.'">'.$char;
                        $copy_color = $current_color;

                    }

                }

            }

            if (mb_strlen($output)) {

                $output.= '</font>';

            }

            return $output;

        } else
            return false;

    }

    /* Генератор случайного цвета в HEX */

    public static function random_color() {

        $color = "#";

        for ($i = 0; $i < 6; $i++) {

            $color.= self::mask16[random_int(0, 15)];

        }

        return $color;

    }

}