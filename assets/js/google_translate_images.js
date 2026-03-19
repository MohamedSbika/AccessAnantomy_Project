/**
 * Google Translate Image Swapper
 * 
 * Detects the language change triggered by the Google Translate widget
 * and automatically swaps image sources for <img> tags that have
 * corresponding data-src-{lang} attributes.
 * 
 * Example usage in HTML:
 * <img src="image_fr.png" data-src-en="image_en.png" data-src-es="image_es.png">
 */

(function () {
    function swapImages() {
        const htmlElement = document.documentElement;
        // Google Translate changes the 'lang' attribute of the <html> tag
        const currentLang = htmlElement.lang.toLowerCase().split('-')[0]; // Get 'en' from 'en-US' or 'en'

        // We also check for the googtrans cookie as a fallback/secondary check
        const getCookie = (name) => {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
        };

        const googTrans = getCookie('googtrans');
        let detectedLang = currentLang;

        if (googTrans) {
            const parts = googTrans.split('/');
            detectedLang = parts[parts.length - 1].toLowerCase();
        }

        console.log("Google Translate detected language:", detectedLang);

        document.querySelectorAll('img').forEach(img => {
            // Store original source if we haven't yet
            if (!img.getAttribute('data-src-original')) {
                img.setAttribute('data-src-original', img.getAttribute('src'));
            }

            const translatedSrc = img.getAttribute('data-src-' + detectedLang);
            const originalSrc = img.getAttribute('data-src-original');

            if (translatedSrc) {
                if (img.src !== translatedSrc) {
                    img.src = translatedSrc;
                }
            } else if (detectedLang === 'fr') {
                // Restore original French image
                if (img.src !== originalSrc) {
                    img.src = originalSrc;
                }
            }
        });
    }

    // Set up a MutationObserver to watch for changes to the <html> lang attribute
    const observer = new MutationObserver((mutations) => {
        mutations.forEach((mutation) => {
            if (mutation.type === 'attributes' && mutation.attributeName === 'lang') {
                swapImages();
            }
        });
    });

    // Start observing the <html> element
    observer.observe(document.documentElement, {
        attributes: true,
        attributeFilter: ['lang']
    });

    // Also run on a timer because sometimes Google Translate doesn't trigger the observer 
    // immediately or re-injects things
    setInterval(swapImages, 2000);

    // Initial check
    if (document.readyState === 'complete') {
        swapImages();
    } else {
        window.addEventListener('load', swapImages);
    }
})();
