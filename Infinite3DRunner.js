var sceneHeight;
var camera;
var scene;
var renderer;
var dom;
var sun;
var ground;
//var orbitControl;
var rollingGroundSphere;
var heroSphere;
var rollingSpeed=0.008;
var heroRollingSpeed;
var worldRadius=26;
var heroRadius=0.2;
var sphericalHelper;
var pathAngleValues;
var heroBaseY=1.8;
var bounceValue=0.1;
var gravity=0.005;
var leftLane=-1;
var rightLane=1;
var middleLane=0;
var currentLane;
var clock;
var jumping;
var treeReleaseInterval=0.5;
var lastTreeReleaseTime=0;
var treesInPath;
var treesPool;
var particleGeometry;
var particleCount=20;
var explosionPower =1.06;
var particles;
//var stats;
var scoreText;
var score;
var hasCollided;

init();

function init() {
	// set up the scene
	createScene();

	//call game loop
	update();
}

function createScene(){
	hasCollided=false;
	score=0;
	treesInPath=[];
	treesPool=[];
	clock=new THREE.Clock();
	clock.start();
	heroRollingSpeed=(rollingSpeed*worldRadius/heroRadius)/5;
	sphericalHelper = new THREE.Spherical();
	pathAngleValues=[1.52,1.57,1.62];
    sceneWidth=window.innerWidth;
    sceneHeight=window.innerHeight;
    scene = new THREE.Scene();//the 3d scene
    scene.fog = new THREE.FogExp2( 0xf0fff0, 0.14 );
    camera = new THREE.PerspectiveCamera( 60, sceneWidth / sceneHeight, 0.1, 1000 );//perspective camera
    renderer = new THREE.WebGLRenderer({alpha:true});//renderer with transparent backdrop
    renderer.setClearColor(0xfffafa, 1); 
    renderer.shadowMap.enabled = true;//enable shadow
    renderer.shadowMap.type = THREE.PCFSoftShadowMap;
    renderer.setSize( sceneWidth, sceneHeight );
    dom = document.getElementById('TutContainer');
	dom.appendChild(renderer.domElement);
	//stats = new Stats();
	//dom.appendChild(stats.dom);
	createTreesPool();
	addWorld();
	addHero();
	addLight();
	addExplosion();
	
	camera.position.z = 6.5;
	camera.position.y = 2.5;
	/*orbitControl = new THREE.OrbitControls( camera, renderer.domElement );//helper to rotate around in scene
	orbitControl.addEventListener( 'change', render );
	orbitControl.noKeys = true;
	orbitControl.noPan = true;
	orbitControl.enableZoom = false;
	orbitControl.minPolarAngle = 1.1;
	orbitControl.maxPolarAngle = 1.1;
	orbitControl.minAzimuthAngle = -0.2;
	orbitControl.maxAzimuthAngle = 0.2;
	*/
	window.addEventListener('resize', onWindowResize, false);//resize callback

	document.onkeydown = handleKeyDown;
	
	scoreText = document.createElement('div');
	scoreText.style.position = 'absolute';
	//text2.style.zIndex = 1;    // if you still don't see the label, try uncommenting this
	scoreText.style.width = 100;
	scoreText.style.height = 100;
	//scoreText.style.backgroundColor = "blue";
	scoreText.innerHTML = "0";
	scoreText.style.top = 50 + 'px';
	scoreText.style.left = 10 + 'px';
	document.body.appendChild(scoreText);
  
  var infoText = document.createElement('div');
	infoText.style.position = 'absolute';
	infoText.style.width = 100;
	infoText.style.height = 100;
	infoText.style.backgroundColor = "yellow";
	infoText.innerHTML = "UP - Jump, Left/Right - Move";
	infoText.style.top = 10 + 'px';
	infoText.style.left = 10 + 'px';
	document.body.appendChild(infoText);
}
function addExplosion(){
	particleGeometry = new THREE.Geometry();
	for (var i = 0; i < particleCount; i ++ ) {
		var vertex = new THREE.Vector3();
		particleGeometry.vertices.push( vertex );
	}
	var pMaterial = new THREE.ParticleBasicMaterial({
	  color: 0xfffafa,
	  size: 0.2
	});
	particles = new THREE.Points( particleGeometry, pMaterial );
	scene.add( particles );
	particles.visible=false;
}
function createTreesPool(){
	var maxTreesInPool=10;
	var newTree;
	for(var i=0; i<maxTreesInPool;i++){
		newTree=createTree();
		treesPool.push(newTree);
	}
}
function handleKeyDown(keyEvent){
	if(jumping)return;
	var validMove=true;
	if ( keyEvent.keyCode === 37) {//left
		if(currentLane==middleLane){
			currentLane=leftLane;
		}else if(currentLane==rightLane){
			currentLane=middleLane;
		}else{
			validMove=false;	
		}
	} else if ( keyEvent.keyCode === 39) {//right
		if(currentLane==middleLane){
			currentLane=rightLane;
		}else if(currentLane==leftLane){
			currentLane=middleLane;
		}else{
			validMove=false;	
		}
	}else{
		if ( keyEvent.keyCode === 38){//up, jump
			bounceValue=0.1;
			jumping=true;
		}
		validMove=false;
	}
	//heroSphere.position.x=currentLane;
	if(validMove){
		jumping=true;
		bounceValue=0.06;
	}
}
function addHero(){
	var sphereGeometry = new THREE.DodecahedronGeometry( heroRadius, 1);
	var sphereMaterial = new THREE.MeshStandardMaterial( { color: 0xe5f2f2 ,shading:THREE.FlatShading} )
	jumping=false;
	heroSphere = new THREE.Mesh( sphereGeometry, sphereMaterial );
	heroSphere.receiveShadow = true;
	heroSphere.castShadow=true;
	scene.add( heroSphere );
	heroSphere.position.y=heroBaseY;
	heroSphere.position.z=4.8;
	currentLane=middleLane;
	heroSphere.position.x=currentLane;
}
function addWorld(){
	var sides=40;
	var tiers=40;
	var sphereGeometry = new THREE.SphereGeometry( worldRadius, sides,tiers);
	var sphereMaterial = new THREE.MeshStandardMaterial( { color: 0xfffafa ,shading:THREE.FlatShading} )
	
	var vertexIndex;
	var vertexVector= new THREE.Vector3();
	var nextVertexVector= new THREE.Vector3();
	var firstVertexVector= new THREE.Vector3();
	var offset= new THREE.Vector3();
	var currentTier=1;
	var lerpValue=0.5;
	var heightValue;
	var maxHeight=0.07;
	for(var j=1;j<tiers-2;j++){
		currentTier=j;
		for(var i=0;i<sides;i++){
			vertexIndex=(currentTier*sides)+1;
			vertexVector=sphereGeometry.vertices[i+vertexIndex].clone();
			if(j%2!==0){
				if(i==0){
					firstVertexVector=vertexVector.clone();
				}
				nextVertexVector=sphereGeometry.vertices[i+vertexIndex+1].clone();
				if(i==sides-1){
					nextVertexVector=firstVertexVector;
				}
				lerpValue=(Math.random()*(0.75-0.25))+0.25;
				vertexVector.lerp(nextVertexVector,lerpValue);
			}
			heightValue=(Math.random()*maxHeight)-(maxHeight/2);
			offset=vertexVector.clone().normalize().multiplyScalar(heightValue);
			sphereGeometry.vertices[i+vertexIndex]=(vertexVector.add(offset));
		}
	}
	rollingGroundSphere = new THREE.Mesh( sphereGeometry, sphereMaterial );
	rollingGroundSphere.receiveShadow = true;
	rollingGroundSphere.castShadow=false;
	rollingGroundSphere.rotation.z=-Math.PI/2;
	scene.add( rollingGroundSphere );
	rollingGroundSphere.position.y=-24;
	rollingGroundSphere.position.z=2;
	addWorldTrees();
}
function addLight(){
	var hemisphereLight = new THREE.HemisphereLight(0xfffafa,0x000000, .9)
	scene.add(hemisphereLight);
	sun = new THREE.DirectionalLight( 0xcdc1c5, 0.9);
	sun.position.set( 12,6,-7 );
	sun.castShadow = true;
	scene.add(sun);
	//Set up shadow properties for the sun light
	sun.shadow.mapSize.width = 256;
	sun.shadow.mapSize.height = 256;
	sun.shadow.camera.near = 0.5;
	sun.shadow.camera.far = 50 ;
}


