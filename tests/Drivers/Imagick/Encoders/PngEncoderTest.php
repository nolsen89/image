<?php

declare(strict_types=1);

namespace Intervention\Image\Tests\Drivers\Imagick\Encoders;

use Imagick;
use ImagickPixel;
use Intervention\Image\Drivers\Imagick\Core;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\Encoders\PngEncoder;
use Intervention\Image\Image;
use Intervention\Image\Tests\TestCase;
use Intervention\Image\Tests\Traits\CanCreateImagickTestImage;

/**
 * @requires extension imagick
 */
final class PngEncoderTest extends TestCase
{
    use CanCreateImagickTestImage;

    protected function getTestImage(): Image
    {
        $imagick = new Imagick();
        $imagick->newImage(3, 2, new ImagickPixel('red'), 'jpg');

        return new Image(
            new Driver(),
            new Core($imagick)
        );
    }

    public function testEncode(): void
    {
        $image = $this->getTestImage();
        $encoder = new PngEncoder(75);
        $result = $encoder->encode($image);
        $this->assertMimeType('image/png', (string) $result);
    }

    public function testEncodeReduced(): void
    {
        $image = $this->readTestImage('tile.png');
        $imagick = $image->core()->native();
        $this->assertEquals(3, $imagick->getImageColors());
        $encoder = new PngEncoder(2);
        $result = $encoder->encode($image);
        $imagick = new Imagick();
        $imagick->readImageBlob((string) $result);
        $this->assertEquals(2, $imagick->getImageColors());
    }
}
