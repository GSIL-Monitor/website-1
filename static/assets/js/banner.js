    var displacementSlider = function displacementSlider(opts) {
        var vertex = '\n        varying vec2 vUv;\n        void main() {\n          vUv = uv;\n          gl_Position = projectionMatrix * modelViewMatrix * vec4( position, 1.0 );\n        }\n    ';

        var fragment = '\n        \n        varying vec2 vUv;\n\n        uniform sampler2D currentImage;\n        uniform sampler2D nextImage;\n\n        uniform float dispFactor;\n\n        void main() {\n\n            vec2 uv = vUv;\n            vec4 _currentImage;\n            vec4 _nextImage;\n            float intensity = 0.3;\n\n            vec4 orig1 = texture2D(currentImage, uv);\n            vec4 orig2 = texture2D(nextImage, uv);\n            \n            _currentImage = texture2D(currentImage, vec2(uv.x, uv.y + dispFactor * (orig2 * intensity)));\n\n            _nextImage = texture2D(nextImage, vec2(uv.x, uv.y + (1.0 - dispFactor) * (orig1 * intensity)));\n\n            vec4 finalTexture = mix(_currentImage, _nextImage, dispFactor);\n\n            gl_FragColor = finalTexture;\n\n        }\n    ';

        var images = opts.images,
            image = void 0,
            sliderImages = [];
        //  var canvasWidth = images[0].clientWidth;
        //  var canvasHeight = images[0].clientHeight;
        var parent = opts.parent;
        var renderWidth = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
        var renderHeight = Math.max(document.documentElement.clientHeight - 150, window.innerHeight - 150 || 0);
        var renderW = void 0,
            renderH = void 0;

        //  if (renderWidth > canvasWidth) {
        //      renderW = renderWidth;
        //  } else {
        //      renderW = canvasWidth;
        //  }
        renderW = $('#jh').width() < $('.banner').width() ? $('#jh').width() : $('.banner').width()
        renderH = $('#jh').height();
        var renderer = new THREE.WebGLRenderer({
            antialias: false
        });
        renderer.setPixelRatio(window.devicePixelRatio);
        renderer.setClearColor(0x23272A, 1.0);
        renderer.setSize(renderW, renderH);
        parent.appendChild(renderer.domElement);
        // console.log(renderer.getSize())
        var loader = new THREE.TextureLoader();
        loader.crossOrigin = "anonymous";

        $('#allIndex').html(images.length);

        images.forEach(function (img) {
            image = loader.load(img.getAttribute('src') + '?v=' + Date.now());
            image.magFilter = image.minFilter = THREE.LinearFilter;
            image.generateMipmaps = false
            // image.wrapS = image.wrapT = THREE.RepeatWrapping;
            console.log(image)
            image.anisotropy = renderer.capabilities.getMaxAnisotropy();
            sliderImages.push(image);
        });
        var scene = new THREE.Scene();
        scene.background = new THREE.Color(0xb90028);
        var camera = new THREE.OrthographicCamera(renderW / -2, renderW / 2, renderH / 2, renderH / -2, 1, 1000);
        camera.position.z = 1;
        var mat = new THREE.ShaderMaterial({
            uniforms: {
                dispFactor: {
                    type: "f",
                    value: 0.0
                },
                currentImage: {
                    type: "t",
                    value: sliderImages[0]
                },
                nextImage: {
                    type: "t",
                    value: sliderImages[1]
                }
            },
            vertexShader: vertex,
            fragmentShader: fragment,
            transparent: true,
            opacity: 1.0
        });
        var isClick = true;
        // $(document).on('click','#changeList li',function () {
        //     if(isClick){
        //         isClick=false;
        //         clearInterval(timer); 
        //         $('.header .top .changeTip .c-cir .c-lo').removeClass('active');
        //         $('.header .top .changeTip .c-cir .c-ro').removeClass('active');
        //         index=$(this).index();
        //         changeBanner(index);
        //     }
        // });
        var geometry = new THREE.PlaneBufferGeometry($('#jh').width(), renderH, 1);
        var object = new THREE.Mesh(geometry, mat);
        object.position.set(0, 0, 0);
        scene.add(object);
        var index = 0;
        // $('#nowIndex').html(index+1);
        // $('.header .top .changeTip .c-cir .c-lo').addClass('active')
        // $('.header .top .changeTip .c-cir .c-ro').addClass('active')
        $('.banner ul li').eq(0).addClass('active')
        var changeBanner = function (slideId) {
            // $('#changeList').find('li').eq(slideId).addClass('active').siblings().removeClass('active');
            // $('#nowIndex').html(slideId+1);
            mat.uniforms.nextImage.value = sliderImages[slideId];
            mat.uniforms.nextImage.needsUpdate = true;
            TweenLite.to(mat.uniforms.dispFactor, 3, {
                value: 1,
                ease: 'Expo.easeInOut',
                onComplete: function onComplete() {
                    mat.uniforms.currentImage.value = sliderImages[slideId];
                    mat.uniforms.currentImage.needsUpdate = true;
                    mat.uniforms.dispFactor.value = 0.0;
                    isAnimating = false;
                    timerStart();
                    // $('.header .top .changeTip .c-cir .c-lo').addClass('active')
                    // $('.header .top .changeTip .c-cir .c-ro').addClass('active')
                    $('.banner ul li').eq(slideId).addClass('active').siblings().removeClass('active')
                    isClick = true;
                }
            });
        }
        var timer = null;
        var timerStart = function () {
            timer = setInterval(function () {
                // $('.header .top .changeTip .c-cir .c-lo').removeClass('active')
                // $('.header .top .changeTip .c-cir .c-ro').removeClass('active')
                clearInterval(timer);
                index++;
                if (index > sliderImages.length - 1) index = 0;
                changeBanner(index);
            }, 5000);
        }
        timerStart();
        window.addEventListener('resize', function (e) {
            renderW = $('#jh').width() < $('.banner').width() ? $('#jh').width() : $('.banner').width()
            renderH = $('#jh').height();
            renderer.setSize(renderW, renderH);
            camera.updateProjectionMatrix();
            camera.aspect = renderW / renderH;
        });
        var animate = function animate() {
            requestAnimationFrame(animate);
            renderer.render(scene, camera);
        };
        animate();
    };