var body = document.querySelector('body');
var menuTrigger = document.querySelector('#toggle-menu-main-mobile');
var menuContainer = document.querySelector('#menu-main-mobile');
var hamburgerIcon = document.querySelector('.hamburger');
var header = document.querySelector('header');

if (menuTrigger !== null) {
  menuTrigger.addEventListener('click', function(e) {
    menuContainer.classList.toggle('open');
    hamburgerIcon.classList.toggle('is-active');
    body.classList.toggle('lock-scroll');
  });
}

if (header) {
  (function () {
    const stickPoint = getDistance();

    var stuck = false;

    function getDistance() {
        var topDist = header.offsetTop;
        return topDist;
    };

    window.onscroll = function(e) {
        var distance = getDistance() - window.pageYOffset;
        var offset = window.pageYOffset;
        if ((distance <= 0) && !stuck) {
            document.body.classList.toggle('has-navbar-fixed-top');
            header.classList.toggle('fixed');
            stuck = true;
        } else if (stuck && (offset <= stickPoint)){
            document.body.classList.toggle('has-navbar-fixed-top');
            header.classList.toggle('fixed');
            stuck = false;
        }
    };
  })();
}

(function () {
    const images = document.querySelectorAll('img[data-src]');

    const observer = new IntersectionObserver((entries, observer) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const image = entry.target;
          image.src = image.dataset.src;
          observer.unobserve(image);
        }
      });
    });

    images.forEach(image => {
      observer.observe(image);
    });
})();

(function () {
    let extractLocalLinkTarget = function (href) {
      href = href.replace(location.protocol + '//' + location.host + location.pathname, '');
      // Check if the href is a relative URL
      if (!href.startsWith("http://") && !href.startsWith("https://")) {
        // Remove any leading slash
        if (href.startsWith("/")) {
          href = href.slice(1);
        }

        const queryIndex = href.indexOf("?");
        if (queryIndex > -1) {
          href = href.slice(0, queryIndex);
        }

        return href;
      }

      return null; // Not a local link
    }
    let scroll = function (selector) {
      let target = document.querySelector(selector);
      let headerOffset = null;
      if (header) {
        headerOffset = header.offsetHeight;
      }
      if (target) {
        headerOffset ??= 120;
        let elementPosition = target.offsetTop;
        let offsetPosition = elementPosition - headerOffset;
        window.scrollTo({
          top: offsetPosition,
          behavior: "smooth"
        });
      }
    }
    document.querySelectorAll('a[href^="#"]').forEach(function (el) {
        el.addEventListener("click", function (event) {
          event.preventDefault();
          scroll(extractLocalLinkTarget(el.href));
        });
    });
})();

(function () {
    let videos = document.querySelectorAll('video');
    for (var i=0; i<videos.length; i++) {
      videos[i].addEventListener('play', function(){pauseAll(this)}, true);
    }

    function pauseAll(elem){
        for (var i=0; i<videos.length; i++) {
            if (videos[i] == elem) continue;
            if (videos[i].played.length > 0 && !videos[i].paused) {
                videos[i].pause();
            }
        }
    }
})();
