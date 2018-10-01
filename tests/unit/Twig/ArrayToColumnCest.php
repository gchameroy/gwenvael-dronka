<?php

class ArrayToColumnCest
{
    /**
     * @dataProvider contentProvider
     */
    public function tryArrayToColumn(UnitTester $I, \Codeception\Example $example)
    {
        $filter = new \AppBundle\Twig\ArrayToColumn();
        $result = $filter->arrayToColumn($example['content']);

        $I->assertEquals($example['expected'], $result);
    }

    protected function contentProvider(): array
    {
        return [
            ['content' => '<table><tr><td>yolo</td></tr></table>', 'expected' => '<div class="row"><div class="col-md">yolo</div></div>'],
            ['content' => '<table><tr><td>yolo</td><td>testy</td></tr></table>', 'expected' => '<div class="row"><div class="col-md">yolo</div><div class="col-md">testy</div></div>'],
            ['content' => '<table border="0"><tr><td>yolo</td></tr></table>', 'expected' => '<div class="row"><div class="col-md">yolo</div></div>'],
        ];
    }
}
