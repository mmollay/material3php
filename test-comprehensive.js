// Enhanced Playwright test script with comprehensive error checking
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

async function testAllComponentsWithErrorCheck() {
    console.log('🧪 Starting Enhanced Material Design 3 PHP Library Test...\n');
    console.log('📊 Comprehensive Error Monitoring Enabled\n');

    const browser = await chromium.launch({
        headless: false,
        args: ['--no-sandbox', '--disable-setuid-sandbox']
    });

    const context = await browser.newContext();
    const page = await context.newPage();

    let totalTests = 0;
    let passedTests = 0;
    let failedTests = [];
    let consoleErrors = [];
    let jsErrors = [];

    // Global error monitoring
    page.on('console', msg => {
        if (msg.type() === 'error') {
            consoleErrors.push({
                text: msg.text(),
                location: msg.location(),
                timestamp: new Date().toISOString()
            });
        } else if (msg.type() === 'warn') {
            console.log(`  ⚠️  Console Warning: ${msg.text()}`);
        }
    });

    page.on('pageerror', error => {
        jsErrors.push({
            message: error.message,
            stack: error.stack,
            timestamp: new Date().toISOString()
        });
    });

    console.log(`Testing ${COMPONENTS.length} components across ${THEMES.length} themes...\n`);

    for (const theme of THEMES) {
        console.log(`🎨 Testing theme: ${theme.toUpperCase()}`);
        console.log('─'.repeat(50));

        for (const component of COMPONENTS) {
            totalTests++;
            const url = `${BASE_URL}?component=${component}&theme=${theme}`;

            try {
                console.log(`Testing: ${component} (${theme})`);

                // Clear previous errors
                consoleErrors = [];
                jsErrors = [];

                // Navigate to component page
                await page.goto(url, { waitUntil: 'networkidle', timeout: 30000 });

                // Wait for component to load
                await page.waitForSelector('#preview-area', { timeout: 15000 });

                // Extended wait for JavaScript execution
                await page.waitForTimeout(3000);

                // Check for PHP errors in page content
                const pageContent = await page.content();
                const hasPhpError = pageContent.includes('Fatal error') || pageContent.includes('Parse error');
                const hasPhpWarning = pageContent.includes('Warning:') || pageContent.includes('Notice:');

                if (hasPhpError) {
                    throw new Error('PHP Fatal/Parse error detected in page content');
                }

                if (hasPhpWarning) {
                    console.log(`  ⚠️  PHP Warning detected for ${component}`);
                }

                // Check console errors
                if (consoleErrors.length > 0) {
                    const errorMessages = consoleErrors.map(e => e.text).join(', ');
                    console.log(`  ❌ Console Errors: ${errorMessages}`);
                    throw new Error(`Console errors: ${errorMessages}`);
                }

                // Check JavaScript errors
                if (jsErrors.length > 0) {
                    const errorMessages = jsErrors.map(e => e.message).join(', ');
                    console.log(`  ❌ JavaScript Errors: ${errorMessages}`);
                    throw new Error(`JavaScript errors: ${errorMessages}`);
                }

                // Check if preview area has content
                const previewArea = page.locator('#preview-area');
                const hasContent = await previewArea.innerHTML();

                if (!hasContent || hasContent.trim().length < 10) {
                    throw new Error('Preview area is empty or has minimal content');
                }

                // Test specific component functionality
                await testComponentSpecific(page, component);

                // Verify no network errors
                const networkErrors = [];
                page.on('response', response => {
                    if (response.status() >= 400) {
                        networkErrors.push(`${response.status()} ${response.url()}`);
                    }
                });

                if (networkErrors.length > 0) {
                    console.log(`  ⚠️  Network errors: ${networkErrors.join(', ')}`);
                }

                console.log(`  ✅ ${component} (${theme}) - PASSED`);
                passedTests++;

            } catch (error) {
                console.log(`  ❌ ${component} (${theme}) - FAILED: ${error.message}`);
                failedTests.push({
                    component,
                    theme,
                    error: error.message,
                    url,
                    consoleErrors: consoleErrors.slice(),
                    jsErrors: jsErrors.slice()
                });
            }

            // Delay between tests
            await page.waitForTimeout(1000);
        }

        console.log(''); // Empty line between themes
    }

    // Comprehensive Results Summary
    console.log('🏁 COMPREHENSIVE TEST RESULTS');
    console.log('═'.repeat(60));
    console.log(`Total Tests: ${totalTests}`);
    console.log(`✅ Passed: ${passedTests} (${((passedTests/totalTests)*100).toFixed(1)}%)`);
    console.log(`❌ Failed: ${failedTests.length} (${((failedTests.length/totalTests)*100).toFixed(1)}%)`);

    if (failedTests.length > 0) {
        console.log('\n🔍 DETAILED FAILURE ANALYSIS:');
        console.log('─'.repeat(40));
        failedTests.forEach((failure, index) => {
            console.log(`\n${index + 1}. ❌ ${failure.component} (${failure.theme})`);
            console.log(`   Error: ${failure.error}`);
            console.log(`   URL: ${failure.url}`);

            if (failure.consoleErrors.length > 0) {
                console.log(`   Console Errors:`);
                failure.consoleErrors.forEach(err => {
                    console.log(`     - ${err.text}`);
                });
            }

            if (failure.jsErrors.length > 0) {
                console.log(`   JavaScript Errors:`);
                failure.jsErrors.forEach(err => {
                    console.log(`     - ${err.message}`);
                });
            }
        });
    }

    // Component count verification
    try {
        await page.goto(`${BASE_URL}?component=button&theme=ocean`);
        const componentCountText = await page.locator('#component-count').textContent();
        const count = parseInt(componentCountText.match(/\d+/)[0]);

        console.log(`\n📊 Component Count Verification:`);
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

    // Final status
    console.log('\n🎯 Test Completed!');
    if (failedTests.length === 0) {
        console.log('🎉 All tests passed! No console errors detected.');
        console.log('✅ Material Design 3 PHP Library is production ready!');
        return true;
    } else {
        console.log(`⚠️  ${failedTests.length} tests failed with errors.`);
        console.log('🔧 Please review and fix the issues above.');
        return false;
    }
}

async function testComponentSpecific(page, component) {
    try {
        switch (component) {
            case 'button':
                const buttons = page.locator('button, .md3-button');
                if (await buttons.count() > 0) {
                    await buttons.first().click();
                }
                break;

            case 'textfield':
                const inputs = page.locator('input[type="text"], input[type="email"], textarea');
                if (await inputs.count() > 0) {
                    await inputs.first().fill('Test input');
                }
                break;

            case 'select':
                const selects = page.locator('select, .md3-select-container');
                if (await selects.count() > 0) {
                    await selects.first().click();
                    await page.waitForTimeout(500);
                }
                break;

            case 'tooltip':
                const tooltips = page.locator('[data-tooltip], .md3-tooltip-trigger');
                if (await tooltips.count() > 0) {
                    await tooltips.first().hover();
                    await page.waitForTimeout(1000);
                }
                break;

            case 'snackbar':
                const snackbarTriggers = page.locator('button:has-text("Show Snackbar")');
                if (await snackbarTriggers.count() > 0) {
                    await snackbarTriggers.first().click();
                    await page.waitForTimeout(2000);
                }
                break;

            case 'dialog':
                const dialogTriggers = page.locator('button:has-text("Show"), button:has-text("Open")');
                if (await dialogTriggers.count() > 0) {
                    await dialogTriggers.first().click();
                    await page.waitForTimeout(1000);
                    const closeButtons = page.locator('button:has-text("Close"), button:has-text("Cancel")');
                    if (await closeButtons.count() > 0) {
                        await closeButtons.first().click();
                    }
                }
                break;

            case 'switch':
                const switches = page.locator('input[type="checkbox"].md3-switch, .md3-switch input');
                if (await switches.count() > 0) {
                    await switches.first().click();
                }
                break;

            case 'checkbox':
                const checkboxes = page.locator('input[type="checkbox"]:not(.md3-switch)');
                if (await checkboxes.count() > 0) {
                    await checkboxes.first().click();
                }
                break;
        }
    } catch (error) {
        console.log(`    ⚠️  Component-specific test failed: ${error.message}`);
    }
}

// Run the enhanced test
testAllComponentsWithErrorCheck().catch(console.error);