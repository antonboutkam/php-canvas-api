<?php

namespace Hurah\Canvas\Test\Endpoints\Page;

use PHPUnit\Framework\TestCase;
use Hurah\Canvas\Endpoints\Page\Page;

class PageTest extends TestCase
{
    private string $sUrl = '/adfs/sadfasd';
    private string $sTitle = 'Test';
    private Page $oPage;
    public function setUp(): void
    {
        $this->oPage = Page::fromCanvasArray([
            'title' => $this->sTitle,
            'url' => $this->sUrl,
            'front_page' => true
        ]);
    }

    public function testGetUrl()
    {
        static::assertEquals($this->sUrl, $this->oPage->getUrl());
    }

    public function testFromCanvasArray()
    {
		 $sTitle = 'Test';
        $oPage = Page::fromCanvasArray([
            'title' => $sTitle,
            'url' => $this->sUrl,
            'front_page' => true
        ]);
		  static::assertInstanceOf(Page::class, $oPage);
		  static::assertEquals($sTitle, $oPage->getTitle());
    }

	/**
	 * @return void
	 */
    public function testToCanvasArray()
    {
     //   $this->oPage->setFrontPage(true);
        $aCanvasArray  = $this->oPage->toCanvasArray();
        static::assertEquals(true, $aCanvasArray['wiki_page']['front_page']);
    }

    public function testSetTitle()
    {
        $aCanvasArray  = $this->oPage->toCanvasArray();
        $this->assertEquals($this->sTitle, $aCanvasArray['wiki_page']['title']);

    }
}
