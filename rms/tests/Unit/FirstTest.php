<?php
use tests\TestCase;

class FirstTest extends TestCase {

    public function test_my_first_test_case(){
        $this->assertTrue(true);
    }

    public function test_my_second_test_case(){
        $p = 20;
        $this->assertEquals($p,20);
    }

    /**
     * @test
     */
    public function my_second_test_case_without_prefix(){
        $p = 20;
        $this->assertEquals($p,20);
    }

}