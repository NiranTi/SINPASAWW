// Variabel untuk menyimpan semua node dari SVG
let graphNodes = [];

// 1. FUNGSI UNTUK MENGAMBIL NODE DARI SVG
function parseSvgNodes() {
    // Ambil semua lingkaran yang ID-nya berawalan "node-"
    const circleNodes = document.querySelectorAll('circle[id^="node-"]');
    
    circleNodes.forEach(circle => {
        // Karena cx/cy di SVG kadang berupa string, kita parse ke float (angka desimal)
        const x = parseFloat(circle.getAttribute('cx'));
        const y = parseFloat(circle.getAttribute('cy'));
        const id = circle.getAttribute('id');
        
        // Tentukan tipe node (apakah jalan biasa atau tujuan/tenant)
        const type = id.startsWith('node-path') ? 'path' : 'destination';
        
        graphNodes.push({
            id: id,
            x: x,
            y: y,
            type: type
        });
    });
}

// 2. FUNGSI MENCARI NODE TERDEKAT (EUCLIDEAN DISTANCE)
function getNearestNode(targetX, targetY) {
    let nearestNode = null;
    let minDistance = Infinity; // Set jarak awal ke tak terhingga

    graphNodes.forEach(node => {
        // Hitung selisih X dan Y
        const dx = node.x - targetX;
        const dy = node.y - targetY;
        
        // Rumus Euclidean Distance: akar dari (dx^2 + dy^2)
        const distance = Math.sqrt((dx * dx) + (dy * dy));

        // Jika jarak node ini lebih kecil dari jarak minimum sebelumnya, simpan!
        if (distance < minDistance) {
            minDistance = distance;
            nearestNode = node;
        }
    });

    return {
        node: nearestNode,
        distance: minDistance
    };
}

document.addEventListener("DOMContentLoaded", () => {
    // Panggil fungsi parse saat web selesai dimuat
    // (Pastikan SVG sudah ter-load sepenuhnya, jika SVG di-load via fetch, panggil ini setelah fetch selesai)
    setTimeout(parseSvgNodes, 500); // Delay sedikit untuk memastikan DOM SVG siap

    const svgElement = document.querySelector('.denah-container svg');
    
    if (svgElement) {
        svgElement.addEventListener('click', (event) => {
            // Dapatkan koordinat klik relatif terhadap ukuran SVG
            const pt = svgElement.createSVGPoint();
            pt.x = event.clientX;
            pt.y = event.clientY;
            
            // Konversi dari koordinat layar (screen) ke koordinat viewBox SVG aslinya
            const svgP = pt.matrixTransform(svgElement.getScreenCTM().inverse());
            
            // Cari node terdekat!
            const result = getNearestNode(svgP.x, svgP.y);
            
            if (result.node) {                
                // Opsional: Beri efek visual, misalnya node terdekat menyala merah sementara
                const nodeEl = document.getElementById(result.node.id);
                if (nodeEl) {
                    const originalFill = nodeEl.getAttribute('fill');
                    nodeEl.setAttribute('fill', 'red');
                    nodeEl.setAttribute('r', '10'); // Perbesar ukuran
                    nodeEl.style.opacity = '1';     // Buat jadi terlihat
                    
                    setTimeout(() => {
                        // Kembalikan ke semula setelah 1 detik
                        nodeEl.setAttribute('fill', originalFill);
                        nodeEl.setAttribute('r', '6.12659'); // Ukuran asli dari file SVG kamu
                        nodeEl.style.opacity = '0'; // Buat transparan lagi
                    }, 1000);
                }
            }
        });
    }
});