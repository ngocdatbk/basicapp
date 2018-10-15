<?php
/**
 * Created by PhpStorm.
 * User: ngocd
 * Date: 10/15/18
 * Time: 13:58
 */
namespace app\modules\admin\models;

use yii\base\Model;
use yii\web\UploadedFile;

class ProductImageUpload extends Model
{
    /**
     * @var UploadedFile[]
     */
    public $imageFile;

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $this->imageFile->saveAs('uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            return 'uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension;
        } else {
            return false;
        }
    }
}