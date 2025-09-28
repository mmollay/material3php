// Playwright test for playground.php
const { chromium } = require('playwright');

async function testPlayground() {
    console.log('🧪 Testing playground.php with Playwright...\n');

    const browser = await chromium.launch({
        headless: false,
        args: ['--no-sandbox', '--disable-setuid-sandbox']
    });

    const context = await browser.newContext();
    const page = await context.newPage();

    let consoleErrors = [];
    let jsErrors = [];

    // Monitor console and JavaScript errors
    page.on('console', msg => {
        if (msg.type() === 'error') {
            consoleErrors.push({
                text: msg.text(),
                location: msg.location(),
                timestamp: new Date().toISOString()
            });
            console.log(`❌ Console Error: ${msg.text()}`);
        } else if (msg.type() === 'warn') {
            console.log(`⚠️  Console Warning: ${msg.text()}`);
        } else if (msg.type() === 'log') {
            console.log(`📝 Console Log: ${msg.text()}`);
        }
    });

    page.on('pageerror', error => {
        jsErrors.push({
            message: error.message,
            stack: error.stack,
            timestamp: new Date().toISOString()
        });
        console.log(`❌ JavaScript Error: ${error.message}`);
    });

    try {
        const url = 'http://localhost/material3php/playground.php?component=toolbar&theme=ocean';
        console.log(`🌐 Loading: ${url}`);

        // Navigate to page
        await page.goto(url, { waitUntil: 'networkidle', timeout: 30000 });

        // Wait for page to load
        await page.waitForTimeout(3000);

        // Check for PHP errors in page content
        const pageContent = await page.content();
        console.log('Page content length:', pageContent.length);

        if (pageContent.includes('Fatal error') || pageContent.includes('Parse error') || pageContent.includes('Warning:') || pageContent.includes('Notice:')) {
            console.log('❌ PHP error detected in page content');
            console.log('First 500 chars of content:', pageContent.substring(0, 500));
            return false;
        }

        // Check if page has content
        const bodyContent = await page.locator('body').innerHTML();
        if (!bodyContent || bodyContent.trim().length < 100) {
            console.log('❌ Page body is empty or has minimal content');
            return false;
        }

        // Check for specific playground elements
        console.log('\n🔍 Checking for key elements...');

        // Check for playground header
        const header = page.locator('.playground-header');
        const headerExists = await header.count() > 0;
        console.log(`Playground Header: ${headerExists ? '✅' : '❌'}`);

        // Check for sidebar
        const sidebar = page.locator('.playground-sidebar');
        const sidebarExists = await sidebar.count() > 0;
        console.log(`Sidebar: ${sidebarExists ? '✅' : '❌'}`);

        // Check for preview area
        const preview = page.locator('.component-preview');
        const previewExists = await preview.count() > 0;
        console.log(`Preview Area: ${previewExists ? '✅' : '❌'}`);

        // Check for config panel
        const config = page.locator('.config-panel');
        const configExists = await config.count() > 0;
        console.log(`Config Panel: ${configExists ? '✅' : '❌'}`);

        // Check for theme selector
        const themeSelector = page.locator('.theme-selector-compact');
        const themeSelectorExists = await themeSelector.count() > 0;
        console.log(`Theme Selector: ${themeSelectorExists ? '✅' : '❌'}`);

        // Check for mode toggle
        const modeToggle = page.locator('.mode-toggle');
        const modeToggleExists = await modeToggle.count() > 0;
        console.log(`Mode Toggle: ${modeToggleExists ? '✅' : '❌'}`);

        // Check if content is visible
        console.log('\n👁️  Checking visibility...');

        const visibleElements = await page.evaluate(() => {
            const elements = document.querySelectorAll('.playground-header, .playground-sidebar, .component-preview, .config-panel');
            let visibleCount = 0;
            elements.forEach(el => {
                const rect = el.getBoundingClientRect();
                const computedStyle = window.getComputedStyle(el);
                if (rect.width > 0 && rect.height > 0 &&
                    computedStyle.display !== 'none' &&
                    computedStyle.visibility !== 'hidden') {
                    visibleCount++;
                }
            });
            return {
                total: elements.length,
                visible: visibleCount
            };
        });

        console.log(`Elements visible: ${visibleElements.visible}/${visibleElements.total}`);

        // Take a screenshot
        await page.screenshot({ path: 'playground-screenshot.png', fullPage: true });
        console.log('📷 Screenshot saved as playground-screenshot.png');

        // Test some interactions
        console.log('\n🖱️  Testing interactions...');

        // Try to click a component in sidebar
        try {
            const buttonComponent = page.locator('a[href*="component=button"]');
            if (await buttonComponent.count() > 0) {
                await buttonComponent.click();
                await page.waitForTimeout(1000);
                console.log('✅ Component navigation test passed');
            }
        } catch (error) {
            console.log(`❌ Component navigation failed: ${error.message}`);
        }

        // Try to toggle theme dropdown
        try {
            const themeToggle = page.locator('.theme-toggle');
            if (await themeToggle.count() > 0) {
                await themeToggle.click();
                await page.waitForTimeout(500);
                console.log('✅ Theme toggle test passed');
            }
        } catch (error) {
            console.log(`❌ Theme toggle failed: ${error.message}`);
        }

        // Summary
        console.log('\n📊 SUMMARY:');
        console.log(`Console Errors: ${consoleErrors.length}`);
        console.log(`JavaScript Errors: ${jsErrors.length}`);
        console.log(`Elements found: ${visibleElements.total}`);
        console.log(`Elements visible: ${visibleElements.visible}`);

        if (consoleErrors.length > 0) {
            console.log('\n❌ Console Errors:');
            consoleErrors.forEach((error, i) => {
                console.log(`${i + 1}. ${error.text}`);
            });
        }

        if (jsErrors.length > 0) {
            console.log('\n❌ JavaScript Errors:');
            jsErrors.forEach((error, i) => {
                console.log(`${i + 1}. ${error.message}`);
            });
        }

        const success = consoleErrors.length === 0 && jsErrors.length === 0 && visibleElements.visible >= 3;
        console.log(`\n🎯 Overall Result: ${success ? '✅ PASS' : '❌ FAIL'}`);

        return success;

    } catch (error) {
        console.log(`❌ Test failed with error: ${error.message}`);
        return false;
    } finally {
        await browser.close();
    }
}

// Run the test
testPlayground().catch(console.error);