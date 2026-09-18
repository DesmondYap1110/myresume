/*
 * Website theme animations: boot screen, scroll progress, hero network
 * canvas, typing terminal, scroll reveals and card spotlight.
 * Colours are read from the --brand-* variables set by the admin Theme Setting.
 * Everything degrades gracefully: without JS the page is fully visible, and
 * prefers-reduced-motion turns the heavy effects off.
 */
(function () {
    'use strict';

    var doc = document.documentElement;
    var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    function cssVar(name, fallback) {
        var value = getComputedStyle(doc).getPropertyValue(name).trim();
        return value || fallback;
    }

    function hexToRgb(hex) {
        var m = /^#?([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})$/i.exec(hex);
        return m ? [parseInt(m[1], 16), parseInt(m[2], 16), parseInt(m[3], 16)] : [255, 215, 0];
    }

    var accent = hexToRgb(cssVar('--brand-accent', '#FFD700'));
    var rgba = function (a) { return 'rgba(' + accent[0] + ',' + accent[1] + ',' + accent[2] + ',' + a + ')'; };

    /* ---------------- Boot screen ---------------- */
    (function boot() {
        var screen = document.querySelector('.boot-screen');
        if (!screen) return;

        var percent = screen.querySelector('.boot-percent');
        var bar = screen.querySelector('.boot-bar span');
        var start = performance.now();
        var duration = reduceMotion ? 1 : 900;

        var finished = false;

        function done() {
            if (finished) return;
            finished = true;
            if (percent) percent.textContent = '100';
            if (bar) bar.style.width = '100%';
            screen.classList.add('is-done');
            doc.classList.add('is-booted');
            setTimeout(function () { screen.remove(); }, 700);
        }

        function tick(now) {
            if (finished) return;
            var p = Math.min(1, (now - start) / duration);
            var eased = 1 - Math.pow(1 - p, 3);
            if (percent) percent.textContent = Math.round(eased * 100);
            if (bar) bar.style.width = (eased * 100) + '%';
            if (p < 1) requestAnimationFrame(tick);
        }

        // The timer, not the frame loop, ends the boot, so a throttled or
        // background tab can never leave the screen stuck.
        requestAnimationFrame(tick);
        setTimeout(done, duration + 150);
    })();

    /* ---------------- Scroll progress ---------------- */
    (function progress() {
        var bar = document.querySelector('.scroll-progress span');
        if (!bar) return;
        var ticking = false;

        function update() {
            var max = doc.scrollHeight - window.innerHeight;
            bar.style.transform = 'scaleX(' + (max > 0 ? window.scrollY / max : 0) + ')';
            ticking = false;
        }

        window.addEventListener('scroll', function () {
            if (!ticking) { ticking = true; requestAnimationFrame(update); }
        }, { passive: true });
        update();
    })();

    /* ---------------- Hero network canvas ---------------- */
    (function network() {
        var canvas = document.querySelector('.hero-network');
        if (!canvas || !canvas.getContext || reduceMotion) return;

        var ctx = canvas.getContext('2d');
        var hero = canvas.parentElement;
        var nodes = [];
        var mouse = { x: -9999, y: -9999 };
        var width = 0, height = 0, dpr = 1, visible = true, raf = null;
        var LINK = 150;

        function resize() {
            dpr = Math.min(window.devicePixelRatio || 1, 2);
            width = hero.clientWidth;
            height = hero.clientHeight;
            canvas.width = width * dpr;
            canvas.height = height * dpr;
            canvas.style.width = width + 'px';
            canvas.style.height = height + 'px';
            ctx.setTransform(dpr, 0, 0, dpr, 0, 0);

            var count = Math.max(28, Math.min(95, Math.round(width * height / 16000)));
            nodes = [];
            for (var i = 0; i < count; i++) {
                nodes.push({
                    x: Math.random() * width,
                    y: Math.random() * height,
                    vx: (Math.random() - 0.5) * 0.45,
                    vy: (Math.random() - 0.5) * 0.45,
                    r: Math.random() * 1.8 + 0.8,
                    pulse: Math.random() * Math.PI * 2
                });
            }
        }

        function frame() {
            ctx.clearRect(0, 0, width, height);

            for (var i = 0; i < nodes.length; i++) {
                var n = nodes[i];
                n.x += n.vx;
                n.y += n.vy;
                if (n.x < 0 || n.x > width) n.vx *= -1;
                if (n.y < 0 || n.y > height) n.vy *= -1;

                // Nodes near the cursor are gently pulled towards it.
                var mdx = mouse.x - n.x, mdy = mouse.y - n.y;
                var md = Math.sqrt(mdx * mdx + mdy * mdy);
                if (md < 180) { n.x += mdx * 0.004; n.y += mdy * 0.004; }

                for (var j = i + 1; j < nodes.length; j++) {
                    var o = nodes[j];
                    var dx = n.x - o.x, dy = n.y - o.y;
                    var d = dx * dx + dy * dy;
                    if (d < LINK * LINK) {
                        var alpha = (1 - Math.sqrt(d) / LINK) * 0.35;
                        ctx.strokeStyle = rgba(alpha);
                        ctx.lineWidth = 1;
                        ctx.beginPath();
                        ctx.moveTo(n.x, n.y);
                        ctx.lineTo(o.x, o.y);
                        ctx.stroke();
                    }
                }

                if (md < 180) {
                    ctx.strokeStyle = rgba((1 - md / 180) * 0.6);
                    ctx.beginPath();
                    ctx.moveTo(n.x, n.y);
                    ctx.lineTo(mouse.x, mouse.y);
                    ctx.stroke();
                }

                n.pulse += 0.03;
                ctx.fillStyle = rgba(0.55 + Math.sin(n.pulse) * 0.35);
                ctx.beginPath();
                ctx.arc(n.x, n.y, n.r, 0, Math.PI * 2);
                ctx.fill();
            }

            raf = visible ? requestAnimationFrame(frame) : null;
        }

        hero.addEventListener('mousemove', function (e) {
            var rect = hero.getBoundingClientRect();
            mouse.x = e.clientX - rect.left;
            mouse.y = e.clientY - rect.top;
        });
        hero.addEventListener('mouseleave', function () { mouse.x = mouse.y = -9999; });

        var resizeTimer;
        window.addEventListener('resize', function () {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(resize, 150);
        });

        // Only animate while the hero is on screen.
        if ('IntersectionObserver' in window) {
            new IntersectionObserver(function (entries) {
                visible = entries[0].isIntersecting;
                if (visible && !raf) raf = requestAnimationFrame(frame);
            }).observe(hero);
        }

        resize();
        raf = requestAnimationFrame(frame);
    })();

    /* ---------------- Typing terminal ---------------- */
    (function typing() {
        var el = document.querySelector('.hero-terminal .typed');
        if (!el) return;

        var words;
        try { words = JSON.parse(el.getAttribute('data-words')) || []; } catch (e) { words = []; }
        if (!words.length || reduceMotion) return;

        var w = 0, c = words[0].length, deleting = true;

        function step() {
            var word = words[w];
            c += deleting ? -1 : 1;
            el.textContent = word.slice(0, c);

            var delay = deleting ? 35 : 75 + Math.random() * 60;
            if (!deleting && c === word.length) { deleting = true; delay = 1800; }
            else if (deleting && c === 0) { deleting = false; w = (w + 1) % words.length; delay = 350; }

            setTimeout(step, delay);
        }

        setTimeout(step, 2200);
    })();

    /* ---------------- Scroll reveal ---------------- */
    (function reveal() {
        if (!('IntersectionObserver' in window) || reduceMotion) return;

        var groups = [
            ['section.resume-section h2, #contact .contact-cont h3', 'reveal-up'],
            ['.heading-border', 'reveal-scale'],
            ['#education .resume-item, #project .resume-item', 'reveal-up'],
            ['#experience-box .experience:nth-child(odd)', 'reveal-left'],
            ['#experience-box .experience:nth-child(even)', 'reveal-right'],
            ['#skills .skill-tags li', 'reveal-up'],
            ['#blog .blog-item', 'reveal-zoom'],
            ['.con-form > div', 'reveal-up'],
            ['.contact-box-desc, .social-icon-f', 'reveal-right']
        ];

        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

        groups.forEach(function (group) {
            document.querySelectorAll(group[0]).forEach(function (el) {
                var index = Array.prototype.indexOf.call(el.parentNode.children, el);
                el.classList.add('reveal', group[1]);
                el.style.transitionDelay = Math.min(index, 6) * 90 + 'ms';
                observer.observe(el);
            });
        });
    })();

    /* ---------------- Card spotlight ---------------- */
    document.querySelectorAll('#education .card, #project .card, #experience-box .experience-content').forEach(function (card) {
        card.addEventListener('mousemove', function (e) {
            var rect = card.getBoundingClientRect();
            card.style.setProperty('--mx', (e.clientX - rect.left) + 'px');
            card.style.setProperty('--my', (e.clientY - rect.top) + 'px');
        });
    });
})();
