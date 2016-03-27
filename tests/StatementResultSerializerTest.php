<?php

/*
 * This file is part of the xAPI package.
 *
 * (c) Christian Flothmann <christian.flothmann@xabbuh.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xabbuh\XApi\Serializer\Tests;

use Xabbuh\XApi\DataFixtures\StatementResultFixtures;
use Xabbuh\XApi\Serializer\Serializer;
use Xabbuh\XApi\Serializer\StatementResultSerializer;
use XApi\Fixtures\Json\StatementResultJsonFixtures;

/**
 * @author Christian Flothmann <christian.flothmann@xabbuh.de>
 */
class StatementResultSerializerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var StatementResultSerializer
     */
    private $statementResultSerializer;

    protected function setUp()
    {
        $this->statementResultSerializer = new StatementResultSerializer(Serializer::createSerializer());
    }
    public function testDeserializeStatementResult()
    {
        /** @var \Xabbuh\XApi\Model\StatementResult $statementResult */
        $statementResult = $this->statementResultSerializer->deserializeStatementResult(
            StatementResultJsonFixtures::getStatementResult()
        );
        $statements = $statementResult->getStatements();

        $this->assertEquals(2, count($statements));
        $this->assertEquals(
            '12345678-1234-5678-8234-567812345678',
            $statements[0]->getId()
        );
        $this->assertEquals(
            '12345678-1234-5678-8234-567812345679',
            $statements[1]->getId()
        );
        $this->assertNull($statementResult->getMoreUrlPath());
    }

    public function testSerializeMinimalStatement()
    {
        $statementResult = StatementResultFixtures::getStatementResult();

        $this->assertJsonStringEqualsJsonString(
            StatementResultJsonFixtures::getStatementResult(),
            $this->statementResultSerializer->serializeStatementResult($statementResult)
        );
    }

    public function testDeserializeStatementResultWithMore()
    {
        /** @var \Xabbuh\XApi\Model\StatementResult $statementResult */
        $statementResult = $this->statementResultSerializer->deserializeStatementResult(
            StatementResultJsonFixtures::getStatementResultWithMore()
        );
        $statements = $statementResult->getStatements();

        $this->assertEquals(2, count($statements));
        $this->assertEquals(
            '12345678-1234-5678-8234-567812345678',
            $statements[0]->getId()
        );
        $this->assertEquals(
            '12345678-1234-5678-8234-567812345679',
            $statements[1]->getId()
        );
        $this->assertEquals(
            '/xapi/statements/more/b381d8eca64a61a42c7b9b4ecc2fabb6',
            $statementResult->getMoreUrlPath()
        );
    }

    public function testSerializeMinimalStatementWithMore()
    {
        $statementResult = StatementResultFixtures::getStatementResultWithMore();

        $this->assertJsonStringEqualsJsonString(
            StatementResultJsonFixtures::getStatementResultWithMore(),
            $this->statementResultSerializer->serializeStatementResult($statementResult)
        );
    }
}
