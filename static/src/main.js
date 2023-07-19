import './main.css';
import BlazeSlider from "blaze-slider";
import "blaze-slider/dist/blaze.css";

"use strict";

const body = document.querySelector( 'body' );

// Mobile nav
const mobileNavBtn = document.querySelector( '[data-mobile-nav-btn]' );
const mobileNav = document.querySelector( '[data-mobile-nav]' );

mobileNavBtn?.addEventListener( 'click', () => {
    mobileNavBtn.classList.toggle( 'opened' );
    mobileNav.classList.toggle( 'opened' );
    body.style.overflow = body.style.overflow === 'hidden' ? '' : 'hidden';
});

// Blog slider
document.querySelectorAll('.blaze-slider').forEach(el => {
    new BlazeSlider(el, {
        all: {
            slidesToScroll: 1,
            slidesToShow: 1,
            slideGap: '0px',
            transitionDuration: 2000,
            // enableAutoplay: true
        },
        "(min-width: 768px)": {
            slidesToScroll: 2,
            slidesToShow: 2,
        },
        "(min-width: 1280px)": {
            slidesToScroll: 3,
            slidesToShow: 3,
        }
    });
});

// Event carousel slider
document.querySelectorAll('.events-carousel-slider').forEach(el => {
    new BlazeSlider(el, {
        all: {
            transitionDuration: 2000,
            enableAutoplay: true
        },
        "(min-width: 1025px)": {
            slidesToScroll: 1,
            slidesToShow: 1.75,
            slideGap: '16px',
        },
        "(max-width: 1024px)": {
            slidesToScroll: 1,
            slidesToShow: 1.25,
            slideGap: '16px',
        },
        "(max-width: 768px)": {
            slidesToScroll: 1,
            slidesToShow: 1,
        },
    });
});

// Quote carousel
document.querySelectorAll('.ig-quote-carousel').forEach(el => {
    new BlazeSlider(el);
});


// Video blocks
const videoContainer = document.querySelectorAll('[data-video-id]');

if ( videoContainer.length ) {
    videoContainer.forEach(function (video) {
        const playPauseBtn = video.querySelector('[data-playpause]');
        const playBtn = video.querySelector('[data-playbutton]');
        const player = video.querySelector('iframe').contentWindow;
        const videoId = video.getAttribute('data-video-id');
        const contentIframe = video.querySelector('[data-content-iframe]');
        const videoLoop = video.querySelector('[data-video-loop]');

        playPauseBtn.addEventListener('click', () => {
            if ( playPauseBtn.ariaPressed === 'false' ) {
                playPauseBtn.textContent = 'Resume background video';
                player.postMessage('{"method":"pause"}', '*');
                playPauseBtn.ariaPressed = 'true';
            } else if ( playPauseBtn.ariaPressed === 'true' ) {
                playPauseBtn.textContent = 'Stop background video';
                player.postMessage('{"method":"play"}', '*');
                playPauseBtn.ariaPressed = 'false';
            }
        });

        playBtn.addEventListener('click', () => {
            playPauseBtn.remove();
            playBtn.remove();
            // Let's find a more secure alternative at some point
            contentIframe.innerHTML = `<iframe src="https://player.vimeo.com/video/${videoId}?color=ffd700&title=0&byline=0&portrait=0&autoplay=1" style="width:101%;height:101%;aspect-ratio: 16 / 9;" frameborder="0" allow="autoplay" fullscreen picture-in-picture allowfullscreen data-ready="true"></iframe>`;
            videoLoop.remove();
        });
    });
}

