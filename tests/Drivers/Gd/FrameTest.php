<?php

namespace Intervention\Image\Tests\Drivers\Gd;

use GdImage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Drivers\Gd\Frame;
use Intervention\Image\Image;
use Intervention\Image\Geometry\Rectangle;
use Intervention\Image\Tests\TestCase;

/**
 * @requires extension gd
 * @covers \Intervention\Image\Drivers\Gd\Frame
 */
class FrameTest extends TestCase
{
    protected function getTestFrame(): Frame
    {
        return new Frame(imagecreatetruecolor(3, 2));
    }

    public function testConstructor(): void
    {
        $frame = $this->getTestFrame();
        $this->assertInstanceOf(Frame::class, $frame);
    }

    public function testGetNative(): void
    {
        $frame = $this->getTestFrame();
        $this->assertInstanceOf(GdImage::class, $frame->native());
    }

    public function testSetCore(): void
    {
        $core1 = imagecreatetruecolor(3, 2);
        $core2 = imagecreatetruecolor(3, 3);
        $frame = new Frame($core1);
        $this->assertEquals(2, $frame->size()->height());
        $result = $frame->setNative($core2);
        $this->assertInstanceOf(Frame::class, $result);
        $this->assertEquals(3, $frame->size()->height());
    }

    public function testGetSize(): void
    {
        $frame = $this->getTestFrame();
        $this->assertInstanceOf(Rectangle::class, $frame->size());
    }

    public function testSetGetDelay()
    {
        $frame = $this->getTestFrame();
        $this->assertEquals(0, $frame->delay());

        $result = $frame->setDelay(1.5);
        $this->assertInstanceOf(Frame::class, $result);
        $this->assertEquals(1.5, $frame->delay());
    }

    public function testSetGetDispose()
    {
        $frame = $this->getTestFrame();
        $this->assertEquals(1, $frame->dispose());

        $result = $frame->setDispose(100);
        $this->assertInstanceOf(Frame::class, $result);
        $this->assertEquals(100, $frame->dispose());
    }

    public function testSetGetOffsetLeft()
    {
        $frame = $this->getTestFrame();
        $this->assertEquals(0, $frame->offsetLeft());

        $result = $frame->setOffsetLeft(100);
        $this->assertInstanceOf(Frame::class, $result);
        $this->assertEquals(100, $frame->offsetLeft());
    }

    public function testSetGetOffsetTop()
    {
        $frame = $this->getTestFrame();
        $this->assertEquals(0, $frame->offsetTop());

        $result = $frame->setOffsetTop(100);
        $this->assertInstanceOf(Frame::class, $result);
        $this->assertEquals(100, $frame->offsetTop());
    }

    public function testSetGetOffset()
    {
        $frame = $this->getTestFrame();
        $this->assertEquals(0, $frame->offsetTop());
        $this->assertEquals(0, $frame->offsetLeft());

        $result = $frame->setOffset(100, 200);
        $this->assertInstanceOf(Frame::class, $result);
        $this->assertEquals(100, $frame->offsetLeft());
        $this->assertEquals(200, $frame->offsetTop());
    }

    public function testToImage(): void
    {
        $frame = $this->getTestFrame();
        $this->assertInstanceOf(Image::class, $frame->toImage(new Driver()));
    }
}
