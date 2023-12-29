<?php

class Model extends Database
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Upload overwrite image
     *
     * @param $field
     * @param array $config
     *
     * @return false|string
     */
    public function upload($field, array $config = array()): false|string
    {
        $options = array(
            'name' => '',
            'upload_path' => './',
            'allowed_exts' => '*',
            'overwrite' => true,
            'max_size' => 0
        );
        $options = array_merge($options, $config);
        if (!isset($_FILES[$field])) {
            return false;
        }
        $file = $_FILES[$field];
        if ($file['error'] != 0) {
            return false;
        }
        $temp = explode(".", $file["name"]);
        $ext = end($temp);
        if ($options['allowed_exts'] != '*') {
            $allowedExts = explode('|', $options['allowed_exts']);
            if (!in_array($ext, $allowedExts)) {
                return false;
            }
        }
        $size = $file['size'] / 1024 / 1024;
        if (($options['max_size'] > 0) && ($size > $options['max_size'])) {
            return false;
        }

        $name = time() . '_' . (('' == $options['name']) ? $options['name']
                . '.' . $ext : $file["name"]);
        $file_path = $options['upload_path'] . $name;
        if ($options['overwrite'] && file_exists($file_path)) {
            unlink($file_path);
        }

        move_uploaded_file($file["tmp_name"], $file_path);
        return $file_path;
    }

    /**
     * Convert slug
     *
     * @param $str
     *
     * @return array|string|string[]
     */
    public static function slug($str): array|string
    {
        $str = (new Model)->convert_name($str);
        $str = strtolower($str);
        return str_replace(' ', '-', $str);
    }

    /**
     * Change string to slug format
     *
     * @param $str
     *
     * @return array|string|string[]|null
     */
    public function convert_name($str): array|string|null
    {
        $str = preg_replace("/([àáạảãâầấậẩẫăằắặẳẵ])/", 'a', $str);
        $str = preg_replace("/([èéẹẻẽêềếệểễ])/", 'e', $str);
        $str = preg_replace("/([ìíịỉĩ])/", 'i', $str);
        $str = preg_replace("/([òóọỏõôồốộổỗơờớợởỡ])/", 'o', $str);
        $str = preg_replace("/([ùúụủũưừứựửữ])/", 'u', $str);
        $str = preg_replace("/([ỳýỵỷỹ])/", 'y', $str);
        $str = preg_replace("/(đ)/", 'd', $str);
        $str = preg_replace("/([ÀÁẠẢÃÂẦẤẬẨẪĂẰẮẶẲẴ])/", 'A', $str);
        $str = preg_replace("/([ÈÉẸẺẼÊỀẾỆỂỄ])/", 'E', $str);
        $str = preg_replace("/([ÌÍỊỈĨ])/", 'I', $str);
        $str = preg_replace("/([ÒÓỌỎÕÔỒỐỘỔỖƠỜỚỢỞỠ])/", 'O', $str);
        $str = preg_replace("/([ÙÚỤỦŨƯỪỨỰỬỮ])/", 'U', $str);
        $str = preg_replace("/([ỲÝỴỶỸ])/", 'Y', $str);
        $str = preg_replace("/(Đ)/", 'D', $str);
        $str = preg_replace("/(\“|\”|\‘|\’|\,|\!|\&|\;|\@|\#|\%|\~|\`|\=|\_|\'|\]|\[|\}|\{|\)|\(|\+|\^)/", '-', $str);
        return preg_replace("/( )/", '-', $str);
    }
}
