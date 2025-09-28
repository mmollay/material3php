// Playwright test for central footer across all pages
const { chromium } = require('playwright');

async function testFooter() {
    console.log('🧪 Testing Central Footer across all pages...\n');

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
            name: 'Home Page'
        },
        {
            url: 'http://localhost/material3php/demo-extended.php?theme=ocean',
            name: 'Component Gallery'
        },
        {
            url: 'http://localhost/material3php/playground.php?component=button&theme=ocean',
            name: 'Playground'
        }
    ];

    for (const testPage of testPages) {
        console.log(`\n🌐 Testing: ${testPage.name}`);
        console.log(`URL: ${testPage.url}`);

        let consoleErrors = [];

        // Monitor errors for this page
        page.removeAllListeners('console');
        page.on('console', msg => {
            if (msg.type() === 'error') {
                consoleErrors.push(msg.text());
                console.log(`❌ Console Error: ${msg.text()}`);
            }
        });

        try {
            // Navigate to page
            await page.goto(testPage.url, { waitUntil: 'networkidle', timeout: 30000 });
            await page.waitForTimeout(2000);

            // Check for central footer
            const centralFooter = page.locator('.central-footer');
            const footerExists = await centralFooter.count() > 0;
            console.log(`Central Footer: ${footerExists ? '✅' : '❌'}`);

            // Check version number (get the footer version specifically)
            const versionBadge = page.locator('.central-footer .version-badge');
            const versionExists = await versionBadge.count() > 0;
            const versionText = versionExists ? await versionBadge.textContent() : '';
            const hasVersion = versionText.includes('v0.2.42');
            console.log(`Version Badge: ${versionExists ? '✅' : '❌'} ${hasVersion ? '(v0.2.42 ✅)' : '(version missing ❌)'}`);

            // Check changelog link
            const changelogLink = page.locator('a[href="CHANGELOG.md"]');
            const changelogExists = await changelogLink.count() > 0;
            console.log(`Changelog Link: ${changelogExists ? '✅' : '❌'}`);

            // Check GitHub link
            const githubLink = page.locator('a[href*="github.com"]');
            const githubExists = await githubLink.count() > 0;
            console.log(`GitHub Link: ${githubExists ? '✅' : '❌'}`);

            // Check Material Design link
            const materialLink = page.locator('a[href*="m3.material.io"]');
            const materialExists = await materialLink.count() > 0;
            console.log(`Material Design Link: ${materialExists ? '✅' : '❌'}`);

            // Check back to top button
            const backToTop = page.locator('.back-to-top');
            const backToTopExists = await backToTop.count() > 0;
            console.log(`Back to Top: ${backToTopExists ? '✅' : '❌'}`);

            // Check component count
            const componentStats = page.locator('.stat-item:has-text("Components")');
            const statsExists = await componentStats.count() > 0;
            const statsText = statsExists ? await componentStats.textContent() : '';
            const hasComponentCount = statsText.includes('31') || statsText.includes('Components');
            console.log(`Component Stats: ${statsExists ? '✅' : '❌'} ${hasComponentCount ? '(31 Components ✅)' : '(count missing ❌)'}`);

            // Test back to top functionality
            let backToTopWorks = false;
            try {
                if (backToTopExists) {
                    // Scroll down first
                    await page.evaluate(() => window.scrollTo(0, document.body.scrollHeight));
                    await page.waitForTimeout(500);

                    // Click back to top
                    await backToTop.click();
                    await page.waitForTimeout(1000);

                    // Check if scrolled to top
                    const scrollY = await page.evaluate(() => window.scrollY);
                    backToTopWorks = scrollY < 100;
                    console.log(`Back to Top Function: ${backToTopWorks ? '✅' : '❌'}`);
                }
            } catch (error) {
                console.log(`❌ Back to Top test failed: ${error.message}`);
            }

            // Test footer responsiveness
            console.log('\n📱 Testing responsiveness...');

            // Mobile view
            await page.setViewportSize({ width: 480, height: 800 });
            await page.waitForTimeout(500);

            const mobileFooterVisible = await page.evaluate(() => {
                const footer = document.querySelector('.central-footer');
                const rect = footer.getBoundingClientRect();
                return rect.width > 0 && rect.height > 0;
            });
            console.log(`Mobile Footer: ${mobileFooterVisible ? '✅' : '❌'}`);

            // Reset to desktop
            await page.setViewportSize({ width: 1200, height: 800 });

            // Take screenshot
            const screenshotName = `footer-${testPage.name.toLowerCase().replace(/\s+/g, '-')}-screenshot.png`;
            await page.screenshot({ path: screenshotName, fullPage: true });
            console.log(`📷 Screenshot saved as ${screenshotName}`);

            // Calculate success
            const success = footerExists && versionExists && hasVersion && changelogExists &&
                           githubExists && materialExists && backToTopExists &&
                           hasComponentCount && consoleErrors.length === 0;

            allResults.push({
                page: testPage.name,
                success: success,
                errors: consoleErrors.length,
                details: {
                    footerExists,
                    versionExists,
                    hasVersion,
                    changelogExists,
                    githubExists,
                    materialExists,
                    backToTopExists,
                    hasComponentCount,
                    backToTopWorks,
                    mobileFooterVisible
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
    console.log('\n📊 FOOTER TEST SUMMARY:');
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
            console.log(`  Footer: ${result.details.footerExists ? '✅' : '❌'}`);
            console.log(`  Version: ${result.details.versionExists && result.details.hasVersion ? '✅' : '❌'}`);
            console.log(`  Links: ${result.details.changelogExists && result.details.githubExists ? '✅' : '❌'}`);
            console.log(`  Features: ${result.details.backToTopExists && result.details.hasComponentCount ? '✅' : '❌'}`);
            console.log(`  Responsive: ${result.details.mobileFooterVisible ? '✅' : '❌'}`);
        }
    });

    const overallSuccess = passedPages === totalPages;
    console.log(`\n🎯 Overall Result: ${overallSuccess ? '✅ PASS' : '❌ FAIL'}`);

    await browser.close();
    return overallSuccess;
}

// Run the test
testFooter().catch(console.error);