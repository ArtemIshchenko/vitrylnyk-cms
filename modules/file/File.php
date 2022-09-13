<?php
namespace app\modules\file;

class File extends \app\components\Module
{
    public static $installConfig = [
        'title' => [
            'en' => 'Files',
            'ru' => 'Файлы',
						'uk' => 'Файли',
        ],
        'icon' => 'floppy-disk',
        'pos' => 4,
    ];
}