<?php

namespace Hurah\Canvas\Commands;

use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\OutputInterface;

trait ItemPrintTrait
{
    public function printItem(array $aItem, OutputInterface $output)
    {
        $table = new Table($output);
        $table->setHeaders(['Key', 'Value']);

        foreach ($aItem as $key => $value)
        {
            if(is_array($value))
            {
                foreach ($value as $subKey => $subValue) {
                    $table->addRow([$key . '_' . $subKey, $subValue]);
                }
            }
            else
            {
                $table->addRow([$key, $value]);
            }
        }
        $table->render();
    }
}