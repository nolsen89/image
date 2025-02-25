<?php

namespace Intervention\Image\Tests\Drivers\Imagick\Modifiers;

use Intervention\Image\Modifiers\CropModifier;
use Intervention\Image\Tests\TestCase;
use Intervention\Image\Tests\Traits\CanCreateImagickTestImage;

/**
 * @requires extension gd
 * @covers \Intervention\Image\Modifiers\CropModifier
 */
class CropModifierTest extends TestCase
{
    use CanCreateImagickTestImage;

    public function testModify(): void
    {
        $image = $this->readTestImage('blocks.png');
        $image = $image->modify(new CropModifier(200, 200, 0, 0, 'bottom-right'));
        $this->assertEquals(200, $image->width());
        $this->assertEquals(200, $image->height());
        $this->assertColor(255, 0, 0, 255, $image->pickColor(5, 5));
        $this->assertColor(255, 0, 0, 255, $image->pickColor(100, 100));
        $this->assertColor(255, 0, 0, 255, $image->pickColor(190, 190));
    }
}
