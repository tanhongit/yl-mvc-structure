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
     * @return string
     * @throws Exception
     */
    public function upload($field, array $config = []): string
    {
        $options = [
            'name' => '',
            'upload_path' => './',
            'allowed_exts' => '*',
            'overwrite' => true,
            'max_size' => 0
        ];
        $options = array_merge($options, $config);

        if (!isset($_FILES[$field])) {
            throw new Exception('Field name is not exist');
        }

        $file = $_FILES[$field];
        if ($file['error'] != 0) {
            throw new Exception('Upload error');
        }

        $temp = explode(".", $file["name"]);
        $ext = end($temp);
        if ($options['allowed_exts'] != '*') {
            $allowedExts = explode('|', $options['allowed_exts']);
            if (!in_array($ext, $allowedExts)) {
                throw new Exception('File type is not allowed');
            }
        }
        $size = $file['size'] / 1024 / 1024;
        if (($options['max_size'] > 0) && ($size > $options['max_size'])) {
            throw new Exception('File size is too large');
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
     * @param $field
     * @param array $config
     *
     * @return string
     * @throws Exception
     */
    public function uploadV2($field, array $config = []): string
    {
        $options = [
            'name' => '',
            'upload_path' => './',
            'allowed_mimes' => ['image/jpeg', 'image/png', 'application/pdf'], // specify allowed MIME types
            'overwrite' => true,
            'max_size' => 0
        ];
        $options = array_merge($options, $config);

        if (!isset($_FILES[$field])) {
            throw new Exception('Field name is not exist');
        }

        $file = $_FILES[$field];

        if ($file['error'] != 0) {
            throw new Exception('Upload error');
        }

        // Validate MIME type using Fileinfo functions
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($file["tmp_name"]);

        if (!in_array($mime, $options['allowed_mimes'])) {
            throw new Exception('File type is not allowed');
        }

        $size = $file['size'] / 1024 / 1024;
        if ($options['max_size'] > 0 && $size > $options['max_size']) {
            throw new Exception('File size is too large');
        }

        $name = time() . '_' . (('' == $options['name']) ? $file["name"] : $options['name']);
        $file_path = $options['upload_path'] . $name;

        if ($options['overwrite'] && file_exists($file_path)) {
            unlink($file_path);
        }

        if (move_uploaded_file($file["tmp_name"], $file_path)) {
            return $file_path;
        }

        throw new Exception('Upload error');
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
        $str = self::convert_name($str);
        $str = strtolower($str); //mb_strtolower($str, 'UTF-8');
        return str_replace(' ', '-', $str);
    }

    /**
     * Change string to slug format
     *
     * @param $str
     *
     * @return array|string|string[]|null
     */
    public static function convert_name($str): array|string|null
    {
        $str = preg_replace("/[àáạảãâầấậẩẫăằắặẳẵ]/iu", 'a', $str);
        $str = preg_replace("/[èéẹẻẽêềếệểễ]/iu", 'e', $str);
        $str = preg_replace("/[ìíịỉĩ]/iu", 'i', $str);
        $str = preg_replace("/[òóọỏõôồốộổỗơờớợởỡ]/iu", 'o', $str);
        $str = preg_replace("/[ùúụủũưừứựửữ]/iu", 'u', $str);
        $str = preg_replace("/[ỳýỵỷỹ]/iu", 'y', $str);
        $str = preg_replace("/[đ]/iu", 'd', $str);
        $str = preg_replace("/[ÀÁẠẢÃÂẦẤẬẨẪĂẰẮẶẲẴ]/iu", 'A', $str);
        $str = preg_replace("/[ÈÉẸẺẼÊỀẾỆỂỄ]/iu", 'E', $str);
        $str = preg_replace("/[ÌÍỊỈĨ]/iu", 'I', $str);
        $str = preg_replace("/[ÒÓỌỎÕÔỒỐỘỔỖƠỜỚỢỞỠ]/iu", 'O', $str);
        $str = preg_replace("/[ÙÚỤỦŨƯỪỨỰỬỮ]/iu", 'U', $str);
        $str = preg_replace("/[ỲÝỴỶỸ]/iu", 'Y', $str);
        $str = preg_replace("/[Đ]/iu", 'D', $str);
        $str = preg_replace("/[\“\”\‘\’\,\!\&\;\@\#\%\~\`\=\_\'\]\[\}\{\)\(\+\^]/", '-', $str);
        return preg_replace("/( )/", '-', $str);
    }
}
