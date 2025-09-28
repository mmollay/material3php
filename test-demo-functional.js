// Playwright test for demo-functional.php
const { chromium } = require('playwright');

async function testDemoFunctional() {
    console.log('🧪 Testing demo-functional.php with Playwright...\n');

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
        const url = 'http://localhost/material3php/demo-functional.php?theme=ocean';
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

        // Check for specific elements
        console.log('\n🔍 Checking for key elements...');

        // Check for header
        const header = page.locator('header, .md3-header');
        const headerExists = await header.count() > 0;
        console.log(`Header: ${headerExists ? '✅' : '❌'}`);

        // Check for form
        const form = page.locator('form');
        const formExists = await form.count() > 0;
        console.log(`Form: ${formExists ? '✅' : '❌'}`);

        // Check for switches
        const switches = page.locator('.md3-switch');
        const switchCount = await switches.count();
        console.log(`Switches: ${switchCount > 0 ? `✅ (${switchCount} found)` : '❌'}`);

        // Check for checkboxes
        const checkboxes = page.locator('.md3-checkbox');
        const checkboxCount = await checkboxes.count();
        console.log(`Checkboxes: ${checkboxCount > 0 ? `✅ (${checkboxCount} found)` : '❌'}`);

        // Check for buttons
        const buttons = page.locator('button, .md3-button');
        const buttonCount = await buttons.count();
        console.log(`Buttons: ${buttonCount > 0 ? `✅ (${buttonCount} found)` : '❌'}`);

        // Check for text fields
        const textFields = page.locator('.md3-textfield, .md3-text-field');
        const textFieldCount = await textFields.count();
        console.log(`Text Fields: ${textFieldCount > 0 ? `✅ (${textFieldCount} found)` : '❌'}`);

        // Check for select fields
        const selects = page.locator('.md3-select');
        const selectCount = await selects.count();
        console.log(`Select Fields: ${selectCount > 0 ? `✅ (${selectCount} found)` : '❌'}`);

        // Check for visible content sections
        const demoSections = page.locator('.demo-section');
        const sectionCount = await demoSections.count();
        console.log(`Demo Sections: ${sectionCount > 0 ? `✅ (${sectionCount} found)` : '❌'}`);

        // Check if content is visible
        console.log('\n👁️  Checking visibility...');

        const visibleElements = await page.evaluate(() => {
            const elements = document.querySelectorAll('.demo-section, .md3-switch, .md3-checkbox, button');
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
        await page.screenshot({ path: 'demo-functional-screenshot.png', fullPage: true });
        console.log('📷 Screenshot saved as demo-functional-screenshot.png');

        // Test some interactions
        console.log('\n🖱️  Testing interactions...');

        // Try to click a switch
        try {
            const firstSwitch = switches.first();
            if (await firstSwitch.count() > 0) {
                await firstSwitch.click();
                console.log('✅ Switch click test passed');
            }
        } catch (error) {
            console.log(`❌ Switch click failed: ${error.message}`);
        }

        // Try to fill a text field
        try {
            const firstTextField = page.locator('input[type="text"], input[type="email"]').first();
            if (await firstTextField.count() > 0) {
                await firstTextField.fill('Test input');
                console.log('✅ Text field input test passed');
            }
        } catch (error) {
            console.log(`❌ Text field input failed: ${error.message}`);
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

        const success = consoleErrors.length === 0 && jsErrors.length === 0 && visibleElements.visible > 0;
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
testDemoFunctional().catch(console.error);