<?php

namespace Me_Qr\Services\File;

class QrFileManager
{
    private const FILE_PREFIX = 'me-qr-code-';

    public function createQrTitleByPostId(int $postId, string $format): string
    {
        return self::FILE_PREFIX . $postId . '.' . $format;
    }

    public function createQrFullPathByPostId(int $postId, string $format): string
    {
        $wpUploadDir = wp_upload_dir()['basedir'];
        $mqUploadDir = ME_QR_CODE_DOWNLOAD_DIR_TITLE;
        $fileName = $this->createQrTitleByPostId($postId, $format);

        return $wpUploadDir . $mqUploadDir . '/' . $fileName;
    }

    public function isQrExists(int $postId, string $format): bool
    {
        return file_exists($this->createQrFullPathByPostId($postId, $format));
    }

    public function isQrsExists(int $postId): bool
    {
        foreach (ME_QR_VALID_QR_FORMATS as $format) {
            $isExist = file_exists($this->createQrFullPathByPostId($postId, $format));

            if (!$isExist) {
                return false;
            }
        }

        return true;
    }

    public function getQrLinkByPostId(int $postId, string $format): string
    {
        $uploadUrl = wp_upload_dir()['baseurl'];
        $mqUploadDir = ME_QR_CODE_DOWNLOAD_DIR_TITLE;
        $qrFileTitle = $this->createQrTitleByPostId($postId, $format);

        return $uploadUrl . $mqUploadDir . '/' . $qrFileTitle;
    }

    public function saveQrByPostId(string $qr, int $postId, string $format): void
    {
		if ($this->isQrExists($postId, $format)) {
			$this->deleteQrByPostId($postId, $format);
		}

        UploadDirectoryService::createQrDirectory();
        $qrFullPath = $this->createQrFullPathByPostId($postId, $format);
        file_put_contents($qrFullPath, base64_decode($qr));
    }

    public function deleteQrByPostId(int $postId, string $format): void
    {
        if ($this->isQrExists($postId, $format)) {
            unlink($this->createQrFullPathByPostId($postId, $format));
        }
    }
}
