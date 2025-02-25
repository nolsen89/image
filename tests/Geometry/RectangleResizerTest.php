<?php

namespace Intervention\Image\Tests\Geometry;

use Intervention\Image\Geometry\Point;
use Intervention\Image\Geometry\Rectangle;
use Intervention\Image\Geometry\Tools\RectangleResizer;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Intervention\Image\Geometry\Tools\RectangleResizer
 */
class RectangleResizerTest extends TestCase
{
    public function testMake(): void
    {
        $resizer = RectangleResizer::to();
        $this->assertInstanceOf(RectangleResizer::class, $resizer);

        $resizer = RectangleResizer::to(height: 100);
        $this->assertInstanceOf(RectangleResizer::class, $resizer);

        $resizer = RectangleResizer::to(100);
        $this->assertInstanceOf(RectangleResizer::class, $resizer);

        $resizer = RectangleResizer::to(100, 100);
        $this->assertInstanceOf(RectangleResizer::class, $resizer);
    }

    public function testToWidth(): void
    {
        $resizer = new RectangleResizer();
        $result = $resizer->toWidth(100);
        $this->assertInstanceOf(RectangleResizer::class, $result);
    }

    public function testToHeight(): void
    {
        $resizer = new RectangleResizer();
        $result = $resizer->toHeight(100);
        $this->assertInstanceOf(RectangleResizer::class, $result);
    }

    public function testToSize(): void
    {
        $resizer = new RectangleResizer();
        $resizer = $resizer->toSize(new Rectangle(200, 100));
        $this->assertInstanceOf(RectangleResizer::class, $resizer);
    }

    public function testResize()
    {
        $size = new Rectangle(300, 200);
        $resizer = new RectangleResizer();
        $resizer->toWidth(150);
        $result = $resizer->resize($size);
        $this->assertEquals(150, $result->width());
        $this->assertEquals(200, $result->height());

        $size = new Rectangle(300, 200);
        $resizer = new RectangleResizer();
        $resizer->toWidth(20);
        $resizer->toHeight(10);
        $result = $resizer->resize($size);
        $this->assertEquals(20, $result->width());
        $this->assertEquals(10, $result->height());

        $size = new Rectangle(300, 200);
        $resizer = new RectangleResizer(width: 150);
        $result = $resizer->resize($size);
        $this->assertEquals(150, $result->width());
        $this->assertEquals(200, $result->height());

        $size = new Rectangle(300, 200);
        $resizer = new RectangleResizer(height: 10, width: 20);
        $result = $resizer->resize($size);
        $this->assertEquals(20, $result->width());
        $this->assertEquals(10, $result->height());
    }

    public function testResizeDown()
    {
        // 800x600 > 1000x2000 = 800x600
        $size = new Rectangle(800, 600);
        $resizer = new RectangleResizer();
        $resizer->toWidth(1000);
        $resizer->toHeight(2000);
        $result = $resizer->resizeDown($size);
        $this->assertEquals(800, $result->width());
        $this->assertEquals(600, $result->height());

        // 800x600 > 400x1000 = 400x600
        $size = new Rectangle(800, 600);
        $resizer = new RectangleResizer();
        $resizer->toWidth(400);
        $resizer->toHeight(1000);
        $result = $resizer->resizeDown($size);
        $this->assertEquals(400, $result->width());
        $this->assertEquals(600, $result->height());

        // 800x600 > 1000x400 = 800x400
        $size = new Rectangle(800, 600);
        $resizer = new RectangleResizer();
        $resizer->toWidth(1000);
        $resizer->toHeight(400);
        $result = $resizer->resizeDown($size);
        $this->assertEquals(800, $result->width());
        $this->assertEquals(400, $result->height());

        // 800x600 > 400x300 = 400x300
        $size = new Rectangle(800, 600);
        $resizer = new RectangleResizer();
        $resizer->toWidth(400);
        $resizer->toHeight(300);
        $result = $resizer->resizeDown($size);
        $this->assertEquals(400, $result->width());
        $this->assertEquals(300, $result->height());

        // 800x600 > 1000xnull = 800x600
        $size = new Rectangle(800, 600);
        $resizer = new RectangleResizer();
        $resizer->toWidth(1000);
        $result = $resizer->resizeDown($size);
        $this->assertEquals(800, $result->width());
        $this->assertEquals(600, $result->height());

        // 800x600 > nullx1000 = 800x600
        $size = new Rectangle(800, 600);
        $resizer = new RectangleResizer();
        $resizer->toHeight(1000);
        $result = $resizer->resizeDown($size);
        $this->assertEquals(800, $result->width());
        $this->assertEquals(600, $result->height());
    }

    public function testScale()
    {
        // 800x600 > 1000x2000 = 1000x750
        $size = new Rectangle(800, 600);
        $resizer = new RectangleResizer();
        $resizer->toWidth(1000);
        $resizer->toHeight(2000);
        $result = $resizer->scale($size);
        $this->assertEquals(1000, $result->width());
        $this->assertEquals(750, $result->height());

        // 800x600 > 2000x1000 = 1333x1000
        $size = new Rectangle(800, 600);
        $resizer = new RectangleResizer();
        $resizer->toWidth(2000);
        $resizer->toHeight(1000);
        $result = $resizer->scale($size);
        $this->assertEquals(1333, $result->width());
        $this->assertEquals(1000, $result->height());

        // // 800x600 > nullx3000 = 4000x3000
        $size = new Rectangle(800, 600);
        $resizer = new RectangleResizer();
        $resizer->toHeight(3000);
        $result = $resizer->scale($size);
        $this->assertEquals(4000, $result->width());
        $this->assertEquals(3000, $result->height());

        // // 800x600 > 8000xnull = 8000x6000
        $size = new Rectangle(800, 600);
        $resizer = new RectangleResizer();
        $resizer->toWidth(8000);
        $result = $resizer->scale($size);
        $this->assertEquals(8000, $result->width());
        $this->assertEquals(6000, $result->height());

        // // 800x600 > 100x400 = 100x75
        $size = new Rectangle(800, 600);
        $resizer = new RectangleResizer();
        $resizer->toWidth(100);
        $resizer->toHeight(400);
        $result = $resizer->scale($size);
        $this->assertEquals(100, $result->width());
        $this->assertEquals(75, $result->height());

        // // 800x600 > 400x100 = 133x100
        $size = new Rectangle(800, 600);
        $resizer = new RectangleResizer();
        $resizer->toWidth(400);
        $resizer->toHeight(100);
        $result = $resizer->scale($size);
        $this->assertEquals(133, $result->width());
        $this->assertEquals(100, $result->height());

        // // 800x600 > nullx300 = 400x300
        $size = new Rectangle(800, 600);
        $resizer = new RectangleResizer();
        $resizer->toHeight(300);
        $result = $resizer->scale($size);
        $this->assertEquals(400, $result->width());
        $this->assertEquals(300, $result->height());

        // // 800x600 > 80xnull = 80x60
        $size = new Rectangle(800, 600);
        $resizer = new RectangleResizer();
        $resizer->toWidth(80);
        $result = $resizer->scale($size);
        $this->assertEquals(80, $result->width());
        $this->assertEquals(60, $result->height());

        // // 640x480 > 225xnull = 225x169
        $size = new Rectangle(640, 480);
        $resizer = new RectangleResizer();
        $resizer->toWidth(225);
        $result = $resizer->scale($size);
        $this->assertEquals(225, $result->width());
        $this->assertEquals(169, $result->height());

        // // 640x480 > 223xnull = 223x167
        $size = new Rectangle(640, 480);
        $resizer = new RectangleResizer();
        $resizer->toWidth(223);
        $result = $resizer->scale($size);
        $this->assertEquals(223, $result->width());
        $this->assertEquals(167, $result->height());

        // // 600x800 > 300x300 = 225x300
        $size = new Rectangle(600, 800);
        $resizer = new RectangleResizer();
        $resizer->toWidth(300);
        $resizer->toHeight(300);
        $result = $resizer->scale($size);
        $this->assertEquals(225, $result->width());
        $this->assertEquals(300, $result->height());

        // // 800x600 > 400x10 = 13x10
        $size = new Rectangle(800, 600);
        $resizer = new RectangleResizer();
        $resizer->toWidth(400);
        $resizer->toHeight(10);
        $result = $resizer->scale($size);
        $this->assertEquals(13, $result->width());
        $this->assertEquals(10, $result->height());

        // // 800x600 > 1000x1200 = 1000x750
        $size = new Rectangle(800, 600);
        $resizer = new RectangleResizer();
        $resizer->toWidth(1000);
        $resizer->toHeight(1200);
        $result = $resizer->scale($size);
        $this->assertEquals(1000, $result->width());
        $this->assertEquals(750, $result->height());

        $size = new Rectangle(12000, 12);
        $resizer = new RectangleResizer();
        $resizer->toWidth(4000);
        $resizer->toHeight(3000);
        $result = $resizer->scale($size);
        $this->assertEquals(4000, $result->width());
        $this->assertEquals(4, $result->height());

        $size = new Rectangle(12, 12000);
        $resizer = new RectangleResizer();
        $resizer->toWidth(4000);
        $resizer->toHeight(3000);
        $result = $resizer->scale($size);
        $this->assertEquals(3, $result->width());
        $this->assertEquals(3000, $result->height());

        $size = new Rectangle(12000, 6000);
        $resizer = new RectangleResizer();
        $resizer->toWidth(4000);
        $resizer->toHeight(3000);
        $result = $resizer->scale($size);
        $this->assertEquals(4000, $result->width());
        $this->assertEquals(2000, $result->height());
    }

    public function testScaleDown()
    {
        $size = new Rectangle(800, 600);
        $resizer = new RectangleResizer();
        $resizer->toWidth(1000);
        $resizer->toHeight(2000);
        $result = $resizer->scaleDown($size);
        $this->assertEquals(800, $result->width());
        $this->assertEquals(600, $result->height());

        $size = new Rectangle(800, 600);
        $resizer = new RectangleResizer();
        $resizer->toWidth(1000);
        $resizer->toHeight(600);
        $result = $resizer->scaleDown($size);
        $this->assertEquals(800, $result->width());
        $this->assertEquals(600, $result->height());

        $size = new Rectangle(800, 600);
        $resizer = new RectangleResizer();
        $resizer->toWidth(1000);
        $resizer->toHeight(300);
        $result = $resizer->scaleDown($size);
        $this->assertEquals(400, $result->width());
        $this->assertEquals(300, $result->height());

        $size = new Rectangle(800, 600);
        $resizer = new RectangleResizer();
        $resizer->toWidth(400);
        $resizer->toHeight(1000);
        $result = $resizer->scaleDown($size);
        $this->assertEquals(400, $result->width());
        $this->assertEquals(300, $result->height());

        $size = new Rectangle(800, 600);
        $resizer = new RectangleResizer();
        $resizer->toWidth(400);
        $result = $resizer->scaleDown($size);
        $this->assertEquals(400, $result->width());
        $this->assertEquals(300, $result->height());

        $size = new Rectangle(800, 600);
        $resizer = new RectangleResizer();
        $resizer->toHeight(300);
        $result = $resizer->scaleDown($size);
        $this->assertEquals(400, $result->width());
        $this->assertEquals(300, $result->height());

        $size = new Rectangle(800, 600);
        $resizer = new RectangleResizer();
        $resizer->toWidth(1000);
        $result = $resizer->scaleDown($size);
        $this->assertEquals(800, $result->width());
        $this->assertEquals(600, $result->height());

        $size = new Rectangle(800, 600);
        $resizer = new RectangleResizer();
        $resizer->toHeight(1000);
        $result = $resizer->scaleDown($size);
        $this->assertEquals(800, $result->width());
        $this->assertEquals(600, $result->height());

        $size = new Rectangle(800, 600);
        $resizer = new RectangleResizer();
        $resizer->toWidth(100);
        $result = $resizer->scaleDown($size);
        $this->assertEquals(100, $result->width());
        $this->assertEquals(75, $result->height());

        $size = new Rectangle(800, 600);
        $resizer = new RectangleResizer();
        $resizer->toWidth(300);
        $resizer->toHeight(200);
        $result = $resizer->scaleDown($size);
        $this->assertEquals(267, $result->width());
        $this->assertEquals(200, $result->height());

        $size = new Rectangle(600, 800);
        $resizer = new RectangleResizer();
        $resizer->toWidth(300);
        $resizer->toHeight(300);
        $result = $resizer->scaleDown($size);
        $this->assertEquals(225, $result->width());
        $this->assertEquals(300, $result->height());

        $size = new Rectangle(800, 600);
        $resizer = new RectangleResizer();
        $resizer->toWidth(400);
        $resizer->toHeight(10);
        $result = $resizer->scaleDown($size);
        $this->assertEquals(13, $result->width());
        $this->assertEquals(10, $result->height());
    }

    /**
     * @dataProvider coverDataProvider
    */
    public function testCover($origin, $target, $result): void
    {
        $resizer = new RectangleResizer();
        $resizer->toSize($target);
        $resized = $resizer->cover($origin);
        $this->assertEquals($result->width(), $resized->width());
        $this->assertEquals($result->height(), $resized->height());
    }

    public function coverDataProvider(): array
    {
        return [
            [new Rectangle(800, 600), new Rectangle(100, 100), new Rectangle(133, 100)],
            [new Rectangle(800, 600), new Rectangle(200, 100), new Rectangle(200, 150)],
            [new Rectangle(800, 600), new Rectangle(100, 200), new Rectangle(267, 200)],
            [new Rectangle(800, 600), new Rectangle(2000, 10), new Rectangle(2000, 1500)],
            [new Rectangle(800, 600), new Rectangle(10, 2000), new Rectangle(2667, 2000)],
            [new Rectangle(800, 600), new Rectangle(800, 600), new Rectangle(800, 600)],
            [new Rectangle(400, 300), new Rectangle(120, 120), new Rectangle(160, 120)],
            [new Rectangle(600, 800), new Rectangle(100, 100), new Rectangle(100, 133)],
            [new Rectangle(100, 100), new Rectangle(800, 600), new Rectangle(800, 800)],
        ];
    }

    /**
     * @dataProvider containDataProvider
    */
    public function testContain($origin, $target, $result): void
    {
        $resizer = new RectangleResizer();
        $resizer->toSize($target);
        $resized = $resizer->contain($origin);
        $this->assertEquals($result->width(), $resized->width());
        $this->assertEquals($result->height(), $resized->height());
    }

    public function containDataProvider(): array
    {
        return [
            [new Rectangle(800, 600), new Rectangle(100, 100), new Rectangle(100, 75)],
            [new Rectangle(800, 600), new Rectangle(200, 100), new Rectangle(133, 100)],
            [new Rectangle(800, 600), new Rectangle(100, 200), new Rectangle(100, 75)],
            [new Rectangle(800, 600), new Rectangle(2000, 10), new Rectangle(13, 10)],
            [new Rectangle(800, 600), new Rectangle(10, 2000), new Rectangle(10, 8)],
            [new Rectangle(800, 600), new Rectangle(800, 600), new Rectangle(800, 600)],
            [new Rectangle(400, 300), new Rectangle(120, 120), new Rectangle(120, 90)],
            [new Rectangle(600, 800), new Rectangle(100, 100), new Rectangle(75, 100)],
            [new Rectangle(100, 100), new Rectangle(800, 600), new Rectangle(600, 600)],
        ];
    }

    /**
     * @dataProvider cropDataProvider
    */
    public function testCrop($origin, $target, $position, $result): void
    {
        $resizer = new RectangleResizer();
        $resizer->toSize($target);
        $resized = $resizer->crop($origin, $position);
        $this->assertEquals($result->width(), $resized->width());
        $this->assertEquals($result->height(), $resized->height());
        $this->assertEquals($result->pivot()->x(), $resized->pivot()->x());
        $this->assertEquals($result->pivot()->y(), $resized->pivot()->y());
    }

    public function cropDataProvider(): array
    {
        return [
            [new Rectangle(800, 600), new Rectangle(100, 100), 'center', new Rectangle(100, 100, new Point(350, 250))],
            [new Rectangle(800, 600), new Rectangle(200, 100), 'center', new Rectangle(200, 100, new Point(300, 250))],
            [new Rectangle(800, 600), new Rectangle(100, 200), 'center', new Rectangle(100, 200, new Point(350, 200))],
            [new Rectangle(800, 600), new Rectangle(2000, 10), 'center', new Rectangle(2000, 10, new Point(-600, 295))],
            [new Rectangle(800, 600), new Rectangle(10, 2000), 'center', new Rectangle(10, 2000, new Point(395, -700))],
            [new Rectangle(800, 600), new Rectangle(800, 600), 'center', new Rectangle(800, 600, new Point(0, 0))],
            [new Rectangle(400, 300), new Rectangle(120, 120), 'center', new Rectangle(120, 120, new Point(140, 90))],
            [new Rectangle(600, 800), new Rectangle(100, 100), 'center', new Rectangle(100, 100, new Point(250, 350))],
        ];
    }
}
