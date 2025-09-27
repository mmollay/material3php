<?php

require_once 'MD3.php';
require_once 'MD3TextField.php';

/**
 * MD3Search - Material Design 3 Search Components
 * Generates HTML for Material Web Components search functionality
 */
class MD3Search
{
    /**
     * Generate a basic search field with correct MD3 search bar anatomy
     *
     * @param string $name Field name attribute
     * @param string $placeholder Search placeholder text
     * @param array $attributes Additional HTML attributes
     * @return string HTML for search field
     */
    public static function field(string $name, string $placeholder = 'Suche...', array $attributes = []): string
    {
        $id = $attributes['id'] ?? 'search-' . $name . '-' . uniqid();
        $value = $attributes['value'] ?? '';
        $disabled = $attributes['disabled'] ?? false;
        $autocomplete = $attributes['autocomplete'] ?? 'off';
        $list = $attributes['list'] ?? '';

        $inputAttrs = [];
        foreach ($attributes as $key => $val) {
            if (!in_array($key, ['id', 'value', 'disabled', 'autocomplete', 'list'])) {
                $inputAttrs[] = htmlspecialchars($key) . '="' . htmlspecialchars($val) . '"';
            }
        }

        $inputAttrsStr = !empty($inputAttrs) ? ' ' . implode(' ', $inputAttrs) : '';
        $disabledAttr = $disabled ? ' disabled' : '';
        $listAttr = $list ? ' list="' . htmlspecialchars($list) . '"' : '';

        return '
        <div class="md3-search-bar' . ($disabled ? ' md3-search-bar--disabled' : '') . '">
            <div class="md3-search-bar__leading-icon">
                <span class="material-symbols-outlined">search</span>
            </div>
            <input type="search"
                   name="' . htmlspecialchars($name) . '"
                   id="' . htmlspecialchars($id) . '"
                   class="md3-search-bar__input"
                   placeholder="' . htmlspecialchars($placeholder) . '"
                   value="' . htmlspecialchars($value) . '"
                   autocomplete="' . htmlspecialchars($autocomplete) . '"' .
                   $listAttr . $disabledAttr . $inputAttrsStr . '>
            <div class="md3-search-bar__trailing-icon" style="display: none;">
                <button type="button" class="md3-search-bar__clear" aria-label="Clear search">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
        </div>';
    }

    /**
     * Generate CSS for MD3 Search Bar Component
     */
    public static function getCSS(): string
    {
        return '
/* MD3 Search Bar Component */
.md3-search-bar {
    display: flex;
    align-items: center;
    height: 56px;
    background: var(--md-sys-color-surface-container-high);
    border-radius: 28px;
    padding: 0 16px;
    gap: 12px;
    position: relative;
    transition: all 0.2s cubic-bezier(0.2, 0, 0, 1);
    border: 1px solid transparent;
    box-sizing: border-box;
    width: 100%;
    max-width: 600px;
}

.md3-search-bar:hover {
    background: var(--md-sys-color-surface-container-high);
    box-shadow: var(--md-sys-elevation-1);
}

.md3-search-bar:focus-within {
    background: var(--md-sys-color-surface-container-high);
    border-color: var(--md-sys-color-primary);
    box-shadow: var(--md-sys-elevation-2);
}

.md3-search-bar--disabled {
    background: var(--md-sys-color-surface-variant);
    opacity: 0.38;
    pointer-events: none;
}

.md3-search-bar__leading-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 24px;
    height: 24px;
    color: var(--md-sys-color-on-surface-variant);
    flex-shrink: 0;
}

.md3-search-bar__input {
    flex: 1;
    border: none;
    outline: none;
    background: transparent;
    color: var(--md-sys-color-on-surface);
    font-family: inherit;
    font-size: 16px;
    line-height: 24px;
    padding: 0;
    margin: 0;
}

.md3-search-bar__input::placeholder {
    color: var(--md-sys-color-on-surface-variant);
}

.md3-search-bar__input::-webkit-search-cancel-button {
    display: none;
}

.md3-search-bar__trailing-icon {
    display: flex;
    align-items: center;
    gap: 8px;
}

.md3-search-bar__clear {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 24px;
    height: 24px;
    border: none;
    background: transparent;
    color: var(--md-sys-color-on-surface-variant);
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.2s cubic-bezier(0.2, 0, 0, 1);
    padding: 0;
}

.md3-search-bar__clear:hover {
    background: var(--md-sys-color-surface-container-highest);
    color: var(--md-sys-color-on-surface);
}

.md3-search-bar__clear:active {
    background: var(--md-sys-color-surface-container-highest);
    transform: scale(0.95);
}

/* Search with filters container */
.search-with-filters {
    width: 100%;
}

.search-filters {
    margin-top: 12px;
}

/* Search results dropdown */
.search-results {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: var(--md-sys-color-surface-container);
    border-radius: 12px;
    box-shadow: var(--md-sys-elevation-3);
    max-height: 300px;
    overflow-y: auto;
    z-index: 1000;
    margin-top: 8px;
}

.search-results-list {
    padding: 8px 0;
}

/* Dark theme support */
[data-theme="dark"] .md3-search-bar {
    background: var(--md-sys-color-surface-container-high);
}

[data-theme="dark"] .md3-search-bar:hover {
    background: var(--md-sys-color-surface-container-highest);
}

[data-theme="dark"] .md3-search-bar:focus-within {
    background: var(--md-sys-color-surface-container-highest);
}

/* Responsive design */
@media (max-width: 480px) {
    .md3-search-bar {
        height: 48px;
        border-radius: 24px;
        padding: 0 12px;
        gap: 8px;
    }
}
';
    }

    /**
     * Generate a search bar with suggestions
     *
     * @param string $name Field name attribute
     * @param array $suggestions Array of suggestion strings
     * @param string $placeholder Search placeholder text
     * @param array $attributes Additional HTML attributes
     * @return string HTML for search bar with dropdown
     */
    public static function withSuggestions(string $name, array $suggestions = [], string $placeholder = 'Suche...', array $attributes = []): string
    {
        $searchId = 'search-' . $name;
        $suggestionsId = 'suggestions-' . $name;

        $searchField = self::field($name, $placeholder, array_merge($attributes, [
            'id' => $searchId,
            'list' => $suggestionsId,
            'autocomplete' => 'off'
        ]));

        $datalist = '<datalist id="' . htmlspecialchars($suggestionsId) . '">';
        foreach ($suggestions as $suggestion) {
            $datalist .= '<option value="' . htmlspecialchars($suggestion) . '">';
        }
        $datalist .= '</datalist>';

        return '<div class="search-container">' . $searchField . $datalist . '</div>';
    }

    /**
     * Generate a search bar with filter chips
     *
     * @param string $name Field name attribute
     * @param array $filters Array of filter options ['label' => 'Filter Name', 'value' => 'filter_value']
     * @param string $placeholder Search placeholder text
     * @param array $attributes Additional HTML attributes
     * @return string HTML for search with filter chips
     */
    public static function withFilters(string $name, array $filters = [], string $placeholder = 'Suche...', array $attributes = []): string
    {
        require_once 'MD3Chip.php';

        $searchField = self::field($name, $placeholder, $attributes);

        $filterChips = '';
        if (!empty($filters)) {
            $filterChips = '<div class="search-filters" style="display: flex; flex-wrap: wrap; gap: 8px; margin-top: 8px;">';
            foreach ($filters as $filter) {
                $filterChips .= MD3Chip::filter(
                    $filter['label'] ?? $filter['value'],
                    [
                        'value' => $filter['value'],
                        'name' => $name . '_filters[]'
                    ]
                );
            }
            $filterChips .= '</div>';
        }

        return '<div class="search-with-filters">' . $searchField . $filterChips . '</div>';
    }

    /**
     * Generate a search bar with results dropdown
     *
     * @param string $name Field name attribute
     * @param array $results Array of search results
     * @param string $placeholder Search placeholder text
     * @param array $attributes Additional HTML attributes
     * @return string HTML for search with results
     */
    public static function withResults(string $name, array $results = [], string $placeholder = 'Suche...', array $attributes = []): string
    {
        $searchId = 'search-' . $name;
        $resultsId = 'results-' . $name;

        $searchAttrs = array_merge($attributes, [
            'id' => $searchId,
            'onkeyup' => "showSearchResults('$searchId', '$resultsId')"
        ]);

        $searchField = self::field($name, $placeholder, $searchAttrs);

        $resultsList = '<div id="' . htmlspecialchars($resultsId) . '" class="search-results" style="display: none;">';
        if (!empty($results)) {
            require_once 'MD3List.php';
            $listItems = [];
            foreach ($results as $result) {
                $listItems[] = [
                    'text' => $result['title'] ?? $result,
                    'icon' => $result['icon'] ?? 'search',
                    'onclick' => "selectSearchResult('" . htmlspecialchars($result['value'] ?? $result) . "')"
                ];
            }
            $resultsList .= MD3List::withIcons($listItems, ['class' => 'search-results-list']);
        }
        $resultsList .= '</div>';

        return '<div class="search-with-results" style="position: relative;">' . $searchField . $resultsList . '</div>';
    }

    /**
     * Generate a full-screen search overlay
     *
     * @param string $name Field name attribute
     * @param string $triggerId ID of the element that triggers the search
     * @param array $suggestions Optional suggestions array
     * @param array $attributes Additional HTML attributes
     * @return string HTML for search overlay
     */
    public static function overlay(string $name, string $triggerId, array $suggestions = [], array $attributes = []): string
    {
        $overlayId = 'search-overlay-' . $name;

        $overlay = '<div id="' . htmlspecialchars($overlayId) . '" class="search-overlay" style="display: none;">';

        // Search header
        $overlay .= '<div class="search-header">';
        $overlay .= '<button class="search-back" onclick="closeSearchOverlay(\'' . $overlayId . '\')">';
        $overlay .= MD3::icon('arrow_back');
        $overlay .= '</button>';

        $searchAttrs = array_merge($attributes, [
            'class' => 'search-overlay-input',
            'autofocus' => true
        ]);
        $overlay .= self::field($name, 'Suche...', $searchAttrs);

        $overlay .= '<button class="search-clear" onclick="clearSearch(\'' . $name . '\')">';
        $overlay .= MD3::icon('clear');
        $overlay .= '</button>';
        $overlay .= '</div>';

        // Search content
        $overlay .= '<div class="search-content">';
        if (!empty($suggestions)) {
            require_once 'MD3List.php';
            $suggestionItems = [];
            foreach ($suggestions as $suggestion) {
                $suggestionItems[] = [
                    'text' => $suggestion,
                    'icon' => 'history',
                    'onclick' => "selectSearchSuggestion('" . htmlspecialchars($suggestion) . "')"
                ];
            }
            $overlay .= MD3List::withIcons($suggestionItems);
        }
        $overlay .= '</div>';

        $overlay .= '</div>';

        // Trigger script
        $script = '<script>';
        $script .= 'function openSearchOverlay() {';
        $script .= '  document.getElementById("' . $overlayId . '").style.display = "block";';
        $script .= '}';
        $script .= 'function closeSearchOverlay(id) {';
        $script .= '  document.getElementById(id).style.display = "none";';
        $script .= '}';
        $script .= 'document.getElementById("' . $triggerId . '").onclick = openSearchOverlay;';
        $script .= '</script>';

        return $overlay . $script;
    }

    /**
     * Generate JavaScript helper functions for search functionality
     *
     * @return string JavaScript code for search interactions
     */
    public static function getSearchScript(): string
    {
        return '<script>
            // MD3 Search Bar Interactions
            document.addEventListener("DOMContentLoaded", function() {
                // Handle clear button visibility and functionality
                const searchBars = document.querySelectorAll(".md3-search-bar");

                searchBars.forEach(searchBar => {
                    const input = searchBar.querySelector(".md3-search-bar__input");
                    const trailingIcon = searchBar.querySelector(".md3-search-bar__trailing-icon");
                    const clearButton = searchBar.querySelector(".md3-search-bar__clear");

                    if (!input || !trailingIcon || !clearButton) return;

                    // Show/hide clear button based on input content
                    function updateClearButton() {
                        if (input.value.trim().length > 0) {
                            trailingIcon.style.display = "flex";
                        } else {
                            trailingIcon.style.display = "none";
                        }
                    }

                    // Initial check
                    updateClearButton();

                    // Update on input
                    input.addEventListener("input", updateClearButton);

                    // Clear functionality
                    clearButton.addEventListener("click", function() {
                        input.value = "";
                        updateClearButton();
                        input.focus();

                        // Dispatch input event for other listeners
                        input.dispatchEvent(new Event("input", { bubbles: true }));
                    });
                });
            });

            function showSearchResults(searchId, resultsId) {
                const searchInput = document.getElementById(searchId);
                const resultsDiv = document.getElementById(resultsId);

                if (searchInput.value.trim().length > 0) {
                    resultsDiv.style.display = "block";
                } else {
                    resultsDiv.style.display = "none";
                }
            }

            function selectSearchResult(value) {
                console.log("Selected:", value);
                // Implement your search result selection logic here
            }

            function selectSearchSuggestion(value) {
                console.log("Selected suggestion:", value);
                // Implement your suggestion selection logic here
            }

            function clearSearch(inputName) {
                const input = document.querySelector("[name=\"" + inputName + "\"]");
                if (input) {
                    input.value = "";

                    // Update clear button visibility
                    const searchBar = input.closest(".md3-search-bar");
                    if (searchBar) {
                        const trailingIcon = searchBar.querySelector(".md3-search-bar__trailing-icon");
                        if (trailingIcon) {
                            trailingIcon.style.display = "none";
                        }
                    }

                    input.focus();
                }
            }
        </script>';
    }
}