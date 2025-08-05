$(window).on("load", function() {
  $(".loader-wrapper").fadeOut("slow");
});

AOS.init();
// 

const hero_nav = document.querySelector(".hero-nav");
const hero_background = document.querySelector(".hero-background");
const hero_content = document.querySelector('.hero-content');
const about_section = document.querySelector("#about");
const header = document.querySelector('header');

// Access the first stylesheet
const stylesheet = document.styleSheets[5];

window.onscroll = function() {

  let value = window.pageYOffset / about_section.offsetTop + 1;

  if (value <= 1.2)
    hero_background.style.transform = `scale(${value})`;

  if (document.body.scrollTop > 10 || document.documentElement.scrollTop > 10) {
    hero_content.style.opacity = 0;
    hero_content.style.transform = 'translate3d(0,-50px,0)';
    hero_nav.style.transform = 'translate3d(0,-50px,0)';
    stylesheet.insertRule( '.hero-background::after { content: ""; background-color: rgb(238 234 251 / 90%);; }',
      stylesheet.cssRules.length
    );
    
  } else {
    hero_content.style.opacity = 1;
    hero_content.style.transform = 'none';
    hero_nav.style.transform = 'translate3d(0,0,0)';
    stylesheet.insertRule( '.hero-background::after { content: ""; background-color: rgb(238 234 251 / 60%);; }',
      stylesheet.cssRules.length
    );
  }
  if (document.body.scrollTop > 600 || document.documentElement.scrollTop > 600) {
    header.style.top = "1rem";
  } else {
    header.style.top = "-4rem";
  }
};