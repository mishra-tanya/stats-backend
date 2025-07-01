<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AnalyticsService;

class GAnalyticsController extends Controller
{
    protected $analytics;

    public function __construct(AnalyticsService $analytics)
    {
        $this->analytics = $analytics;
    }

    public function getSiteAnalytics(Request $request, $site)
    {
        $propertyId = $this->resolvePropertyId($site);
        if (!$propertyId) return apiError('Invalid site name', 400);

        $range = $request->query('range', '30days');
        $from = $request->query('from');
        $to = $request->query('to');

        try {
            $data = $this->analytics->getPageViews($propertyId, $range, $from, $to);
            return $this->handleSuccess($data, 'Fetched analytics data');
        } catch (\Throwable $e) {
            return apiError('Server error: ' . $e->getMessage(), 500);
        }
    }


    public function getUsersByCity(Request $request, $site)
    {
        $propertyId = $this->resolvePropertyId($site);
        if (!$propertyId) return apiError('Invalid site name', 400);

        $range = $request->query('range', '30days');
        $from = $request->query('from');
        $to = $request->query('to');

        try {
            $data = $this->analytics->getUsersByCityAndCountry($propertyId, $range, $from, $to);
            return $this->handleSuccess($data, 'Fetched user location data');
        } catch (\Throwable $e) {
            return apiError('Server error: ' . $e->getMessage(), 500);
        }
    }

    private function resolvePropertyId($site)
    {
        return match ($site) {
            'site1' => env('GA4_PROPERTY_ID_SITE1'),
            'site2' => env('GA4_PROPERTY_ID_SITE2'),
            'site3' => env('GA4_PROPERTY_ID_SITE3'),
            'site4' => env('GA4_PROPERTY_ID_SITE4'),
            default => null,
        };
    }
}
