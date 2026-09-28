"use strict";
console.clear();
gsap.registerPlugin(ScrollTrigger);

const pageContainer = document.querySelector(".layout-loco");

/* SMOOTH SCROLL */
const scroller = new LocomotiveScroll({
    el: pageContainer,
    smooth: true
});

scroller.on("scroll", ScrollTrigger.update);

ScrollTrigger.scrollerProxy(pageContainer, {
    scrollTop(value) {
        return arguments.length ?
            scroller.scrollTo(value, 0, 0) :
            scroller.scroll.instance.scroll.y;
    },
    getBoundingClientRect() {
        return {
            left: 0,
            top: 0,
            width: window.innerWidth,
            height: window.innerHeight
        };
    },
    pinType: pageContainer.style.transform ? "transform" : "fixed"
});

////////////////////////////////////
////////////////////////////////////
window.addEventListener("load", function() {
    //let pinBoxes = document.querySelectorAll(".recent-works-wrapper > *");
    let pinWrap = document.querySelector(".recent-works-wrapper");
    let wrapper = document.querySelector(".ar-work");
    let pinWrapWidth = pinWrap.offsetWidth;
    let horizontalScrollLength = pinWrapWidth - window.innerWidth;
    let wrapTransVal = pinWrapWidth - window.outerWidth + window.outerWidth / 2;

    // Pinning and horizontal scrolling


    gsap.to(".recent-works-wrapper", {
        scrollTrigger: {

            scroller: pageContainer, //locomotive-scroll
            trigger: "#sectionPin",
            scrub: 2,
            pin: true,
            snap: false,
            anticipatePin: 1,
            start: "top top",
            end: pinWrapWidth
        },
        x: -horizontalScrollLength,
        ease: "none"
    });

    ScrollTrigger.addEventListener("refresh", () => scroller.update()); //locomotive-scroll

    ScrollTrigger.refresh();
});