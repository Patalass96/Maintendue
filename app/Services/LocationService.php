<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class LocationService
{
    /**
     * Calculer la distance entre deux coordonnées (Haversine formula)
     */
    public function calculateDistance(
        float $lat1,
        float $lon1,
        float $lat2,
        float $lon2,
        string $unit = 'km'
    ): float {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) *
                cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;

        if ($unit === 'km') {
            return $miles * 1.609344;
        }

        return $miles;
    }

    /**
     * Obtenir les coordonnées à partir d'une adresse (géocodage)
     * Utilise OpenStreetMap Nominatim (service gratuit)
     */
    public function geocodeAddress(string $address): ?array
    {
        $client = new Client();

        try {
            $response = $client->get('https://nominatim.openstreetmap.org/search', [
                'query' => [
                    'q' => $address,
                    'format' => 'json',
                    'limit' => 1,
                ]
            ]);

            $data = json_decode($response->getBody(), true);

            if (!empty($data)) {
                return [
                    'latitude' => (float) $data[0]['lat'],
                    'longitude' => (float) $data[0]['lon'],
                    'display_name' => $data[0]['display_name'] ?? null,
                ];
            }
        } catch (\Exception $e) {
            Log::error('Geocoding error: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Obtenir une adresse à partir des coordonnées (géocodage inverse)
     */
    public function reverseGeocode(float $latitude, float $longitude): ?string
    {
        $client = new Client();

        try {
            $response = $client->get('https://nominatim.openstreetmap.org/reverse', [
                'query' => [
                    'lat' => $latitude,
                    'lon' => $longitude,
                    'format' => 'json',
                ]
            ]);

            $data = json_decode($response->getBody(), true);

            return $data['address']['country'] ?? null;
        } catch (\Exception $e) {
            Log::error('Reverse geocoding error: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Valider les coordonnées
     */
    public function isValidCoordinate(float $latitude, float $longitude): bool
    {
        return $latitude >= -90 && $latitude <= 90 &&
               $longitude >= -180 && $longitude <= 180;
    }

    /**
     * Obtenir les coordonnées du centre entre deux points
     */
    public function getCenterPoint(
        float $lat1,
        float $lon1,
        float $lat2,
        float $lon2
    ): array {
        return [
            'latitude' => ($lat1 + $lat2) / 2,
            'longitude' => ($lon1 + $lon2) / 2,
        ];
    }

    /**
     * Obtenir une boîte englobante pour une liste de coordonnées
     */
    public function getBoundingBox(array $coordinates): array
    {
        if (empty($coordinates)) {
            return [];
        }

        $latitudes = array_column($coordinates, 'latitude');
        $longitudes = array_column($coordinates, 'longitude');

        return [
            'min_latitude' => min($latitudes),
            'max_latitude' => max($latitudes),
            'min_longitude' => min($longitudes),
            'max_longitude' => max($longitudes),
        ];
    }

    /**
     * Formater une distance pour l'affichage
     */
    public function formatDistance(float $distance, string $unit = 'km'): string
    {
        if ($unit === 'km') {
            if ($distance < 1) {
                return round($distance * 1000) . ' m';
            }
            return round($distance, 1) . ' km';
        }

        return round($distance, 1) . ' mi';
    }
}
