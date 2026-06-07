<?php

namespace App\Services\Denah;

use App\Models\Denah;
use App\Models\Tenant;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

/**
 * DenahService - Business Logic untuk Denah
 * Menangani data retrieval, caching, dan formatting
 */
class DenahService
{
    private const CACHE_KEY_DENAH = 'denah:all';
    private const CACHE_KEY_TENANTS = 'denah:tenants';
    private const CACHE_KEY_GRAPH = 'denah:graph';
    private const CACHE_TTL = 3600; // 1 hour

    /**
     * Get semua denah dengan tenant relationship
     */
    public function getAllDenah(?bool $useCache = true): Collection
    {
        if ($useCache) {
            return Cache::remember(
                self::CACHE_KEY_DENAH,
                self::CACHE_TTL,
                fn() => $this->fetchAllDenah()
            );
        }

        return $this->fetchAllDenah();
    }

    /**
     * Fetch denah dari database
     */
    private function fetchAllDenah(): Collection
    {
        return Denah::with('tenant')->get();
    }

    /**
     * Get formatted denah data untuk API response
     */
    public function getFormattedDenahList(): array
    {
        $denahList = $this->getAllDenah();

        return $denahList->map(function (Denah $denah) {
            return [
                'denah_id' => $denah->denah_id,
                'blok' => $denah->blok,
                'status' => $denah->status,
                'posisi_x' => $denah->posisi_x,
                'posisi_y' => $denah->posisi_y,
                'tenant_id' => $denah->tenant_id,
                'tenant' => $denah->tenant ? [
                    'tenant_id' => $denah->tenant->tenant_id,
                    'nama' => $denah->tenant->nama_tenant,
                    'kategori' => $denah->tenant->kategori,
                    'deskripsi' => $denah->tenant->deskripsi ?? '',
                    'foto' => $denah->tenant->foto,
                ] : null,
            ];
        })->toArray();
    }

    /**
     * Get tenant data indexed by denah_id untuk frontend
     */
    public function getTenantDataByDenahId(): array
    {
        if (Cache::has(self::CACHE_KEY_TENANTS)) {
            return Cache::get(self::CACHE_KEY_TENANTS);
        }

        $denahList = $this->getAllDenah();
        $tenantData = [];

        foreach ($denahList as $denah) {
            if ($denah->tenant) {
                $tenantData[$denah->denah_id] = [
                    'nama' => $denah->tenant->nama_tenant,
                    'kategori' => $denah->tenant->kategori,
                    'deskripsi' => $denah->tenant->deskripsi ?? '',
                    'foto' => $denah->tenant->foto,
                ];
            }
        }

        Cache::put(self::CACHE_KEY_TENANTS, $tenantData, self::CACHE_TTL);

        return $tenantData;
    }

    /**
     * Extract graph data (nodes & edges) dari denah untuk routing
     * Format yang diharapkan oleh RoutingService
     */
    public function extractGraphData(): array
    {
        return Cache::remember(
            self::CACHE_KEY_GRAPH,
            self::CACHE_TTL,
            fn() => $this->buildGraphData()
        );
    }

    /**
     * Build graph data dari SVG nodes & edges
     * Ini perlu diambil dari SVG atau database jika ada tabel tersendiri
     */
    private function buildGraphData(): array
    {
        // TODO: Implementasi ini perlu baca SVG atau database denah_graph table
        // Untuk sekarang, ini adalah struktur yang diharapkan
        return [
            'nodes' => [],
            'edges' => []
        ];
    }

    /**
     * Get single denah by ID
     */
    public function getDenahById(string $denahId): ?Denah
    {
        return Denah::with('tenant')->find($denahId);
    }

    /**
     * Get denah by tenant ID
     */
    public function getDenahByTenantId(string $tenantId): ?Denah
    {
        return Denah::with('tenant')
            ->where('tenant_id', $tenantId)
            ->first();
    }

    /**
     * Get all denah by blok
     */
    public function getDenahByBlok(string $blok): Collection
    {
        return Denah::with('tenant')
            ->where('blok', $blok)
            ->get();
    }

    /**
     * Search denah by status
     */
    public function searchByStatus(string $status): Collection
    {
        $denahList = $this->getAllDenah();

        return $denahList->filter(function (Denah $denah) use ($status) {
            return $denah->status === $status;
        });
    }

    /**
     * Invalidate cache
     */
    public function invalidateCache(): void
    {
        Cache::forget(self::CACHE_KEY_DENAH);
        Cache::forget(self::CACHE_KEY_TENANTS);
        Cache::forget(self::CACHE_KEY_GRAPH);
    }

    /**
     * Get statistics
     */
    public function getStatistics(): array
    {
        $denahList = $this->getAllDenah();
        $totalSlots = $denahList->count();
        $filledSlots = $denahList->where('status', 'terisi')->count();
        $emptySlots = $totalSlots - $filledSlots;

        return [
            'total_slots' => $totalSlots,
            'filled_slots' => $filledSlots,
            'empty_slots' => $emptySlots,
            'fill_rate' => $totalSlots > 0 ? ($filledSlots / $totalSlots) * 100 : 0,
        ];
    }
}
