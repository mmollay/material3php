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
     * Generate a basic search field
     *
     * @param string $name Field name attribute
     * @param string $placeholder Search placeholder text
     * @param array $attributes Additional HTML attributes
     * @return string HTML for search field
     */
    public static function field(string $name, string $placeholder = 'Suche...', array $attributes = []): string
    {
        $attributes['type'] = 'search';
        return MD3TextField::withLeadingIcon($name, $placeholder, 'search', false, $attributes);
    }

    /**
     * Generate an outlined search field
     *
     * @param string $name Field name attribute
     * @param string $placeholder Search placeholder text
     * @param array $attributes Additional HTML attributes
     * @return string HTML for outlined search field
     */
    public static function fieldOutlined(string $name, string $placeholder = 'Suche...', array $attributes = []): string
    {
        $attributes['type'] = 'search';
        return MD3TextField::withLeadingIcon($name, $placeholder, 'search', true, $attributes);
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
                    $filter['value'],
                    $name . '_filters[]'
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
                    input.focus();
                }
            }
        </script>';
    }
}