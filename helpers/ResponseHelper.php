<?php

namespace app\helpers;

use yii\web\NotFoundHttpException;

/**
 * 
 */
class ResponseHelper
{

    public static function isFileExists($filePath = '')
    {
        return (!empty($filePath) & is_file($filePath) && filesize($filePath));
    }

    /**
     * Download file
     *
     * Generates headers to download file
     *
     * @param string $filePath full file path
     * @param string $filename
     * @param string $mime_type header content type
     * @return file file data or NotFoundHttpException
     */
    public static function downloadFile($filePath = '', $filename = '', $mime_type = false)
    {
        if (empty($filename)) {
            $path = explode('/', str_replace(DIRECTORY_SEPARATOR, '/', $filePath));
            $filename = end($path);
        }

        $mime = 'application/octet-stream'; //default mime type

        if ($mime_type !== false) {
            $mime = $mime_type;
        }

        header('Content-Description: File Transfer');
        header('Content-Type: ' . $mime);
        header("Content-Disposition: attachment;filename=\"" . $filename . "\"");
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));
        ob_clean();
        flush();
        readfile($filePath);
    }
}