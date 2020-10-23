<?php

namespace Tests;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    const TABLENUMBER = 111;
    const PRODUCT_ID = '037d4a31-a464-403c-a2df-450773087096';
}
