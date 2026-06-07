/**
 * Denah 3D Navigation System
 * Interactive 3D marketplace navigation using Three.js
 */

import * as THREE from 'three';
import { OrbitControls } from 'three/addons/controls/OrbitControls.js';
import { SVGLoader } from 'three/addons/loaders/SVGLoader.js';
import { GLTFLoader } from 'three/addons/loaders/GLTFLoader.js';
import { findShortestPath } from './dijkstra.js';

/* ──────────────────────────────────────────────────────────
   BACA URL & KALKULASI RUTE
   ────────────────────────────────────────────────────────── */
const urlParams = new URLSearchParams(window.location.search);
const startNodeId = urlParams.get('start') || 'node-KB001';
const targetLapakId = urlParams.get('target') || 'KB001';

// Ambil data graf yang dititipkan dari halaman 2D
const graphDataString = sessionStorage.getItem('graphData');
let graphDataObj = null;
let startX = 100; 
let startY = 600; 
let route3D = []; // Akan diisi rute

// Variabel untuk fitur pelacakan dinamis
let currentRouteMesh = null; 
let lastNearestNodeId = null;
if (graphDataString) {
    graphDataObj = JSON.parse(graphDataString);
    if (graphDataObj.nodes[startNodeId]) {
        startX = graphDataObj.nodes[startNodeId].x;
        startY = graphDataObj.nodes[startNodeId].y;
    }
}

/* ──────────────────────────────────────────────────────────
   SCENE SETUP
   ────────────────────────────────────────────────────────── */

const canvas = document.querySelector('#gameCanvas');
const scene = new THREE.Scene();
scene.background = new THREE.Color(0x1a1a1a);

const camera = new THREE.PerspectiveCamera(60, window.innerWidth / window.innerHeight, 0.1, 5000);

const renderer = new THREE.WebGLRenderer({ canvas, antialias: true });
renderer.setSize(window.innerWidth, window.innerHeight);
renderer.shadowMap.enabled = true;

/* ──────────────────────────────────────────────────────────
   GLOBAL STATE & LIGHTING
   ────────────────────────────────────────────────────────── */

const walls = [];
const loader = new SVGLoader();
const raycaster = new THREE.Raycaster();

const ambientLight = new THREE.AmbientLight(0xffffff, 1.2);
scene.add(ambientLight);

const dirLight = new THREE.DirectionalLight(0xffffff, 1.5);
dirLight.position.set(500, 1000, 500);
dirLight.castShadow = true;
dirLight.shadow.camera.top = 1000;
dirLight.shadow.camera.bottom = -1000;
dirLight.shadow.camera.left = -1000;
dirLight.shadow.camera.right = 1000;
dirLight.shadow.camera.near = 0.1;
dirLight.shadow.camera.far = 2000;
scene.add(dirLight);

/* ──────────────────────────────────────────────────────────
   FLOOR & PLAYER SETUP
   ────────────────────────────────────────────────────────── */

const floorGeo = new THREE.PlaneGeometry(2000, 2000);
const floorMat = new THREE.MeshStandardMaterial({ color: 0x3e3e42, roughness: 0.8 });
const floor = new THREE.Mesh(floorGeo, floorMat);
floor.rotation.x = -Math.PI / 2;
floor.receiveShadow = true;
scene.add(floor);

const PLAYER_RADIUS = 4;
const PLAYER_HEIGHT = 12;
const MOVE_SPEED = 1.25;

let player = new THREE.Group();
scene.add(player);

let mixer;
let animations = {};

const gltfLoader = new GLTFLoader();
// Pastikan path ini benar di dalam folder public Laravel-mu (misal: public/assets/Creeper/...)
gltfLoader.load('/models/creeper/creeper.gltf', (gltf) => {
    const model = gltf.scene;
    model.scale.set(6, 6, 6);
    model.traverse((object) => {
        if (object.isMesh) object.castShadow = true;
    });
    player.add(model);

    mixer = new THREE.AnimationMixer(model);
    gltf.animations.forEach((clip) => {
        animations[clip.name.toLowerCase()] = mixer.clipAction(clip);
    });

    if (animations['idle']) animations['idle'].play();
}, undefined, (error) => console.warn('Character model failed to load:', error));

const controls = new OrbitControls(camera, renderer.domElement);
controls.enableDamping = true;
controls.dampingFactor = 0.05;
controls.maxPolarAngle = Math.PI / 2 - 0.05;
controls.minDistance = 20;
controls.maxDistance = 100;

function resetCameraToPlayer() {
    if (!player) return;

    const camTarget = player.position.clone().add(new THREE.Vector3(0, PLAYER_HEIGHT, 0));
    controls.target.copy(camTarget);
    camera.position.set(
        player.position.x, 
        player.position.y + 40, 
        player.position.z - 40
    );
    
    controls.update();
}

/* ──────────────────────────────────────────────────────────
   FUNGSI MENGGAMBAR GARIS RUTE NAVIGASI
   ────────────────────────────────────────────────────────── */
function drawNavigationPath(routeArray, playerPosition) {
    // 1. Bersihkan rute lama jika ada (agar tidak menumpuk)
    if (currentRouteMesh) {
        scene.remove(currentRouteMesh);
        currentRouteMesh.geometry.dispose();
        currentRouteMesh.material.dispose();
        currentRouteMesh = null;
    }

    if (!routeArray || routeArray.length < 2) return;

    const points = [];
    
    // 2. TEMPELKAN RUTE KE KAKI KARAKTER!
    // Tambahkan posisi karakter saat ini sebagai titik paling awal dari pipa
    if (playerPosition) {
        points.push(new THREE.Vector3(playerPosition.x, 1.5, playerPosition.z));
    }

    // 3. Masukkan titik-titik rute hasil hitungan Dijkstra
    routeArray.forEach(node => {
        const x3D = node.x - 500;
        const z3D = node.y - 250;
        points.push(new THREE.Vector3(x3D, 1.5, z3D));
    });

    const curve = new THREE.CatmullRomCurve3(points, false, 'catmullrom', 0.1);
    const geometry = new THREE.TubeGeometry(curve, points.length * 10, 0.8, 8, false);
    const material = new THREE.MeshBasicMaterial({ 
        color: 0x00aaff, 
        transparent: true, 
        opacity: 0.7 
    });
    
    currentRouteMesh = new THREE.Mesh(geometry, material);
    scene.add(currentRouteMesh);
}

/* ──────────────────────────────────────────────────────────
   MARKETPLACE BUILDING FROM SVG
   ────────────────────────────────────────────────────────── */

function positionPlayerAtLocation(xLokalSVG, yLokalSVG) {
    const posisiX3D = xLokalSVG - 500;
    const posisiZ3D = yLokalSVG - 250;

    player.position.set(posisiX3D, 5, posisiZ3D);
    camera.position.set(posisiX3D, 20, posisiZ3D-20);
    controls.target.copy(player.position);
    controls.update();
}

function buildLabyrinth(svgUrl) {
    walls.forEach((wall) => scene.remove(wall));
    walls.length = 0;

    loader.load(svgUrl, (data) => {
        data.paths.forEach((path) => {
            let wallColor = path.userData.style.fill;
            if (wallColor === 'none' || !wallColor) wallColor = path.userData.style.stroke;
            if (!wallColor || wallColor === 'none') return;
            wallColor = wallColor.toLowerCase();

            let isExit = false;
            let currentNode = path.userData.node;
            while (currentNode) {
                if (currentNode.id && (currentNode.id.toLowerCase().includes('exit') || currentNode.id.toLowerCase().includes('emergency'))) {
                    isExit = true; break;
                }
                currentNode = currentNode.parentElement;
            }

            const walkableColors = ['#ffffff', 'white', '#e0e0e0', '#cccccc', '#e5e5e5', '#f2f2f2'];
            const isJalan = walkableColors.includes(wallColor);
            
            SVGLoader.createShapes(path).forEach((shape) => {
                const height = (isJalan || isExit) ? 0.2 : 20; 

                const geometry = new THREE.ExtrudeGeometry(shape, {
                    depth: height,
                    bevelEnabled: false,
                    caps: true
                });
                
                const wallMat = new THREE.MeshStandardMaterial({
                    color: new THREE.Color(wallColor),
                    roughness: 0.6,
                    side: THREE.DoubleSide // Sisi luar dalam tetap dirender agar padat
                });

                const mesh = new THREE.Mesh(geometry, wallMat);

                mesh.rotation.x = Math.PI / 2;
                const letakY = (isJalan || isExit) ? 0.3 : height;
                mesh.position.set(-500, letakY, -250);

                mesh.castShadow = !(isJalan || isExit);
                mesh.receiveShadow = true;
                scene.add(mesh);

                if (!isJalan && !isExit) {
                    mesh.userData = { isTenant: true, id: 'TNT', nama: 'Kios', kategori: 'Kategori' };
                    walls.push(mesh);
                }
            });
        });
        
        positionPlayerAtLocation(startX, startY);
    });
}

buildLabyrinth('/images/denah.svg'); 
drawNavigationPath(route3D);

/* ──────────────────────────────────────────────────────────
   PLAYER MOVEMENT & GAME LOOP
   ────────────────────────────────────────────────────────── */

const keys = { w: false, a: false, s: false, d: false };

window.addEventListener('keydown', (e) => { if (keys.hasOwnProperty(e.key.toLowerCase())) keys[e.key.toLowerCase()] = true; });
window.addEventListener('keyup', (e) => { if (keys.hasOwnProperty(e.key.toLowerCase())) keys[e.key.toLowerCase()] = false; });

/* ──────────────────────────────────────────────────────────
   ANALOG JOYSTICK CONTROLS (360 DEGREE)
   ────────────────────────────────────────────────────────── */
const joystick = { x: 0, y: 0, active: false };

const zone = document.getElementById('joystickZone');
const base = document.getElementById('joystickBase');
const stick = document.getElementById('joystickStick');

if (zone && base && stick) {
    const maxRadius = 45; // Batas tarikan maksimal joystick (dalam pixel)
    let centerX, centerY, baseRect;

    const updateCenter = () => {
        baseRect = base.getBoundingClientRect();
        centerX = baseRect.left + baseRect.width / 2;
        centerY = baseRect.top + baseRect.height / 2;
    };

    const handleTouch = (e) => {
        e.preventDefault();
        if (!joystick.active) {
            updateCenter();
            stick.style.transition = 'none'; // Matikan animasi saat sedang ditarik
        }
        joystick.active = true;

        const touch = e.targetTouches[0];
        let dx = touch.clientX - centerX;
        let dy = touch.clientY - centerY;

        // Rumus Phytagoras untuk mengetahui jarak tarikan dari titik tengah
        const distance = Math.sqrt(dx * dx + dy * dy);

        // Jika ditarik melebihi lingkaran base, tahan stick di pinggir lingkaran
        if (distance > maxRadius) {
            dx = (dx / distance) * maxRadius;
            dy = (dy / distance) * maxRadius;
        }

        // Pindahkan visual tongkat joystick
        stick.style.transform = `translate(calc(-50% + ${dx}px), calc(-50% + ${dy}px))`;

        // Simpan nilai analog (dari rentang -1.0 hingga 1.0) untuk dipakai oleh karakter
        joystick.x = dx / maxRadius;
        joystick.y = dy / maxRadius;
    };

    const resetJoystick = (e) => {
        e.preventDefault();
        joystick.active = false;
        joystick.x = 0;
        joystick.y = 0;
        stick.style.transition = 'transform 0.2s ease-out';
        stick.style.transform = `translate(-50%, -50%)`; // Kembalikan ke tengah
    };

    zone.addEventListener('touchstart', handleTouch, { passive: false });
    zone.addEventListener('touchmove', handleTouch, { passive: false });
    zone.addEventListener('touchend', resetJoystick, { passive: false });
    zone.addEventListener('touchcancel', resetJoystick, { passive: false });
}

function movePlayer() {
    if (!player) return;

    const camDirection = new THREE.Vector3();
    camera.getWorldDirection(camDirection);
    camDirection.y = 0; camDirection.normalize();

    const camRight = new THREE.Vector3();
    camRight.crossVectors(camDirection, camera.up).normalize();

    let moveDirection = new THREE.Vector3();
    if (keys.w) moveDirection.add(camDirection);
    if (keys.s) moveDirection.add(camDirection.clone().negate());
    if (keys.d) moveDirection.add(camRight);
    if (keys.a) moveDirection.add(camRight.clone().negate());

    if (joystick.active) {
        // Y joystick terbalik dengan koordinat dunia 3D (atas layar = -Y, tapi kita mau karakter maju)
        moveDirection.add(camDirection.clone().multiplyScalar(-joystick.y));
        moveDirection.add(camRight.clone().multiplyScalar(joystick.x));
    }

    if (moveDirection.lengthSq() > 0) {
        moveDirection.normalize();

        let speedMultiplier = 1.0;
        if (joystick.active) {
            speedMultiplier = Math.min(1.0, Math.sqrt(joystick.x * joystick.x + joystick.y * joystick.y));
        }

        const rayOrigin = player.position.clone();
        rayOrigin.y = 1.0;

        raycaster.set(rayOrigin, moveDirection);
        const intersections = raycaster.intersectObjects(walls, true);

        if (intersections.length > 0 && intersections[0].distance < 2.0) return;

        const finalSpeed = (typeof MOVE_SPEED !== 'undefined' ? MOVE_SPEED : 0.5) * speedMultiplier;
        player.position.add(moveDirection.multiplyScalar(finalSpeed));
        player.rotation.y = Math.atan2(moveDirection.x, moveDirection.z);
    }
}

/* ──────────────────────────────────────────────────────────
   FUNGSI PELACAK LOKASI & REROUTE OTOMATIS (GPS)
   ────────────────────────────────────────────────────────── */
function updateDynamicRoute() {
    // Jika tidak ada data graf, karakter belum ada, atau sudah di tujuan, jangan lakukan apa-apa
    if (!graphDataObj || !targetLapakId || !player) return;

    // 1. Konversi posisi 3D karakter kembali ke koordinat SVG 2D
    const playerSvgX = player.position.x + 500;
    const playerSvgY = player.position.z + 250;

    // 2. Cari titik node navigasi (lingkaran SVG) mana yang paling dekat dengan karakter saat ini
    let nearestNodeId = null;
    let minDistance = Infinity;

    for (const nodeId in graphDataObj.nodes) {
        const node = graphDataObj.nodes[nodeId];
        // Menggunakan rumus jarak Phytagoras (tanpa akar agar komputasi lebih ringan)
        const dx = playerSvgX - node.x;
        const dy = playerSvgY - node.y;
        const dist = (dx * dx) + (dy * dy); 

        if (dist < minDistance) {
            minDistance = dist;
            nearestNodeId = nodeId;
        }
    }

    // 3. Jika karakter melewati node baru, hitung ulang rute!
    if (nearestNodeId && nearestNodeId !== lastNearestNodeId) {
        lastNearestNodeId = nearestNodeId;
        const endNodeId = `node-${targetLapakId}`;

        // Jika node terdekat adalah node tujuan, rute dihapus (Tiba di tujuan!)
        if (nearestNodeId === endNodeId) {
            if (currentRouteMesh) {
                scene.remove(currentRouteMesh);
                currentRouteMesh = null;
            }
            return;
        }

        // Jalankan ulang algoritma Dijkstra dari titik terdekat saat ini
        const newRouteArray = findShortestPath(graphDataObj, nearestNodeId, endNodeId) || [];
        
        // Gambar ulang garisnya (dan tempelkan ujungnya ke player.position)
        drawNavigationPath(newRouteArray, player.position);
    }
}

/* ──────────────────────────────────────────────────────────
   DEVICE ORIENTATION (GYROSCOPE / COMPASS TRACKING)
   ────────────────────────────────────────────────────────── */
const btnGyro = document.getElementById('btnGyro');
let isGyroActive = false;

if (btnGyro) {
    btnGyro.addEventListener('click', () => {
        if (isGyroActive) {
            disableGyro();
        } else {
            if (typeof DeviceOrientationEvent !== 'undefined' && typeof DeviceOrientationEvent.requestPermission === 'function') {
                DeviceOrientationEvent.requestPermission().then(state => {
                    if (state === 'granted') toggleGyro(true);
                });
            } else {
                toggleGyro(true);
            }
        }
    });
}

function disableGyro() {
    isGyroActive = false;
    // Mengembalikan tampilan tombol ke mode tidak aktif
    if (btnGyro) {
        btnGyro.classList.remove('active');
        btnGyro.innerText = "🧭";
    }
    
    // Menghapus listener agar browser berhenti membaca data sensor
    window.removeEventListener('deviceorientation', handleGyroEvent, true);
}

let handleGyroEvent = null;
function toggleGyro(state) {
    isGyroActive = state;
    btnGyro.classList.add('active');
    btnGyro.innerText = "✅";

    // Definisikan fungsi handle agar bisa dihapus nantinya
    handleGyroEvent = (event) => {
        if (!isGyroActive || !player) return;
        
        let heading = event.webkitCompassHeading || (360 - event.alpha);
        if (heading !== null) {
            const radian = THREE.MathUtils.degToRad(heading);
            controls.setAzimuthalAngle(radian);
        }
    };

    window.addEventListener('deviceorientation', handleGyroEvent, true);
}

const clock = new THREE.Timer();

function animate() {
    requestAnimationFrame(animate);
    const delta = clock.getDelta();
    if (mixer) mixer.update(delta);

    movePlayer();
    updateDynamicRoute();

    const camTarget = player.position.clone().add(new THREE.Vector3(0, PLAYER_HEIGHT, 0));
    controls.target.copy(camTarget);
    controls.update();

    renderer.render(scene, camera);
}

window.addEventListener('resize', () => {
    camera.aspect = window.innerWidth / window.innerHeight;
    camera.updateProjectionMatrix();
    renderer.setSize(window.innerWidth, window.innerHeight);
});

document.getElementById('btnResetCam').addEventListener('click', () => {
    resetCameraToPlayer();
});

animate();