<?php
namespace Test\Entity;

class TableName
{
    /** var string */
    public string $test_pro;

    /**
     * get test_pro
     *
     * @return string
     */
    public function getTestPro(): string
    {
        return $this->test_pro;
    }

    /**
     * set test_pro
     *
     * @param string test_pro
     * @return void
     */
    public function setTestPro(string $test_pro): void
    {
        $this->test_pro = $test_pro;
    }
}
