<?php
namespace SemanticReleases\Tests\Utils;

use SemanticReleases\Util\Versioning;
use PHPUnit\Framework\TestCase;

class VersioningTest extends TestCase
{
    private Versioning $versioning;

    public function setUp(): void
    {
        $this->versioning = new Versioning();
    }

    /**
     * @dataProvider getTestData
     */
    public function testValues(
        string | int | float | null $currentVersion,
        string $increaseType,
        string $expectedIncreasedVersion
    ): void {
        $this->assertEquals(
            $this->versioning->getIncreasedVersion(
                currentVersion: $currentVersion,
                increaseType: $increaseType
            ),
            $expectedIncreasedVersion
        );
    }

    public function getTestData(): array
    {
        return [
            // Stupid values.
            ['a', Versioning::MAJOR, '1.0.0'],
            ['dave', Versioning::MAJOR, '1.0.0'],
            ['dave.dave', Versioning::MAJOR, '1.0.0'],
            ['dave.dave.dave', Versioning::MAJOR, '1.0.0'],
            ['dave dave', Versioning::MAJOR, '1.0.0'],
            ['dave dave dave', Versioning::MAJOR, '1.0.0'],
            ['dave..dave', Versioning::MAJOR, '1.0.0'],
            ['-', Versioning::MAJOR, '1.0.0'],
            // Starting versioning
            [null, Versioning::MAJOR, '1.0.0',],
            [null, Versioning::MINOR, '0.1.0',],
            [null, Versioning::FIX, '0.0.1',],
            // Passing ints (supports versioned systems that are
            // incremental ints or floats)
            [0, Versioning::MAJOR, '1.0.0',],
            [0.0, Versioning::MAJOR, '1.0.0',],
            ['0', Versioning::MAJOR, '1.0.0',],
            [1, Versioning::MAJOR, '2.0.0',],
            // Start testing major increases
            ['1', Versioning::MAJOR, '2.0.0',],
            ['1.0', Versioning::MAJOR, '2.0.0',],
            ['1.0.0', Versioning::MAJOR, '2.0.0',],
            ['1.1.0', Versioning::MAJOR, '2.0.0',],
            ['1.0.1', Versioning::MAJOR, '2.0.0',],
            // Start testing minor increases
            ['0', Versioning::MINOR, '0.1.0',],
            ['1', Versioning::MINOR, '1.1.0',],
            ['1.0', Versioning::MINOR, '1.1.0',],
            ['1.0.0', Versioning::MINOR, '1.1.0',],
            ['1.1.0', Versioning::MINOR, '1.2.0',],
            ['1.0.1', Versioning::MINOR, '1.1.0',],
            // Start testing fix increases
            ['1', Versioning::FIX, '1.0.1',],
            ['1.0', Versioning::FIX, '1.0.1',],
            ['1.0.0', Versioning::FIX, '1.0.1',],
            ['1.1.0', Versioning::FIX, '1.1.1',],
            ['1.0.1', Versioning::FIX, '1.0.2',],
        ];
    }
}