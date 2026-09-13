<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Services\RestaurantPhotoService;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class RestaurantPhotoServiceTest extends TestCase
{
    public function testValidJpegIsAcceptedAndReturnsExtension(): void
    {
        self::assertSame('jpg', RestaurantPhotoService::assertPhotoUpload('image/jpeg', 'jpg', 1024));
    }

    public function testValidJpegExtensionAliasIsAccepted(): void
    {
        self::assertSame('jpg', RestaurantPhotoService::assertPhotoUpload('image/jpeg', 'jpeg', 1024));
    }

    public function testBoundarySizeIsAccepted(): void
    {
        self::assertSame('png', RestaurantPhotoService::assertPhotoUpload('image/png', 'png', 5 * 1024 * 1024));
    }

    public function testOversizedFileIsRejected(): void
    {
        $this->expectException(InvalidArgumentException::class);
        RestaurantPhotoService::assertPhotoUpload('image/jpeg', 'jpg', 5 * 1024 * 1024 + 1);
    }

    public function testDisallowedMimeTypeIsRejected(): void
    {
        $this->expectException(InvalidArgumentException::class);
        RestaurantPhotoService::assertPhotoUpload('application/x-php', 'jpg', 1024);
    }

    public function testMismatchedExtensionIsRejected(): void
    {
        $this->expectException(InvalidArgumentException::class);
        RestaurantPhotoService::assertPhotoUpload('image/jpeg', 'txt', 1024);
    }

    public function testDisallowedExtensionIsRejected(): void
    {
        $this->expectException(InvalidArgumentException::class);
        RestaurantPhotoService::assertPhotoUpload('image/gif', 'gif', 1024);
    }

    public function testServerSizeLimitErrorIsExplained(): void
    {
        self::assertSame('파일 크기가 서버 허용 한도를 초과했습니다.', RestaurantPhotoService::uploadErrorMessage(UPLOAD_ERR_INI_SIZE));
    }

    public function testUnknownUploadErrorFallsBackToGenericMessage(): void
    {
        self::assertSame('파일을 업로드하지 못했습니다.', RestaurantPhotoService::uploadErrorMessage(UPLOAD_ERR_CANT_WRITE));
    }

    public function testPhotoOfAnotherRestaurantIsRejected(): void
    {
        $this->expectException(InvalidArgumentException::class);
        RestaurantPhotoService::assertPhotoOwnership(['id' => 5, 'restaurant_id' => 2], 1);
    }

    public function testMissingPhotoIsRejected(): void
    {
        $this->expectException(InvalidArgumentException::class);
        RestaurantPhotoService::assertPhotoOwnership(null, 1);
    }

    public function testOwnPhotoIsAccepted(): void
    {
        $photo = ['id' => 5, 'restaurant_id' => 1];
        self::assertSame($photo, RestaurantPhotoService::assertPhotoOwnership($photo, 1));
    }

    /**
     * PHP 기본 upload_max_filesize(2M)가 앱 검증 한도(5MB)보다 작으면 3MB 파일도
     * PHP 업로드 단계에서 먼저 거부된다(#59). public/.user.ini가 앱 한도보다
     * 넉넉한 upload_max_filesize를 선언하도록 강제하는 회귀 테스트.
     */
    public function testUserIniUploadLimitCoversAppMaxFileSize(): void
    {
        $iniPath = __DIR__ . '/../../public/.user.ini';
        self::assertFileExists($iniPath, 'public/.user.ini가 존재해야 한다.');

        $values = parse_ini_file($iniPath);
        self::assertIsArray($values);
        self::assertArrayHasKey('upload_max_filesize', $values);

        $uploadMaxFilesizeBytes = self::iniSizeToBytes((string) $values['upload_max_filesize']);
        self::assertGreaterThanOrEqual(5 * 1024 * 1024, $uploadMaxFilesizeBytes);

        self::assertArrayHasKey('post_max_size', $values);
        $postMaxSizeBytes = self::iniSizeToBytes((string) $values['post_max_size']);
        self::assertGreaterThan($uploadMaxFilesizeBytes, $postMaxSizeBytes);
    }

    private static function iniSizeToBytes(string $value): int
    {
        $unit = strtoupper(substr($value, -1));
        $number = (int) $value;
        return match ($unit) {
            'G' => $number * 1024 * 1024 * 1024,
            'M' => $number * 1024 * 1024,
            'K' => $number * 1024,
            default => (int) $value,
        };
    }
}
