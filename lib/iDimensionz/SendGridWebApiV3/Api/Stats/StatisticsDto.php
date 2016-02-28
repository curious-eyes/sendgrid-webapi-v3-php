<?php
/*
 * iDimensionz/{sendgrid-webapi-v3}
 * StatisticsDto.php
 *  
 * The MIT License (MIT)
 * 
 * Copyright (c) 2015 iDimensionz
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
*/

namespace iDimensionz\SendGridWebApiV3\Api\Stats;

class StatisticsDto
{
    const DATE_FORMAT = 'Y-m-d';

    /**
     * @var \DateTime
     */
    private $date;
    /**
     * @var MetricsDto[]
     */
    private $metricsDtos;

    /**
     * @param array $statistics
     */
    public function __construct(array $statistics)
    {
        if (
            array_key_exists('date', $statistics) &&
            array_key_exists('stats', $statistics)
        ) {
            $this->setDate($statistics['date']);
            $this->setMetricsDto($statistics['stats']);
        } else {
            throw new \InvalidArgumentException('Statistics data must be an array containing date and stats');
        }
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param string $date
     */
    private function setDate($date)
    {
        $dateTime = new \DateTime($date);
        if ($date != $dateTime->format(self::DATE_FORMAT)) {
            throw new \InvalidArgumentException('Date must be in the format "' . self::DATE_FORMAT . '"');
        }
        $this->date = $dateTime;
    }

    /**
     * @return MetricsDto[]
     */
    public function getMetricsDtos()
    {
        return $this->metricsDtos;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $output = [];
        $output['date'] = $this->getDate()->format(self::DATE_FORMAT);
        $metricsData = [];
        /**
         * @var MetricsDto $metricsDto
         */
        foreach ($this->getMetricsDtos() as $metricsDto) {
            $metricsData[] = $metricsDto->toArray();
        }
        $output['stats'] = $metricsData;

        return $output;
    }
    /**
     * @param array $metrics
     */
    private function setMetricsDto($metrics)
    {
        $this->metricsDtos = [];
        foreach ($metrics as $metricsData) {
            $this->metricsDtos[] = new MetricsDto($metricsData);
        }
    }
}