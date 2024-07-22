<?php

namespace App\Utils;

class CreateUserPicture
{
    public static function create($username)
    {
        $width = 1000;
        $height = 1000;
        $colors = array(
            "azul" => array(50, 100, 200),
            "roxo" => array(150, 50, 200),
            "rosa" => array(255, 150, 180),
            "marrom claro" => array(205, 133, 63),
            "laranja" => array(255, 165, 0),
            "vermelho" => array(255, 0, 0),
            "verde" => array(0, 128, 0),
            "preto" => array(150, 150, 150),
            "magenta" => array(204, 0, 255),
            "ciano" => array(0, 238, 255)
        );
        $random_color = $colors[array_rand($colors)];
        $image = imagecreatetruecolor($width, $height);
        $background_color = imagecolorallocate($image, $random_color[0], $random_color[1], $random_color[2]);
        imagefill($image, 0, 0, $background_color);
        $text_color = imagecolorallocate($image, 255, 255, 255);
        $font_path = public_path('fonts/Roboto-Regular.ttf');
        $font_size = 400;
        $text_box = imagettfbbox($font_size, 0, $font_path, strtoupper(substr($username, 0, 1)));
        $text_width = $text_box[2] - $text_box[0];
        $text_height = $text_box[3] - $text_box[5];
        $text_x = round(($width - $text_width) / 2) - $text_box[0];
        $text_y = round(($height + $text_height) / 2);
        imagettftext($image, $font_size, 0, $text_x, $text_y, $text_color, $font_path, strtoupper(substr($username, 0, 1)));
        ob_start();
        imagepng($image);
        $image_data = ob_get_contents();
        ob_end_clean();
        $base64_image = base64_encode($image_data);
        imagedestroy($image);

        return $base64_image;

        // Obs: eu sei que a letra não está centralizada, vou resouver isso depois
    }
}