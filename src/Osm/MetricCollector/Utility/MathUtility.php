<?php

namespace Osm\MetricCollector\Utility;

/**
 * Provides various utility about calculations.
 */
class MathUtility
{

    /**
     * Calculates percentages of given array values.
     *
     * @param array $values
     *
     * @return array
     */
    public static function calculatePercentages(array $values)
    {
        $total = array_sum($values);

        return array_map(
            function ($value) use ($total) {
                return ($value / $total) * 100;
            },
            $values
        );
    }

}
