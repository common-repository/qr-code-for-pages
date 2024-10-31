<?php

namespace Me_Qr\Services\QrCode\Loading\Request;

interface QrRequestOptions
{
	// Fields for Me-Qr request
	public const QR_LINK_REQUEST_KEY = 'link';
	public const QR_ID_REQUEST_KEY = 'qrId';
	public const QR_FORMAT_REQUEST_KEY = 'format';


	// General fields for qr of Me-Qr response
	public const QR_CODE_ID_RESPONSE_KEY = 'qr_code_id';

	// Fields for one qr format of Me-Qr response
    public const QR_CODE_RESPONSE_KEY = 'qr_code';

	// Fields for all qr format of Me-Qr response
    public const QR_CODES_RESPONSE_KEY = 'qr_codes';
    public const PNG_QR_RESPONSE_KEY = 'qr_png';
    public const SVG_QR_RESPONSE_KEY = 'qr_svg';
}