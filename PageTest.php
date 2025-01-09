<?php

namespace Hurah\Canvas\Endpoints\Page;

use PHPUnit\Framework\TestCase;

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
        $oPage = Page::fromCanvasArray([
            'title' => 'Test',
            'url' => $this->sUrl,
            'front_page' => true
        ]);
    }


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
