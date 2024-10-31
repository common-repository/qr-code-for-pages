<?php

namespace Me_Qr\Entity;

use JsonSerializable;

class QrCodesEntity implements JsonSerializable, EntityInterface
{
	/**
	 * @var QrCodeEntity[]
	 */
    private array $qrCodes = [];

	/**
	 * @return QrCodeEntity[]
	 */
	public function getAllQrs(): array
	{
		return $this->qrCodes;
	}

	/**
	 * @param QrCodeEntity[] $qrCodes
	 */
	public function setAllQrs(array $qrCodes): self
	{
		$this->qrCodes = $qrCodes;

		return $this;
	}

	public function addQr(QrCodeEntity $qrCodeEntity): self
	{
		$this->qrCodes[] = $qrCodeEntity;

		return $this;
	}

	public function deleteQr(QrCodeEntity $qrCodeEntity): self
	{
		foreach ($this->getAllQrs() as $key => $qrCode) {
			if ($qrCodeEntity->getPostId()) {
				unset($this->qrCodes[$key]);
			}
		}

		return $this;
	}

	public function count(): int
	{
		return count($this->qrCodes);
	}

    public function jsonSerialize(): array
    {
		$result = [];
		foreach ($this->getAllQrs() as $qrCode) {
			$result[] = $qrCode->jsonSerialize();
		}

        return $result;
    }
}