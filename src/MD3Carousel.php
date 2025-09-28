<?php

/**
 * Material Design 3 Carousel Component
 *
 * Interactive carousel for displaying multiple items with navigation
 * Supports images, cards, and custom content with pagination
 *
 * @package MD3Carousel
 * @version 0.1.0
 * @since 0.2.40
 */

class MD3Carousel
{
    /**
     * Generate a standard carousel
     *
     * @param array $items Array of carousel items
     * @param array $options Configuration options
     * @return string HTML for carousel
     */
    public static function create(array $items, array $options = []): string
    {
        $id = $options['id'] ?? 'md3-carousel-' . uniqid();
        $classes = ['md3-carousel'];

        if (!empty($options['class'])) {
            $classes[] = $options['class'];
        }

        $autoplay = $options['autoplay'] ?? false;
        $showIndicators = $options['showIndicators'] ?? true;
        $showArrows = $options['showArrows'] ?? true;

        // Build carousel items
        $itemsHtml = '';
        foreach ($items as $index => $item) {
            $activeClass = $index === 0 ? ' md3-carousel__item--active' : '';
            $itemsHtml .= sprintf(
                '<div class="md3-carousel__item%s" data-index="%d">%s</div>',
                $activeClass,
                $index,
                $item['content'] ?? $item
            );
        }

        // Build navigation arrows
        $arrowsHtml = '';
        if ($showArrows) {
            $arrowsHtml = '
            <button class="md3-carousel__arrow md3-carousel__arrow--prev" aria-label="Previous item">
                <span class="material-symbols-outlined">chevron_left</span>
            </button>
            <button class="md3-carousel__arrow md3-carousel__arrow--next" aria-label="Next item">
                <span class="material-symbols-outlined">chevron_right</span>
            </button>';
        }

        // Build indicators
        $indicatorsHtml = '';
        if ($showIndicators) {
            $indicatorsHtml = '<div class="md3-carousel__indicators">';
            for ($i = 0; $i < count($items); $i++) {
                $activeClass = $i === 0 ? ' md3-carousel__indicator--active' : '';
                $indicatorsHtml .= sprintf(
                    '<button class="md3-carousel__indicator%s" data-index="%d" aria-label="Go to item %d"></button>',
                    $activeClass,
                    $i,
                    $i + 1
                );
            }
            $indicatorsHtml .= '</div>';
        }

        $html = sprintf(
            '<div class="%s" id="%s" data-autoplay="%s" role="region" aria-label="Carousel">
                <div class="md3-carousel__track">%s</div>
                %s
                %s
            </div>',
            implode(' ', $classes),
            $id,
            $autoplay ? 'true' : 'false',
            $itemsHtml,
            $arrowsHtml,
            $indicatorsHtml
        );

        return $html;
    }

    /**
     * Generate a hero carousel (full-width, large images)
     *
     * @param array $items Array of carousel items
     * @param array $options Configuration options
     * @return string HTML for hero carousel
     */
    public static function hero(array $items, array $options = []): string
    {
        $options['class'] = ($options['class'] ?? '') . ' md3-carousel--hero';
        return self::create($items, $options);
    }

    /**
     * Generate CSS for carousel components
     *
     * @return string CSS
     */
    public static function getCSS(): string
    {
        return '
        .md3-carousel {
            position: relative;
            width: 100%;
            overflow: hidden;
            border-radius: 12px;
            background-color: var(--md-sys-color-surface-container-low);
        }

        .md3-carousel__track {
            display: flex;
            transition: transform 0.3s var(--md-sys-motion-easing-standard);
        }

        .md3-carousel__item {
            flex: 0 0 100%;
            display: none;
        }

        .md3-carousel__item--active {
            display: block;
        }

        .md3-carousel__item img {
            width: 100%;
            height: auto;
            display: block;
        }

        .md3-carousel__arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: var(--md-sys-color-surface-container-high);
            border: none;
            border-radius: 50%;
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s var(--md-sys-motion-easing-standard);
            z-index: 2;
        }

        .md3-carousel__arrow:hover {
            background-color: var(--md-sys-color-surface-container-highest);
            transform: translateY(-50%) scale(1.1);
        }

        .md3-carousel__arrow--prev {
            left: 16px;
        }

        .md3-carousel__arrow--next {
            right: 16px;
        }

        .md3-carousel__arrow .material-symbols-outlined {
            color: var(--md-sys-color-on-surface);
            font-size: 24px;
        }

        .md3-carousel__indicators {
            position: absolute;
            bottom: 16px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 8px;
            z-index: 2;
        }

        .md3-carousel__indicator {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            border: none;
            background-color: rgba(255, 255, 255, 0.5);
            cursor: pointer;
            transition: all 0.2s var(--md-sys-motion-easing-standard);
        }

        .md3-carousel__indicator--active {
            background-color: var(--md-sys-color-primary);
            transform: scale(1.25);
        }

        .md3-carousel--hero {
            height: 400px;
        }

        .md3-carousel--hero .md3-carousel__item {
            height: 100%;
        }

        .md3-carousel--hero .md3-carousel__item img {
            height: 100%;
            object-fit: cover;
        }

        /* Dark theme support */
        @media (prefers-color-scheme: dark) {
            .md3-carousel__arrow {
                background-color: var(--md-sys-color-surface-container, rgba(255, 255, 255, 0.08));
            }

            .md3-carousel__arrow:hover {
                background-color: var(--md-sys-color-surface-container-high, rgba(255, 255, 255, 0.12));
            }
        }
        ';
    }

    /**
     * Generate JavaScript for carousel functionality
     *
     * @return string JavaScript
     */
    public static function getJS(): string
    {
        return '
        class MD3Carousel {
            constructor(element) {
                this.carousel = element;
                this.track = element.querySelector(".md3-carousel__track");
                this.items = element.querySelectorAll(".md3-carousel__item");
                this.indicators = element.querySelectorAll(".md3-carousel__indicator");
                this.prevButton = element.querySelector(".md3-carousel__arrow--prev");
                this.nextButton = element.querySelector(".md3-carousel__arrow--next");
                this.currentIndex = 0;
                this.autoplay = element.dataset.autoplay === "true";
                this.autoplayInterval = null;

                this.init();
            }

            init() {
                if (this.prevButton) {
                    this.prevButton.addEventListener("click", () => this.prev());
                }

                if (this.nextButton) {
                    this.nextButton.addEventListener("click", () => this.next());
                }

                this.indicators.forEach((indicator, index) => {
                    indicator.addEventListener("click", () => this.goTo(index));
                });

                if (this.autoplay) {
                    this.startAutoplay();
                    this.carousel.addEventListener("mouseenter", () => this.stopAutoplay());
                    this.carousel.addEventListener("mouseleave", () => this.startAutoplay());
                }

                // Touch/swipe support
                let startX = 0;
                let endX = 0;

                this.carousel.addEventListener("touchstart", (e) => {
                    startX = e.touches[0].clientX;
                });

                this.carousel.addEventListener("touchend", (e) => {
                    endX = e.changedTouches[0].clientX;
                    const diff = startX - endX;

                    if (Math.abs(diff) > 50) {
                        if (diff > 0) {
                            this.next();
                        } else {
                            this.prev();
                        }
                    }
                });
            }

            goTo(index) {
                if (index < 0 || index >= this.items.length) return;

                // Hide current item
                this.items[this.currentIndex].classList.remove("md3-carousel__item--active");
                if (this.indicators[this.currentIndex]) {
                    this.indicators[this.currentIndex].classList.remove("md3-carousel__indicator--active");
                }

                // Show new item
                this.currentIndex = index;
                this.items[this.currentIndex].classList.add("md3-carousel__item--active");
                if (this.indicators[this.currentIndex]) {
                    this.indicators[this.currentIndex].classList.add("md3-carousel__indicator--active");
                }
            }

            next() {
                const nextIndex = (this.currentIndex + 1) % this.items.length;
                this.goTo(nextIndex);
            }

            prev() {
                const prevIndex = (this.currentIndex - 1 + this.items.length) % this.items.length;
                this.goTo(prevIndex);
            }

            startAutoplay() {
                if (!this.autoplay) return;
                this.autoplayInterval = setInterval(() => this.next(), 5000);
            }

            stopAutoplay() {
                if (this.autoplayInterval) {
                    clearInterval(this.autoplayInterval);
                    this.autoplayInterval = null;
                }
            }
        }

        // Initialize all carousels
        document.addEventListener("DOMContentLoaded", () => {
            document.querySelectorAll(".md3-carousel").forEach(carousel => {
                new MD3Carousel(carousel);
            });
        });
        ';
    }
}