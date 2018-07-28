var gameScreen;
var output;

var bullets;

var ship;
var enemies = new Array();

var gameTimer;
var resetButton;

var blueOrb;
var currentCount = 0;
var autofireCount = 0;
var autofire = false;

var leftArrowDown = false;
var rightArrowDown = false;

const BG_SPEED = 4;

const GS_WIDTH = 800;
const GS_HEIGHT = 600;

$(document).on('keypress', function(event){
    if(event.which == 32) fire();
});

$(document).on('keyup', function(event){
    if(event.keyCode==37) leftArrowDown = false;
	if(event.keyCode==39) rightArrowDown = false;
});

$(document).on('keydown', function(event){
    if(event.keyCode==37) leftArrowDown = true;
	if(event.keyCode==39) rightArrowDown = true;
});

$(document).ready(function() {
    gameScreen = document.getElementById('gameScreen');
	gameScreen.style.width = GS_WIDTH + 'px';
	gameScreen.style.height = GS_HEIGHT + 'px';
	
	$('<img />').attr({
	    'class': 'gameObject',
	    'id': 'bg1',
	    'src': 'bg.jpg',
	}).appendTo($('#gameScreen'));
	
	$('#bg1').css({
	    'width':800,
	    'height':1422,
	    'left': 0,
	    'top': 0
	});
	
	$('<img />').attr({
	    'class': 'gameObject',
	    'id': 'bg2',
	    'src': 'bg.jpg',
	}).appendTo($('#gameScreen'));
	
	$('#bg2').css({
	    'width':800,
	    'height':1422,
	    'left': 0,
	    'top': -1422
	});
	
	bullets = $('<div />');
    bullets.attr('class', 'gameObject');
    bullets.css({
        'width': parseInt(gameScreen.style.width),
        'height': parseInt(gameScreen.style.height),
        'left': 0,
    });
    bullets.appendTo($('#gameScreen'));
    
    resetButton = $('<button />'). attr({
	    'id': 'reset',
	    'class': 'gameObject',
	    'src': 'bg.jpg'
	});
	
	resetButton.css({
	    'width': 150,
	    'height': 65,
	    'top': 275,
	    'left': 360,
	    'color': 'white',
	    'background-color': 'red',
	    'opacity': 0.5,
	    'display': 'none'
	});
	
	resetButton.append(document.createTextNode("Play Again"));
	resetButton.appendTo($('#gameScreen'));
	
	$("#reset").on('click', function() {
	    location.reload();
	    $("#reset").hide();
	});
    
    output = document.getElementById('output');

	ship = document.createElement('IMG');
	ship.src = 'ship.gif';
	ship.className = 'gameObject';
	ship.style.width = '68px';
	ship.style.height = '68px';
	ship.style.top = '500px';
	ship.style.left = '366px';

	gameScreen.appendChild(ship);
	
	for(var i=0; i<10; i++){
		var enemy = new Image();
		enemy.className = 'gameObject';
		enemy.style.width = '64px';
		enemy.style.height = '64px';
		enemy.src = 'enemyShip.gif';
		gameScreen.appendChild(enemy);
		placeEnemyShip(enemy);
		enemies[i] = enemy;
	}
	
	blueOrb = document.createElement('IMG');
	blueOrb.src = 'blueOrb.png';
	blueOrb.className = 'gameObject';
	blueOrb.style.width = '64px';
	blueOrb.style.height = '64px';
	gameScreen.appendChild(blueOrb);
	placeBlueOrb(blueOrb);

	gameTimer = setInterval(gameloop, 50);
    
});

function gameloop(){
	currentCount++;
	var bgY = parseInt($('#bg1').css('top')) + BG_SPEED;
	if( bgY > GS_HEIGHT){
		$('#bg1').css('top', (-1 * parseInt($('#bg1').css('height'))));
	}
	else $('#bg1').css('top', bgY);
	
	bgY = parseInt($('#bg2').css('top')) + BG_SPEED;
	if( bgY > GS_HEIGHT){
		$('#bg2').css('top', (-1 * parseInt($('#bg2').css('height'))));
	}
	else $('#bg2').css('top', bgY);

	if(leftArrowDown){
		var newX = parseInt(ship.style.left);
		if(newX > 0) ship.style.left = newX - 20 + 'px';
		else ship.style.left = '0px';
	}

	if(rightArrowDown){
		var newX = parseInt(ship.style.left);
		var maxX = GS_WIDTH - parseInt(ship.style.width);
		if(newX <  maxX) ship.style.left = newX + 20 + 'px';
		else ship.style.left = maxX + 'px';
	}
	
	var b = bullets.children();
	for(var i=0; i<b.length; i++){
		var newY = parseInt(b[i].style.top) - b[i].speed;
		if(newY < 0) bullets.find(b[i]).remove();
		else {
			b[i].style.top = newY + 'px';
			for(var j=0; j<enemies.length; j++) {
				if(hittest(b[i], enemies[j])){
					bullets.find(b[i]).remove();
					explode(enemies[j]);
					placeEnemyShip(enemies[j]);
					break;
				}
			}
		}
	}
	//output.innerHTML = b.length;
	
	for(var i=0; i<enemies.length; i++){
		var newY = parseInt(enemies[i].style.top);
		if(newY > GS_HEIGHT) placeEnemyShip(enemies[i]);
		else enemies[i].style.top = newY + enemies[i].speed + 'px';
		
		if( hittest(enemies[i], ship)){
			explode(ship);
			explode(enemies[i]);
			ship.style.top = '-10000px';
			placeEnemyShip(enemies[i]);
			$('#reset').show();
			bulletSound['muted'] = true;
		}
	}
	
	var blueOrbY = parseInt(blueOrb.style.top);
	if (blueOrbY > GS_HEIGHT) {
	    placeBlueOrb(blueOrb);
	} else {
	    blueOrb.style.top = blueOrbY + blueOrb.speed + 'px';
	}
	
	if (hittest(ship,blueOrb)) {
	    placeBlueOrb(blueOrb);
	    autofire = true;
	    powerUpSound['volume'] = 0.8;
        powerUpSound['currentTime'] = 0;
        powerUpSound['play']();
	}
	
	if (autofire == true) {
	    
	    if(currentCount % 2 == 0) {
	        fire();
	        autofireCount++;
	    }
	    
	    if(autofireCount >= 80) {
	        autofire = false;
	        autofireCount = 0;
	        powerDownSound['volume'] = 0.3;
            powerDownSound['currentTime'] = 0;
            powerDownSound['play']();
	    }
	}
}

function fire() {
	var bulletWidth = 4;
	var bulletHeight = 10;
	var bullet = document.createElement('DIV');
	bullet.className = 'gameObject';
	bullet.style.backgroundColor = 'yellow';
	bullet.style.width = bulletWidth;
	bullet.style.height = bulletHeight;
	bullet.speed = 20;
	bullet.style.top = parseInt(ship.style.top) - bulletHeight + 'px';
	var shipX = parseInt(ship.style.left) + parseInt(ship.style.width)/2;
	bullet.style.left = (shipX - bulletWidth/2) + 'px';
	bullets.append(bullet);
	
	if(autofire == true) {
	    bullet.style.backgroundColor = '#47d147';
	}
	bulletSound['volume'] = 0.15;
    bulletSound['currentTime'] = 0;
    bulletSound['play']();
}

function placeEnemyShip(e){
	e.speed = Math.floor(Math.random() * 10) + 6;
	
	var maxX = GS_WIDTH - parseInt(e.style.width);
	var newX = Math.floor(Math.random() * maxX);
	e.style.left = newX + 'px';
	
	var newY = Math.floor(Math.random()*600) - 1000;
	e.style.top = newY + 'px';
}

function placeBlueOrb(blueOrb) {
    blueOrb.speed = Math.floor(Math.random() * 12) + 10;
    
    var maxX = GS_WIDTH - parseInt(blueOrb.style.width);
    var newX = Math.floor(Math.random() * maxX);
    blueOrb.style.left = newX + 'px';
    
    var newY = Math.floor(Math.random() * 600) - 8000;
    blueOrb.style.top = newY + 'px';
}

function hittest(a,b){
	var aW = parseInt(a.style.width);
	var aH = parseInt(a.style.height);
	
	var aX = parseInt(a.style.left) + aW/2;
	var aY = parseInt(a.style.top) + aH/2;
	
	var aR = (aW + aH) / 4;
	
	var bW = parseInt(b.style.width);
	var bH = parseInt(b.style.height);
	
	var bX = parseInt(b.style.left) + bW/2;
	var bY = parseInt(b.style.top) + bH/2;
	
	var bR = (bW + bH) / 4;
	
	var minDistance = aR + bR;
	
	var cXs = (aX-bX)* (aX-bX);
	var cYs = (aY-bY)* (aY-bY);
	var distance = Math.sqrt(cXs + cYs);
	
	if (distance < minDistance) return true;
	else return false;
}

function explode(obj){
	var explosion = document.createElement('IMG');
	explosion.src = 'explosion.gif?x=' + Date.now();
	explosion.className = 'gameObject';
	explosion.style.width = obj.style.width;
	explosion.style.height = obj.style.height;
	explosion.style.left = obj.style.left;
	explosion.style.top = obj.style.top;
	gameScreen.appendChild(explosion);
	explosionSound['volume'] = 0.1;
    explosionSound['currentTime'] = 0;
    explosionSound['play']();
}
