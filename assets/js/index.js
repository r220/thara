AOS.init();


const hero_nav = document.querySelector(".hero-nav");
const hero_background = document.querySelector(".hero-background");
const about_section = document.querySelector("#about");

// Access the first stylesheet
const stylesheet = document.styleSheets[5];

window.onscroll = function() {

  let value = window.pageYOffset / about_section.offsetTop + 1;

  if (value <= 1.2)
    hero_background.style.transform = `scale(${value})`;

  if (document.body.scrollTop > 10 || document.documentElement.scrollTop > 10) {
    document.querySelector('.hero-content').style.opacity = 0;
    document.querySelector('.hero-content').style.transform = 'translate3d(0,-50px,0)';
    hero_nav.style.transform = 'translate3d(0,-50px,0)';
    stylesheet.insertRule( '.hero-background::after { content: ""; background-color: rgb(238 234 251 / 90%);; }',
      stylesheet.cssRules.length
    );
    
  } else {
    document.querySelector('.hero-content').style.opacity = 1;
    document.querySelector('.hero-content').style.transform = 'none';
    hero_nav.style.transform = 'translate3d(0,0,0)';
    stylesheet.insertRule( '.hero-background::after { content: ""; background-color: rgb(238 234 251 / 60%);; }',
      stylesheet.cssRules.length
    );
  }
  if (document.body.scrollTop > 600 || document.documentElement.scrollTop > 600) {
    document.getElementById("navbar").style.top = "1rem";
  } else {
    document.getElementById("navbar").style.top = "-4rem";
  }
};


var splide_episodes = new Splide('#splide_episodes', {
    type: 'loop',
    direction: 'rtl',
    pagination: false,
    drag: 'free',
    autoplay: true,
    interval: 2000,
    speed: 600,

    perPage: 4,
    focus: 4,
    height: "23rem",
    gap: 20,
    padding: {
      left: 10,
      right: 10,
    },
  
    breakpoints: {
      1280: {
        perPage: 4,
        focus: 4,
        height: "22rem",
        gap: 20,
        padding: {
          left: 10,
          right: 10,
        }
      },
      992: {
        perPage: 3,
        focus: 3,
        height: "22rem",
        gap: 13,
        padding: {
          left: 10,
          right: 10,
        }
      },
      768: {
        perPage: 2,
        focus: 2,
        height: "24rem",
        gap: 20,
        padding: {
          left: 10,
          right: 10,
        }
      },

      600: {
        perPage: 1,
        height: "25rem",
        focus: 'center',
        gap: 20,
        padding: {
          left: 80,
          right: 80,
        }
      },
      450: { 
        perPage: 1,
        height: "22rem",
        focus: 'center',
        gap: 20,
        padding: {
          left: 30,
          right: 30,
        }
      }
    }
});

splide_episodes.mount();

var splide_blogs = new Splide('#splide_blogs', {
  type: 'loop',
  direction: 'rtl',
  pagination: false,
  drag: 'free',
  // autoplay: true,
  interval: 2000,
  speed: 600,

  perPage: 2,
  focus: 2,
  height: "9rem",
  gap: 20,
  padding: {
    left: 10,
    right: 10,
  },

  breakpoints: {
    991: {
      perPage: 1,
      focus: 'center',
    },
  }
});


splide_blogs.mount();









// Code injected by live-server

    // // <![CDATA[  <-- For SVG support
    // if ('WebSocket' in window) {
    //     (function () {
    //         function refreshCSS() {
    //             var sheets = [].slice.call(document.getElementsByTagName("link"));
    //             var head = document.getElementsByTagName("head")[0];
    //             for (var i = 0; i < sheets.length; ++i) {
    //                 var elem = sheets[i];
    //                 var parent = elem.parentElement || head;
    //                 parent.removeChild(elem);
    //                 var rel = elem.rel;
    //                 if (elem.href && typeof rel != "string" || rel.length == 0 || rel.toLowerCase() == "stylesheet") {
    //                     var url = elem.href.replace(/(&|\?)_cacheOverride=\d+/, '');
    //                     elem.href = url + (url.indexOf('?') >= 0 ? '&' : '?') + '_cacheOverride=' + (new Date().valueOf());
    //                 }
    //                 parent.appendChild(elem);
    //             }
    //         }
    //         var protocol = window.location.protocol === 'http:' ? 'ws://' : 'wss://';
    //         var address = protocol + window.location.host + window.location.pathname + '/ws';
    //         var socket = new WebSocket(address);
    //         socket.onmessage = function (msg) {
    //             if (msg.data == 'reload') window.location.reload();
    //             else if (msg.data == 'refreshcss') refreshCSS();
    //         };
    //         if (sessionStorage && !sessionStorage.getItem('IsThisFirstTime_Log_From_LiveServer')) {
    //             console.log('Live reload enabled.');
    //             sessionStorage.setItem('IsThisFirstTime_Log_From_LiveServer', true);
    //         }
    //     })();
    // }
    // else {
    //     console.error('Upgrade your browser. This Browser is NOT supported WebSocket for Live-Reloading.');
    // }
    // // ]]>
