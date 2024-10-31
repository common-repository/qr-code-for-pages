<?php

namespace Me_Qr\Entity;

use JsonSerializable;

class QrCodeEntity implements JsonSerializable, EntityInterface
{
    public const POST_ID_KEY = 'postId';
    public const QR_CODE_KEY = 'qrCodeId';

    private int $postId;

    private int $qrCodeId;

	public function getPostId(): int
	{
		return $this->postId;
	}

	public function setPostId(int $postId): void
	{
		$this->postId = $postId;
	}

	public function getQrCodeId(): int
	{
		return $this->qrCodeId;
	}

	public function setQrCodeId(int $qrCodeId): void
	{
		$this->qrCodeId = $qrCodeId;
	}

    public function jsonSerialize(): array
    {
        return [
            self::POST_ID_KEY => $this->postId,
            self::QR_CODE_KEY => $this->qrCodeId,
        ];
    }
}