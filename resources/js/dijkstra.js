/**
 * Dijkstra Algorithm untuk Navigasi
 */

// Hitung jarak Euclidean antar dua koordinat
function calculateDistance(nodeA, nodeB) {
    const dx = nodeA.x - nodeB.x;
    const dy = nodeA.y - nodeB.y;
    return Math.sqrt(dx * dx + dy * dy);
}

// Fungsi Utama
export function findShortestPath(graph, startNodeId, endNodeId) {
    const nodes = graph.nodes;
    const edges = graph.edges;

    // Pastikan titik start dan end ada di dalam data graf
    if (!nodes[startNodeId] || !nodes[endNodeId]) {
        console.error("Titik awal atau tujuan tidak terdaftar di dalam Graf!");
        return null;
    }

    const distances = {};
    const prevNodes = {};
    const queue = new Set();

    // Inisialisasi awal nilai tak terhingga
    for (let nodeId in nodes) {
        distances[nodeId] = Infinity;
        prevNodes[nodeId] = null;
        queue.add(nodeId);
    }
    distances[startNodeId] = 0;

    // Membangun daftar ketetanggaan (Adjacency List) dinamis dari data Edges
    const adjacencyList = {};
    for (let nodeId in nodes) adjacencyList[nodeId] = [];
    
    edges.forEach(edge => {
        if (nodes[edge.from] && nodes[edge.to]) {
            // Karena jalan pasar dua arah, kita buat hubungan timbal balik
            const weight = calculateDistance(nodes[edge.from], nodes[edge.to]);
            adjacencyList[edge.from].push({ id: edge.to, weight: weight });
            adjacencyList[edge.to].push({ id: edge.from, weight: weight });
        }
    });

    // Proses pencarian node terpendek
    while (queue.size > 0) {
        // Cari node di dalam queue yang memiliki jarak terkecil
        let currentNodeId = null;
        let minDistance = Infinity;
        
        for (let nodeId of queue) {
            if (distances[nodeId] < minDistance) {
                minDistance = distances[nodeId];
                currentNodeId = nodeId;
            }
        }

        // Jika tidak ada jalan lagi atau tujuan sudah tercapai, hentikan perulangan
        if (currentNodeId === null || currentNodeId === endNodeId) break;

        queue.delete(currentNodeId);

        // Update jarak ke semua tetangga yang valid
        const neighbors = adjacencyList[currentNodeId] || [];
        neighbors.forEach(neighbor => {
            if (queue.has(neighbor.id)) {
                const altDistance = distances[currentNodeId] + neighbor.weight;
                if (altDistance < distances[neighbor.id]) {
                    distances[neighbor.id] = altDistance;
                    prevNodes[neighbor.id] = currentNodeId;
                }
            }
        });
    }

    // Rekonstruksi array urutan rute jalan dari belakang ke depan
    const path = [];
    let u = endNodeId;
    if (prevNodes[u] !== null || u === startNodeId) {
        while (u !== null) {
            path.unshift(u); // Masukkan ke awal array agar urutannya dari start -> end
            u = prevNodes[u];
        }
    }

    // Mengembalikan koordinat lengkap dari titik-titik rute hasil kalkulasi
    return path.map(nodeId => ({
        id: nodeId,
        x: nodes[nodeId].x,
        y: nodes[nodeId].y,
        type: nodes[nodeId].type
    }));
}

window.findShortestPath = findShortestPath;