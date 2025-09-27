// Playwright test script for Material Design 3 PHP Library
// Tests all 28 components across all themes

const { chromium } = require('playwright');

const COMPONENTS = [
    'button', 'textfield', 'card', 'list', 'search', 'chip', 'tooltip',
    'switch', 'checkbox', 'radio', 'breadcrumb', 'dialog', 'menu',
    'select', 'toolbar', 'progress', 'slider', 'tabs', 'badge',
    'bottomsheet', 'datetimepicker', 'header', 'snackbar', 'fab',
    'navigationbar', 'navigationdrawer', 'divider', 'carousel'
];

const THEMES = ['ocean', 'purple', 'green'];

const BASE_URL = 'http://localhost/material3php/playground.php';

async function testAllComponents() {
    console.log('🚀 Starting comprehensive Material Design 3 PHP Library test...\n');

    const browser = await chromium.launch({ headless: false });
    const context = await browser.newContext();
    const page = await context.newPage();

    let totalTests = 0;
    let passedTests = 0;
    let failedTests = [];

    console.log(`Testing ${COMPONENTS.length} components across ${THEMES.length} themes...\n`);

    for (const theme of THEMES) {
        console.log(`🎨 Testing theme: ${theme.toUpperCase()}`);
        console.log('─'.repeat(50));

        for (const component of COMPONENTS) {
            totalTests++;
            const url = `${BASE_URL}?component=${component}&theme=${theme}`;

            try {
                console.log(`Testing: ${component} (${theme})`);

                // Navigate to component page
                await page.goto(url, { waitUntil: 'networkidle' });

                // Wait for component to load
                await page.waitForSelector('#preview-area', { timeout: 10000 });

                // Check for PHP errors
                const hasPhpError = await page.locator('text=Fatal error').count() > 0;
                const hasParseError = await page.locator('text=Parse error').count() > 0;
                const hasWarning = await page.locator('text=Warning').count() > 0;

                if (hasPhpError || hasParseError) {
                    throw new Error('PHP Fatal/Parse error detected');
                }

                if (hasWarning) {
                    console.log(`  ⚠️  PHP Warning detected for ${component}`);
                }

                // Check if preview area has content
                const previewArea = page.locator('#preview-area');
                const hasContent = await previewArea.innerHTML();

                if (!hasContent || hasContent.trim().length < 10) {
                    throw new Error('Preview area is empty or has minimal content');
                }

                // Check for JavaScript errors
                const jsErrors = [];
                page.on('pageerror', error => {
                    jsErrors.push(error.message);
                });

                // Wait a bit for any JS to execute
                await page.waitForTimeout(1000);

                if (jsErrors.length > 0) {
                    console.log(`  ⚠️  JavaScript errors: ${jsErrors.join(', ')}`);
                }

                // Test specific component functionality
                await testComponentSpecific(page, component);

                console.log(`  ✅ ${component} (${theme}) - PASSED`);
                passedTests++;

            } catch (error) {
                console.log(`  ❌ ${component} (${theme}) - FAILED: ${error.message}`);
                failedTests.push({
                    component,
                    theme,
                    error: error.message,
                    url
                });
            }

            // Small delay between tests
            await page.waitForTimeout(500);
        }

        console.log(''); // Empty line between themes
    }

    // Test Results Summary
    console.log('🏁 TEST RESULTS SUMMARY');
    console.log('═'.repeat(50));
    console.log(`Total Tests: ${totalTests}`);
    console.log(`✅ Passed: ${passedTests} (${((passedTests/totalTests)*100).toFixed(1)}%)`);
    console.log(`❌ Failed: ${failedTests.length} (${((failedTests.length/totalTests)*100).toFixed(1)}%)`);

    if (failedTests.length > 0) {
        console.log('\n🔍 FAILED TESTS DETAILS:');
        console.log('─'.repeat(30));
        failedTests.forEach(failure => {
            console.log(`❌ ${failure.component} (${failure.theme})`);
            console.log(`   Error: ${failure.error}`);
            console.log(`   URL: ${failure.url}`);
            console.log('');
        });
    }

    // Test component count
    try {
        await page.goto(`${BASE_URL}?component=button&theme=ocean`);
        const componentCountText = await page.locator('#component-count').textContent();
        const count = parseInt(componentCountText.match(/\d+/)[0]);

        console.log(`\n📊 Component Count Check:`);
        console.log(`   Displayed: ${count} components`);
        console.log(`   Expected: ${COMPONENTS.length} components`);

        if (count === COMPONENTS.length) {
            console.log(`   ✅ Component count is correct!`);
        } else {
            console.log(`   ⚠️  Component count mismatch!`);
        }
    } catch (error) {
        console.log(`   ❌ Could not verify component count: ${error.message}`);
    }

    await browser.close();

    console.log('\n🎯 Test completed!');

    if (failedTests.length === 0) {
        console.log('🎉 All tests passed! The playground is working perfectly.');
        return true;
    } else {
        console.log(`⚠️  ${failedTests.length} tests failed. Please review the issues above.`);
        return false;
    }
}

async function testComponentSpecific(page, component) {
    switch (component) {
        case 'button':
            // Test button clicks
            const buttons = page.locator('button, .md3-button');
            if (await buttons.count() > 0) {
                await buttons.first().click();
            }
            break;

        case 'textfield':
            // Test text input
            const inputs = page.locator('input[type="text"], input[type="email"], textarea');
            if (await inputs.count() > 0) {
                await inputs.first().fill('Test input');
            }
            break;

        case 'tooltip':
            // Test tooltip hover
            const tooltips = page.locator('[data-tooltip], .md3-tooltip-trigger');
            if (await tooltips.count() > 0) {
                await tooltips.first().hover();
                await page.waitForTimeout(500);
            }
            break;

        case 'dialog':
            // Test dialog open/close
            const dialogTriggers = page.locator('button:has-text("Show"), button:has-text("Open")');
            if (await dialogTriggers.count() > 0) {
                await dialogTriggers.first().click();
                await page.waitForTimeout(500);
                // Try to close dialog
                const closeButtons = page.locator('button:has-text("Close"), button:has-text("Cancel"), .md3-dialog__scrim');
                if (await closeButtons.count() > 0) {
                    await closeButtons.first().click();
                }
            }
            break;

        case 'snackbar':
            // Test snackbar show
            const snackbarTriggers = page.locator('button:has-text("Show Snackbar")');
            if (await snackbarTriggers.count() > 0) {
                await snackbarTriggers.first().click();
                await page.waitForTimeout(1000);
            }
            break;

        case 'switch':
            // Test switch toggle
            const switches = page.locator('input[type="checkbox"].md3-switch, .md3-switch input');
            if (await switches.count() > 0) {
                await switches.first().click();
            }
            break;

        case 'checkbox':
            // Test checkbox toggle
            const checkboxes = page.locator('input[type="checkbox"]:not(.md3-switch)');
            if (await checkboxes.count() > 0) {
                await checkboxes.first().click();
            }
            break;

        case 'select':
            // Test select dropdown
            const selects = page.locator('select, .md3-select');
            if (await selects.count() > 0) {
                await selects.first().click();
            }
            break;
    }
}

// Run the test
testAllComponents().catch(console.error);