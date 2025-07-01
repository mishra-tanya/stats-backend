<?php

namespace App\Services;

use Google\Analytics\Data\V1beta\Client\BetaAnalyticsDataClient;
use Google\Analytics\Data\V1beta\RunReportRequest;
use Google\Analytics\Data\V1beta\DateRange;
use Google\Analytics\Data\V1beta\Metric;
use Google\Analytics\Data\V1beta\Dimension;

class AnalyticsService
{
    protected function getClient()
    {
        return new BetaAnalyticsDataClient([
            'credentials' => storage_path('app/google/credentials.json'),
            'transport' => 'rest',
        ]);
    }

    protected function getStartDate($range)
    {
        return match ($range) {
            'today'     => now()->toDateString(),
            'yesterday' => now()->subDay()->toDateString(),
            '7days'     => now()->subDays(7)->toDateString(),
            '15days'    => now()->subDays(15)->toDateString(),
            '30days'    => now()->subDays(30)->toDateString(),
            '3months'   => now()->subMonths(3)->toDateString(),
            '6months'   => now()->subMonths(6)->toDateString(),
            '1year'     => now()->subYear()->toDateString(),
            default     => now()->subDays(30)->toDateString(),
        };
    }

    public function getPageViews($propertyId, $range = '30days', $from = null, $to = null)
    {
        $client = $this->getClient();

        $startDate = $from ?: $this->getStartDate($range);
        $endDate = $to ?: now()->toDateString();

        $request = new RunReportRequest([
            'property' => 'properties/' . $propertyId,
            'date_ranges' => [
                new DateRange([
                    'start_date' => $startDate,
                    'end_date'   => $endDate,
                ]),
            ],
            'dimensions' => [
                new Dimension(['name' => 'pagePath']),
            ],
            'metrics' => [
                new Metric(['name' => 'screenPageViews']),
            ],
        ]);

        $response = $client->runReport($request);

        $data = [];
        foreach ($response->getRows() as $row) {
            $data[] = [
                'url'   => $row->getDimensionValues()[0]->getValue(),
                'views' => $row->getMetricValues()[0]->getValue(),
            ];
        }

        return $data;
    }


    public function getUsersByCityAndCountry($propertyId, $range = '30days', $from = null, $to = null)
    {
        $client = $this->getClient();
        $startDate = $from ?: $this->getStartDate($range);
        $endDate = $to ?: now()->toDateString();

        $request = new RunReportRequest([
            'property' => 'properties/' . $propertyId,
            'date_ranges' => [
                new DateRange([
                    'start_date' => $startDate,
                    'end_date'   => $endDate,
                ]),
            ],
            'dimensions' => [
                new Dimension(['name' => 'country']),
                new Dimension(['name' => 'city']),
            ],
            'metrics' => [
                new Metric(['name' => 'activeUsers']),
            ],
        ]);

        $response = $client->runReport($request);

        $data = [];

        foreach ($response->getRows() as $row) {
            $data[] = [
                'country' => $row->getDimensionValues()[0]->getValue(),
                'city'    => $row->getDimensionValues()[1]->getValue(),
                'users'   => $row->getMetricValues()[0]->getValue(),
            ];
        }

        return $data;
    }

}
