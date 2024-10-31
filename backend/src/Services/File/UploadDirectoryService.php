<?php

namespace Me_Qr\Services\File;

class UploadDirectoryService
{
    public static function getUploadDirectory(): string
    {
        return wp_upload_dir()['basedir'];
    }

    public static function deleteMeQrContentDirectory(): void
    {
        $dir = self::getUploadDirectory() . ME_QR_CONTENT_DIR_TITLE;
        self::deleteFolder($dir);
    }

    public static function createQrDirectory(): void
    {
        $dir = self::getUploadDirectory() . ME_QR_CODE_DOWNLOAD_DIR_TITLE;
        wp_mkdir_p($dir);
    }

    public static function deleteQrDirectory(): void
    {
        $dir = self::getUploadDirectory() . ME_QR_CODE_DOWNLOAD_DIR_TITLE;
        self::deleteFolder($dir);
    }

    public static function deleteFolder(string $folderPath, bool $deleteSelf = true): void
    {
        $folderPath = untrailingslashit($folderPath);

        $glob = glob("$folderPath/{,.}[!.,!..]*", GLOB_BRACE);
        foreach($glob as $file){
            if (is_dir($file)) {
                call_user_func(__FUNCTION__, $file);
            } else {
                unlink($file);
            }
        }

        if ($deleteSelf) {
            rmdir($folderPath);
        }
    }
}
