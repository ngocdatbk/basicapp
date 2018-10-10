<?php

namespace app\helpers;

use PHPExcel;
use PHPExcel_Worksheet;
use PHPExcel_Writer_Excel2007;

/**
 * ExportHelper export file excel xlsx
 *
 * @author Lamnx <nguyenxuanlam1987@gmail.com>
 */
class ExportHelper
{

    /**
     * Clean buffer before export
     */
    public static function clearOutputBuffers()
    {
        ob_end_clean();
    }

    /**
     * Returns an excel column name.
     *
     * @param int $index the column index number
     *
     * @return string
     */
    public static function columnName($index)
    {
        $i = intval($index) - 1;
        if ($i >= 0 && $i < 26) {
            return chr(ord('A') + $i);
        }
        if ($i > 25) {
            return (self::columnName($i / 26)) . (self::columnName($i % 26 + 1));
        }
        return 'A';
    }

    /**
     * Set header row
     * @param PHPExcel_Worksheet $objPHPExcelSheet
     * @param array $headers
     * @param type $beginRow
     */
    public static function setHeader(PHPExcel_Worksheet $objPHPExcelSheet, array $headers, $beginRow = 1)
    {
        foreach ($headers as $index => $header) {
            $objPHPExcelSheet->setCellValue(self::columnName($index + 1) . $beginRow, $header);
        }
    }

    /**
     * Render rows data
     * @param PHPExcel_Worksheet $objPHPExcelSheet
     * @param array $rows
     * @param type $beginRow
     */
    public static function renderRow(PHPExcel_Worksheet $objPHPExcelSheet, array $rows, $beginRow = 1)
    {
        foreach ($rows as $index => $row) {
            $key = 1;
            foreach ($row as $value) {
                $objPHPExcelSheet->setCellValue(self::columnName($key) . ($beginRow + $index + 1), $value);
                $key++;
            }
        }
    }

    /**
     * Export file
     * @param PHPExcel $objPHPExcel
     * @param type $fileName
     * @param type $extension
     * @param type $encoding
     */
    public static function export(PHPExcel $objPHPExcel, $fileName, $extension = 'xlsx', $encoding = 'utf-8')
    {
        if (strstr($_SERVER["HTTP_USER_AGENT"], "MSIE") == false) {
            header("Cache-Control: no-cache");
            header("Pragma: no-cache");
        } else {
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Pragma: public");
        }

        header("Expires: Sat, 26 Jul 1979 05:00:00 GMT");
        header("Content-Encoding: {$encoding}");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); //mime xlsx
        header("Content-Disposition: attachment; filename=\"{$fileName}.{$extension}\"");
        header("Cache-Control: max-age=0");
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);

        $objWriter->save('php://output');

        self::destroyPHPExcel($objPHPExcel, $objWriter);
    }

    /**
     * Distroy PHPExcel after export
     * @param PHPExcel $objPHPExcel
     * @param PHPExcel_Writer_Excel2007 $objWriter
     */
    public static function destroyPHPExcel(PHPExcel $objPHPExcel, PHPExcel_Writer_Excel2007 $objWriter)
    {
        if ($objPHPExcel) {
            $objPHPExcel->disconnectWorksheets();
        }

        unset($objPHPExcel, $objWriter);
    }

    /**
     * Allow download file
     *
     * @param $filePatch
     * @param bool $remove
     *
     * @return bool
     */
    public static function downloadFile($filePath, $remove = true){

        try {
            //Allow download file
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename='.basename($filePath));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filePath));
            readfile($filePath);
            if ($remove) unlink($filePath);
            exit;
        }catch (\yii\db\Exception $exception) {
            return false;
        }
    }
}
