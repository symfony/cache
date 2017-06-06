<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Ernesto Cánovas <ernesto.canovas@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Cache\Tests\Adapter;

use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Tests\Adapter\FilesystemAdapterTest;

class FilesystemAdapterDefaultTimeTest extends FilesystemAdapterTest
{

    public function createCachePool()
    {
        if (defined('HHVM_VERSION')) {
            $this->skippedTests['testDeferredSaveWithoutCommit'] = 'Fails on HHVM';
        }
        return new FilesystemAdapter('sf-cache',5);
    }
    
    public function testDefaultTime()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);

            return;
        }
	
        $this->cache = $this->createCachePool();

        $item = $this->cache->getItem('key.dlt');
        $item->set('value');
        $this->cache->save($item);
	sleep(2);

	$item = $this->cache->getItem('key.dlt');
        $this->assertTrue($item->isHit());
	
        sleep(6);
        $item2 = $this->cache->getItem('key.dlt');
        $this->assertFalse($item2->isHit());
    }
}
