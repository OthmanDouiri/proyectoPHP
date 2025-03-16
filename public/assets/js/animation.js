document.addEventListener("DOMContentLoaded", function () {
    gsap.registerPlugin(ScrollTrigger);

    // Animation for sections sliding from bottom to top (existing)
    gsap.utils.toArray(".animation-section").forEach((section) => {
        gsap.from(section, {
            opacity: 0,
            y: 100,
            duration: 1,
            ease: "power2.out",
            scrollTrigger: {
                trigger: section,
                start: "top 80%", // Start when 80% of the section is in the viewport
                toggleActions: "play none none reverse",
            },
        });
    });

    // Animation for sections sliding from left to right (animation2-section)
    gsap.utils.toArray(".animation2-section").forEach((section) => {
        gsap.from(section, {
            opacity: 0,
            x: -200, // Start 200px to the left
            duration: 1,
            ease: "power2.out",
            scrollTrigger: {
                trigger: section,
                start: "top 80%", // Start when 80% of the section is in the viewport
                toggleActions: "play none none reverse",
            },
        });
    });

    // Animation for sections sliding from right to left (animation3-section)
    gsap.utils.toArray(".animation3-section").forEach((section) => {
        gsap.from(section, {
            opacity: 0,
            x: 200, // Start 200px to the right
            duration: 1,
            ease: "power2.out",
            scrollTrigger: {
                trigger: section,
                start: "top 80%", // Start when 80% of the section is in the viewport
                toggleActions: "play none none reverse",
            },
        });
    });
});
