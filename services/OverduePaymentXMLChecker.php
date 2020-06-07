<?php

namespace app\services;

use XMLReader;

class OverduePaymentXMLChecker
{
    public function checkOverduesXmlFile(string $xmlFilePath, string $outputFile)
    {
        $this->reader = new XMLReader();
        $this->reader->open($xmlFilePath);
        file_put_contents($outputFile, '');

        while ($this->reader->read()) {

            if ($this->reader->nodeType == XMLReader::ELEMENT && $this->reader->name == 'payment') {
                $paymentId = (int)$this->reader->getAttribute('id');
                $creditId = null;
                $overdue = null;

                // внутренние узлы payment
                while ($this->reader->read() && $this->reader->name != 'payment') {

                    if ($this->reader->nodeType == XMLReader::ELEMENT && $this->reader->name == 'cred_id') {
                        $creditId = (int)$this->reader->readInnerXml();
                    }
                    if ($this->reader->nodeType == XMLReader::ELEMENT && $this->reader->name == 'overdue') {
                        $overdue = (float)$this->reader->readInnerXml();
                    }
                }

                $nodeHasError = false;
                if ($paymentId <= 0) {
                    $nodeHasError = true;
                }
                if ($creditId <= 0) {
                    $nodeHasError = true;
                }
                if ($overdue <= 0) {
                    $nodeHasError = true;
                }

                if ($nodeHasError) {
                    file_put_contents($outputFile, $creditId, FILE_APPEND);
                }
            }
        }
    }
}
