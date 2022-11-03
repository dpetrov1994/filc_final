	var animData = {
		wrapper: document.querySelector('#animationWindow'),
		animType: 'svg',
		loop: true,
		prerender: true,
		autoplay: true,
		path: 'data.json'
	};
	var anim = bodymovin.loadAnimation(animData);
anim.setSpeed(3.4);