<?php
declare(strict_types=1);

namespace SemanticReleases\Util;

class Versioning
{
    public const MAJOR = 'major';
    public const MINOR = 'minor';
    public const FIX = 'fix';

    public const ALLOWED_TYPES = [
        self::MAJOR,
        self::MINOR,
        self::FIX,
    ];

    /**
     * @param string | int | float | null $currentVersion
     * @param string $increaseType
     * @return string
     * @throws \Exception
     */
    public function getIncreasedVersion(
        string | int | float | null $currentVersion = null,
        string $increaseType = self::MAJOR
    ): string {
        /**
         * Check for empty values, useful if an item is the first version.
         */
        if (!$currentVersion) {
            $currentVersion = "0.0.0";
        }

        /**
         * Verify the increase type is valid
         */
        if (!in_array($increaseType, self::ALLOWED_TYPES)) {
            throw new \Exception(sprintf(
                'Unknown type %s, allowed types are %s',
                $increaseType,
                implode(',', self::ALLOWED_TYPES)
            ));
        }

        /**
         * Split up the parts and re-assign for later use.
         */
        $parts = explode('.', (string)$currentVersion);
        $major = $parts[0] ?? 0;
        $minor = $parts[1] ?? 0;
        $fix = $parts[2] ?? 0;

        /**
         * Depending on the increase type, bump the version number.
         */
        switch ($increaseType) {
            case self::MINOR:
                $minor = $this->increasePart($minor);
                $fix = 0;
                break;
            case self::FIX:
                $fix = $this->increasePart($fix);
                break;
            default:
                $major = $this->increasePart($major);
                $minor = 0;
                $fix = 0;
                break;
        }

        return sprintf(
            '%s.%s.%s',
            (int)$major,
            (int)$minor,
            $fix
        );
    }

    private function increasePart(string | int $part): int
    {
        $part = (int)$part;
        $part++;

        return $part;
    }
}
