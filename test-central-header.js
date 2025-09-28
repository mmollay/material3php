// Playwright test for central header across all pages
const { chromium } = require('playwright');

async function testCentralHeader() {
    console.log('🧪 Testing Central Header across all pages...\n');

    const browser = await chromium.launch({
        headless: false,
        args: ['--no-sandbox', '--disable-setuid-sandbox']
    });

    const context = await browser.newContext();
    const page = await context.newPage();

    let allResults = [];

    // Test different pages
    const testPages = [
        {
            url: 'http://localhost/material3php/index.php?theme=ocean',
            name: 'Home Page',
            expectedTitle: 'Material Design 3 PHP Library'
        },
        {
            url: 'http://localhost/material3php/demo-extended.php?theme=ocean',
            name: 'Component Gallery',
            expectedTitle: 'Component Gallery'
        },
        {
            url: 'http://localhost/material3php/playground.php?component=button&theme=ocean',
            name: 'Playground',
            expectedTitle: 'MD3 Playground'
        }
    ];

    for (const testPage of testPages) {
        console.log(`\n🌐 Testing: ${testPage.name}`);
        console.log(`URL: ${testPage.url}`);

        let consoleErrors = [];
        let jsErrors = [];

        // Monitor errors for this page
        page.removeAllListeners('console');
        page.removeAllListeners('pageerror');

        page.on('console', msg => {
            if (msg.type() === 'error') {
                consoleErrors.push(msg.text());
                console.log(`❌ Console Error: ${msg.text()}`);
            }
        });

        page.on('pageerror', error => {
            jsErrors.push(error.message);
            console.log(`❌ JavaScript Error: ${error.message}`);
        });

        try {
            // Navigate to page
            await page.goto(testPage.url, { waitUntil: 'networkidle', timeout: 30000 });
            await page.waitForTimeout(2000);

            // Check for central header
            const centralHeader = page.locator('.central-header');
            const headerExists = await centralHeader.count() > 0;
            console.log(`Central Header: ${headerExists ? '✅' : '❌'}`);

            // Check page title in header
            const headerTitle = await page.locator('.central-header h1').textContent();
            const titleCorrect = headerTitle && headerTitle.includes(testPage.expectedTitle);
            console.log(`Header Title: ${titleCorrect ? '✅' : '❌'} (${headerTitle})`);

            // Check navigation menu
            const navMenu = page.locator('.nav-menu-container');
            const navMenuExists = await navMenu.count() > 0;
            console.log(`Navigation Menu: ${navMenuExists ? '✅' : '❌'}`);

            // Check theme selector
            const themeSelector = page.locator('.theme-selector-compact');
            const themeSelectorExists = await themeSelector.count() > 0;
            console.log(`Theme Selector: ${themeSelectorExists ? '✅' : '❌'}`);

            // Check mode toggle
            const modeToggle = page.locator('.mode-toggle');
            const modeToggleExists = await modeToggle.count() > 0;
            console.log(`Mode Toggle: ${modeToggleExists ? '✅' : '❌'}`);

            // Test navigation menu interaction
            let navMenuWorks = false;
            try {
                if (navMenuExists) {
                    await page.locator('.nav-menu-toggle').click();
                    await page.waitForTimeout(500);
                    const dropdown = page.locator('.nav-menu-dropdown.show');
                    navMenuWorks = await dropdown.count() > 0;
                    console.log(`Nav Menu Interaction: ${navMenuWorks ? '✅' : '❌'}`);

                    // Close dropdown
                    await page.keyboard.press('Escape');
                }
            } catch (error) {
                console.log(`❌ Nav Menu Interaction failed: ${error.message}`);
            }

            // Test theme selector interaction
            let themeSelectorWorks = false;
            try {
                if (themeSelectorExists) {
                    await page.locator('.theme-toggle').click();
                    await page.waitForTimeout(500);
                    const dropdown = page.locator('.theme-dropdown.show');
                    themeSelectorWorks = await dropdown.count() > 0;
                    console.log(`Theme Selector Interaction: ${themeSelectorWorks ? '✅' : '❌'}`);

                    // Close dropdown
                    await page.keyboard.press('Escape');
                }
            } catch (error) {
                console.log(`❌ Theme Selector Interaction failed: ${error.message}`);
            }

            // Take screenshot
            const screenshotName = `${testPage.name.toLowerCase().replace(/\s+/g, '-')}-screenshot.png`;
            await page.screenshot({ path: screenshotName, fullPage: true });
            console.log(`📷 Screenshot saved as ${screenshotName}`);

            // Calculate success
            const success = headerExists && titleCorrect && navMenuExists && themeSelectorExists &&
                           modeToggleExists && consoleErrors.length === 0 && jsErrors.length === 0;

            allResults.push({
                page: testPage.name,
                success: success,
                errors: consoleErrors.length + jsErrors.length,
                details: {
                    headerExists,
                    titleCorrect,
                    navMenuExists,
                    themeSelectorExists,
                    modeToggleExists,
                    navMenuWorks,
                    themeSelectorWorks
                }
            });

            console.log(`Page Result: ${success ? '✅ PASS' : '❌ FAIL'}`);

        } catch (error) {
            console.log(`❌ Test failed for ${testPage.name}: ${error.message}`);
            allResults.push({
                page: testPage.name,
                success: false,
                errors: 1,
                error: error.message
            });
        }
    }

    // Overall summary
    console.log('\n📊 OVERALL SUMMARY:');
    const totalPages = allResults.length;
    const passedPages = allResults.filter(r => r.success).length;

    console.log(`Pages tested: ${totalPages}`);
    console.log(`Pages passed: ${passedPages}`);
    console.log(`Success rate: ${Math.round((passedPages / totalPages) * 100)}%`);

    allResults.forEach(result => {
        console.log(`\n${result.page}: ${result.success ? '✅ PASS' : '❌ FAIL'}`);
        if (result.error) {
            console.log(`  Error: ${result.error}`);
        } else if (result.details) {
            console.log(`  Header: ${result.details.headerExists ? '✅' : '❌'}`);
            console.log(`  Title: ${result.details.titleCorrect ? '✅' : '❌'}`);
            console.log(`  Nav Menu: ${result.details.navMenuExists ? '✅' : '❌'}`);
            console.log(`  Theme Selector: ${result.details.themeSelectorExists ? '✅' : '❌'}`);
            console.log(`  Mode Toggle: ${result.details.modeToggleExists ? '✅' : '❌'}`);
        }
    });

    const overallSuccess = passedPages === totalPages;
    console.log(`\n🎯 Overall Result: ${overallSuccess ? '✅ PASS' : '❌ FAIL'}`);

    await browser.close();
    return overallSuccess;
}

// Run the test
testCentralHeader().catch(console.error);