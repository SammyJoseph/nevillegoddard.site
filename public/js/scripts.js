document.addEventListener("DOMContentLoaded", function() {
    const spans = document.querySelectorAll("h1 span");
    const bibleVerse = document.getElementById("bible-verse");
    const source = document.getElementById("source");

    spans.forEach((span, index) => {
        span.style.animation = `fade-in 0.8s ${0.1 * (index + 1)}s forwards cubic-bezier(0.11, 0, 0.5, 0)`;
    });

    // Detect the end of the last span animation
    const lastSpan = spans[spans.length - 1];
    lastSpan.addEventListener('animationend', () => {
        bibleVerse.classList.add('animate');
        source.classList.add('animate');
    });
});