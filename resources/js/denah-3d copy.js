/**
 * Denah 3D Navigation System
 * Interactive 3D marketplace navigation using Three.js
 */

import * as THREE from 'three';
import { OrbitControls } from 'three/addons/controls/OrbitControls.js';
import { SVGLoader } from 'three/addons/loaders/SVGLoader.js';
import { GLTFLoader } from 'three/addons/loaders/GLTFLoader.js';

/* ──────────────────────────────────────────────────────────
   SCENE SETUP
   ────────────────────────────────────────────────────────── */

const canvas = document.querySelector('#gameCanvas');
const scene = new THREE.Scene();
scene.background = new THREE.Color(0x1a1a1a);

const camera = new THREE.PerspectiveCamera(
    60,
    window.innerWidth / window.innerHeight,
    0.1,
    5000
);

const renderer = new THREE.WebGLRenderer({ canvas, antialias: true });
renderer.setSize(window.innerWidth, window.innerHeight);
renderer.shadowMap.enabled = true;

/* ──────────────────────────────────────────────────────────
   GLOBAL STATE
   ────────────────────────────────────────────────────────── */

const walls = [];
const loader = new SVGLoader();
const raycaster = new THREE.Raycaster();

/* ──────────────────────────────────────────────────────────
   LIGHTING SETUP
   ────────────────────────────────────────────────────────── */

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
   FLOOR SETUP
   ────────────────────────────────────────────────────────── */

const floorGeo = new THREE.PlaneGeometry(2000, 2000);
const floorMat = new THREE.MeshStandardMaterial({ color: 0x3e3e42, roughness: 0.8 });
const floor = new THREE.Mesh(floorGeo, floorMat);
floor.rotation.x = -Math.PI / 2;
floor.receiveShadow = true;
scene.add(floor);

/* ──────────────────────────────────────────────────────────
   PLAYER / CHARACTER SETUP
   ────────────────────────────────────────────────────────── */

const PLAYER_RADIUS = 4;
const PLAYER_HEIGHT = 12;
const MOVE_SPEED = 1.25;

let player = new THREE.Group();
player.position.set(50, 0, 50);
scene.add(player);

let mixer;
let animations = {};

const gltfLoader = new GLTFLoader();
gltfLoader.load(
    '/assets/Creeper/Creeper.gltf',
    (gltf) => {
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

        if (animations['idle']) {
            animations['idle'].play();
        }
    },
    undefined,
    (error) => {
        console.warn('Character model failed to load:', error);
    }
);

/* ──────────────────────────────────────────────────────────
   CAMERA CONTROLS
   ────────────────────────────────────────────────────────── */

const controls = new OrbitControls(camera, renderer.domElement);
controls.enableDamping = true;
controls.dampingFactor = 0.05;
controls.maxPolarAngle = Math.PI / 2 - 0.05;
controls.minDistance = 20;
controls.maxDistance = 60;

/* ──────────────────────────────────────────────────────────
   PLAYER POSITIONING
   ────────────────────────────────────────────────────────── */

/**
 * Position player at SVG coordinate
 * @param {number} xLokalSVG - X coordinate from SVG
 * @param {number} yLokalSVG - Y coordinate from SVG
 */
function positionPlayerAtLocation(xLokalSVG, yLokalSVG) {
    const posisiX3D = xLokalSVG - 500;
    const posisiZ3D = yLokalSVG - 250;

    player.position.set(posisiX3D, 5, posisiZ3D);

    // Reset camera to focus on player
    camera.position.set(posisiX3D, 200, posisiZ3D + 250);
    controls.target.copy(player.position);
    controls.update();
}

/* ──────────────────────────────────────────────────────────
   MARKETPLACE BUILDING FROM SVG
   ────────────────────────────────────────────────────────── */

/**
 * Parse wall color from SVG style
 * @param {Object} path - SVG path object
 * @returns {string} Wall color or default
 */
function getWallColor(path) {
    let color = path.userData.style.fill;

    if (color === 'none' || color === undefined) {
        color = path.userData.style.stroke;
    }

    if (color === undefined || color === 'none') {
        return null;
    }

    return color.toLowerCase();
}

/**
 * Check if SVG element is marked as exit
 * @param {Object} path - SVG path object
 * @returns {boolean}
 */
function isExitElement(path) {
    let currentNode = path.userData.node;

    while (currentNode) {
        if (
            currentNode.id &&
            (currentNode.id.toLowerCase().includes('exit') ||
             currentNode.id.toLowerCase().includes('emergency'))
        ) {
            return true;
        }
        currentNode = currentNode.parentElement;
    }

    return false;
}

/**
 * Identify if color represents a walkable path
 * @param {string} color - Wall color hex
 * @returns {boolean}
 */
function isWalkablePath(color) {
    const walkableColors = [
        '#ffffff',
        'white',
        '#e0e0e0',
        '#cccccc',
        '#e5e5e5',
        '#f2f2f2'
    ];
    return walkableColors.includes(color);
}

/**
 * Build 3D marketplace from SVG denah
 * @param {string} svgUrl - Path to SVG file
 */
function buildLabyrinth(svgUrl) {
    // Clear old walls
    walls.forEach((wall) => scene.remove(wall));
    walls.length = 0;

    loader.load(svgUrl, (data) => {
        const paths = data.paths;

        paths.forEach((path) => {
            const wallColor = getWallColor(path);
            if (!wallColor) return;

            const isExit = isExitElement(path);
            const isJalan = isWalkablePath(wallColor);
            const shapes = SVGLoader.createShapes(path);

            shapes.forEach((shape) => {
                // Pathways are thin (0.2), buildings are tall (10)
                const height = (isJalan || isExit) ? 0.2 : 10;

                const extrudeSettings = {
                    depth: height,
                    bevelEnabled: false,
                    caps: true
                };

                const geometry = new THREE.ExtrudeGeometry(shape, extrudeSettings);

                const wallMat = new THREE.MeshStandardMaterial({
                    color: new THREE.Color(wallColor),
                    roughness: 0.6,
                    side: THREE.DoubleSide
                });

                const mesh = new THREE.Mesh(geometry, wallMat);
                mesh.rotation.x = Math.PI / 2;
                mesh.position.set(-500, height, -250);
                mesh.castShadow = !(isJalan || isExit);
                mesh.receiveShadow = true;

                scene.add(mesh);

                // Tenant collision detection
                if (!isJalan && !isExit) {
                    mesh.userData = {
                        isTenant: true,
                        id: `TNT-${Math.floor(Math.random() * 100).toString().padStart(3, '0')}`,
                        nama: 'Kios Pasar Mandiri',
                        kategori: 'Sembako / Sayur'
                    };
                    walls.push(mesh);
                }
            });
        });

        // Get starting position from config
        const spawnX = window.START_X || 150;
        const spawnY = window.START_Y || 400;

        taruhKarakter(spawnX, spawnY);

        // (Opsional) Kamu juga bisa memunculkan nama toko tujuan di console untuk memastikan
        console.log("Mulai Navigasi menuju:", window.TARGET_LAPAK);
        const config = window.navigationConfig || { startX: 0, startY: 0 };
        positionPlayerAtLocation(config.startX, config.startY);
    });
}

// Load marketplace
buildLabyrinth('assets/map/denah.svg');

/* ──────────────────────────────────────────────────────────
   PLAYER MOVEMENT
   ────────────────────────────────────────────────────────── */

const keys = { w: false, a: false, s: false, d: false };

window.addEventListener('keydown', (e) => {
    if (keys.hasOwnProperty(e.key.toLowerCase())) {
        keys[e.key.toLowerCase()] = true;
    }
});

window.addEventListener('keyup', (e) => {
    if (keys.hasOwnProperty(e.key.toLowerCase())) {
        keys[e.key.toLowerCase()] = false;
    }
});

/**
 * Update player position based on input
 */
function movePlayer() {
    const camDirection = new THREE.Vector3();
    camera.getWorldDirection(camDirection);
    camDirection.y = 0;
    camDirection.normalize();

    const camRight = new THREE.Vector3();
    camRight.crossVectors(camDirection, camera.up).normalize();

    let moveDirection = new THREE.Vector3();

    if (keys.w) moveDirection.add(camDirection);
    if (keys.s) moveDirection.add(camDirection.clone().negate());
    if (keys.d) moveDirection.add(camRight);
    if (keys.a) moveDirection.add(camRight.clone().negate());

    if (moveDirection.lengthSq() > 0) {
        moveDirection.normalize();

        const rayOrigin = player.position.clone();
        rayOrigin.y = PLAYER_HEIGHT / 2;

        raycaster.set(rayOrigin, moveDirection);
        const intersections = raycaster.intersectObjects(walls, true);
        const safeDistance = PLAYER_RADIUS + 2;

        if (intersections.length > 0 && intersections[0].distance < safeDistance) {
            return; // Blocked by wall
        }

        player.position.add(moveDirection.multiplyScalar(MOVE_SPEED));

        const targetAngle = Math.atan2(moveDirection.x, moveDirection.z);
        player.rotation.y = targetAngle;
    }
}

// --- 10. SISTEM HOVER TENANT (MOUSE RAYCASTING) ---
const mouse = new THREE.Vector2();
const mouseRaycaster = new THREE.Raycaster();
const tenantCard = document.getElementById('tenant-card');
const closeBtn = document.getElementById('close-card');

closeBtn.addEventListener('click', () => {
    tenantCard.style.display = 'none';
});

// Gunakan 'pointerdown' agar mendukung Mouse PC dan Touchscreen HP
window.addEventListener('pointerdown', (event) => {
    // 1. Jika pengguna mengklik UI (Card/Tombol), jangan jalankan deteksi 3D
    if (event.target.closest('#tenant-card') || event.target.closest('#ui')) return;

    // 2. Normalisasi koordinat layar
    mouse.x = (event.clientX / window.innerWidth) * 2 - 1;
    mouse.y = -(event.clientY / window.innerHeight) * 2 + 1;

    // 3. Tembakkan sinar ke dunia 3D
    mouseRaycaster.setFromCamera(mouse, camera);
    const intersects = mouseRaycaster.intersectObjects(walls, false);

    if (intersects.length > 0 && intersects[0].object.userData.isTenant) {
        const objekTersorot = intersects[0].object;
        
        // Tampilkan card dan perbarui isi teks
        tenantCard.style.display = 'block';
        document.getElementById('t-id').innerText = objekTersorot.userData.id;
        document.getElementById('t-nama').innerText = objekTersorot.userData.nama;
        document.getElementById('t-kategori').innerText = objekTersorot.userData.kategori;
        
    } else {
        // Jika pengguna mengetuk/klik jalan kosong, sembunyikan card
        tenantCard.style.display = 'none';
    }
});

// --- 8. GAME LOOP ---
const clock = new THREE.Clock();

function animate() {
    requestAnimationFrame(animate);
    const delta = clock.getDelta();
    if (mixer) mixer.update(delta);

    movePlayer();
    // checkHover();

    // FIX: Arahkan target kamera ke tinggi badan karakter (bukan kakinya)
    const camTarget = player.position.clone().add(new THREE.Vector3(0, playerHeight, 0));
    controls.target.copy(camTarget);
    controls.update();

    renderer.render(scene, camera);
}

// --- 9. RESPONSIVE WINDOW RESIZE ---
window.addEventListener('resize', () => {
    camera.aspect = window.innerWidth / window.innerHeight;
    camera.updateProjectionMatrix();
    renderer.setSize(window.innerWidth, window.innerHeight);
});

// Jalankan Game
animate();