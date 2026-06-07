<?php
/**
 * Service Directory Bootstrap Script
 * This script creates the app/Services/Denah directory structure and files
 */

// Determine base path
$basePath = dirname(__FILE__);
$appPath = $basePath . DIRECTORY_SEPARATOR . 'app';
$servicesPath = $appPath . DIRECTORY_SEPARATOR . 'Services';
$denahPath = $servicesPath . DIRECTORY_SEPARATOR . 'Denah';

// Create directory structure
echo "Creating directory structure...\n";
if (!is_dir($denahPath)) {
    if (mkdir($denahPath, 0755, true)) {
        echo "✓ Directory created: app/Services/Denah\n";
    } else {
        echo "✗ Failed to create directory\n";
        exit(1);
    }
} else {
    echo "✓ Directory already exists: app/Services/Denah\n";
}

// Create RoutingService.php
echo "Creating RoutingService.php...\n";
$routingServicePath = $denahPath . DIRECTORY_SEPARATOR . 'RoutingService.php';
$routingServiceContent = <<<'EOF'
<?php

namespace App\Services\Denah;

use Illuminate\Support\Collection;

/**
 * RoutingService - Implementasi Dijkstra Algorithm
 * Service untuk menghitung rute terpendek antar dua node dalam denah
 */
class RoutingService
{
    /**
     * Hitung jarak Euclidean antar dua koordinat
     */
    private function calculateDistance(array $nodeA, array $nodeB): float
    {
        $dx = $nodeA['x'] - $nodeB['x'];
        $dy = $nodeA['y'] - $nodeB['y'];
        return sqrt($dx * $dx + $dy * $dy);
    }

    /**
     * Build adjacency list dari nodes dan edges
     */
    private function buildAdjacencyList(array $nodes, array $edges): array
    {
        $adjacencyList = [];
        
        foreach ($nodes as $nodeId => $node) {
            $adjacencyList[$nodeId] = [];
        }

        foreach ($edges as $edge) {
            $fromId = $edge['from'];
            $toId = $edge['to'];

            if (isset($nodes[$fromId]) && isset($nodes[$toId])) {
                $weight = $edge['weight'] ?? $this->calculateDistance($nodes[$fromId], $nodes[$toId]);

                $adjacencyList[$fromId][] = [
                    'id' => $toId,
                    'weight' => $weight
                ];
                $adjacencyList[$toId][] = [
                    'id' => $fromId,
                    'weight' => $weight
                ];
            }
        }

        return $adjacencyList;
    }

    /**
     * Cari node dengan jarak minimum dari queue
     */
    private function findMinDistanceNode(array &$distances, array $queue): ?string
    {
        $minDistance = PHP_FLOAT_MAX;
        $minNodeId = null;

        foreach ($queue as $nodeId) {
            if ($distances[$nodeId] < $minDistance) {
                $minDistance = $distances[$nodeId];
                $minNodeId = $nodeId;
            }
        }

        return $minNodeId;
    }

    /**
     * Rekonstruksi path dari previous nodes mapping
     */
    private function reconstructPath(array $prevNodes, string $endNodeId, string $startNodeId): array
    {
        $path = [];
        $current = $endNodeId;

        if ($prevNodes[$current] !== null || $current === $startNodeId) {
            while ($current !== null) {
                array_unshift($path, $current);
                $current = $prevNodes[$current];
            }
        }

        return $path;
    }

    /**
     * Hitung rute terpendek menggunakan Dijkstra Algorithm
     */
    public function findShortestPath(array $nodes, array $edges, string $startNodeId, string $endNodeId): array
    {
        if (!isset($nodes[$startNodeId]) || !isset($nodes[$endNodeId])) {
            return [];
        }

        $distances = [];
        $prevNodes = [];
        $queue = [];

        foreach ($nodes as $nodeId => $node) {
            $distances[$nodeId] = PHP_FLOAT_MAX;
            $prevNodes[$nodeId] = null;
            $queue[] = $nodeId;
        }
        $distances[$startNodeId] = 0;

        $adjacencyList = $this->buildAdjacencyList($nodes, $edges);

        while (!empty($queue)) {
            $currentNodeId = $this->findMinDistanceNode($distances, $queue);

            if ($currentNodeId === null) {
                break;
            }

            if ($currentNodeId === $endNodeId) {
                break;
            }

            $queue = array_values(array_filter($queue, fn($n) => $n !== $currentNodeId));

            $neighbors = $adjacencyList[$currentNodeId] ?? [];
            foreach ($neighbors as $neighbor) {
                if (in_array($neighbor['id'], $queue)) {
                    $altDistance = $distances[$currentNodeId] + $neighbor['weight'];
                    if ($altDistance < $distances[$neighbor['id']]) {
                        $distances[$neighbor['id']] = $altDistance;
                        $prevNodes[$neighbor['id']] = $currentNodeId;
                    }
                }
            }
        }

        return $this->reconstructPath($prevNodes, $endNodeId, $startNodeId);
    }

    /**
     * Hitung rute dan kembalikan dengan koordinat lengkap
     */
    public function findPathWithCoordinates(array $nodes, array $edges, string $startNodeId, string $endNodeId): array
    {
        $pathNodeIds = $this->findShortestPath($nodes, $edges, $startNodeId, $endNodeId);

        return array_map(function ($nodeId) use ($nodes) {
            return array_merge(
                ['id' => $nodeId],
                $nodes[$nodeId]
            );
        }, $pathNodeIds);
    }

    /**
     * Hitung total jarak dari route
     */
    public function calculateRouteDistance(array $nodes, array $edges, string $startNodeId, string $endNodeId): float
    {
        $path = $this->findShortestPath($nodes, $edges, $startNodeId, $endNodeId);
        
        if (count($path) < 2) {
            return 0;
        }

        $distance = 0;
        for ($i = 0; $i < count($path) - 1; $i++) {
            $distance += $this->calculateDistance($nodes[$path[$i]], $nodes[$path[$i + 1]]);
        }

        return $distance;
    }
}
EOF;

if (file_put_contents($routingServicePath, $routingServiceContent)) {
    echo "✓ RoutingService.php created successfully\n";
} else {
    echo "✗ Failed to create RoutingService.php\n";
    exit(1);
}

echo "\n========================================\n";
echo "Setup completed successfully!\n";
echo "Directory: app/Services/Denah\n";
echo "File created: RoutingService.php\n";
echo "Next: Create DenahService.php when ready\n";
echo "========================================\n";
?>
