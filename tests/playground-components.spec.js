const { test, expect } = require('@playwright/test');

test.describe('Material3PHP Playground Components', () => {
  const components = ['datetimepicker', 'select', 'snackbar', 'tooltip'];
  const theme = 'ocean';

  components.forEach(component => {
    test(`${component} component loads without errors`, async ({ page }) => {
      const url = `http://localhost/material3php/playground.php?component=${component}&theme=${theme}`;

      // Navigate to the component page
      await page.goto(url);

      // Check that the page loads without critical errors
      await expect(page.locator('body')).toBeVisible();

      // Check that the page title is correct
      await expect(page).toHaveTitle(/Material Design 3 PHP Library/);

      // Check that no PHP fatal errors are shown
      await expect(page.locator('body')).not.toContainText('Fatal error');
      await expect(page.locator('body')).not.toContainText('Parse error');

      // Check that Material3PHP CSS is loaded
      const hasColors = await page.evaluate(() => {
        const root = getComputedStyle(document.documentElement);
        return root.getPropertyValue('--md-sys-color-primary').trim() !== '';
      });
      expect(hasColors).toBe(true);

      // Check that the component section exists
      await expect(page.locator('.playground-content, .component-demo, .demo-section')).toBeVisible();
    });
  });

  test('playground navigation works', async ({ page }) => {
    await page.goto('http://localhost/material3php/playground.php?theme=ocean');

    // Check that navigation sidebar exists
    await expect(page.locator('.sidebar, .nav-sidebar, .playground-nav')).toBeVisible();

    // Test clicking on select component
    const selectLink = page.locator('a[href*="component=select"]').first();
    if (await selectLink.isVisible()) {
      await selectLink.click();
      await expect(page).toHaveURL(/component=select/);
    }
  });

  test('theme switching works in playground', async ({ page }) => {
    await page.goto('http://localhost/material3php/playground.php?component=select&theme=default');

    // Get the initial primary color
    const defaultColor = await page.evaluate(() => {
      const root = getComputedStyle(document.documentElement);
      return root.getPropertyValue('--md-sys-color-primary').trim();
    });

    // Switch to ocean theme
    await page.goto('http://localhost/material3php/playground.php?component=select&theme=ocean');

    // Get the ocean theme primary color
    const oceanColor = await page.evaluate(() => {
      const root = getComputedStyle(document.documentElement);
      return root.getPropertyValue('--md-sys-color-primary').trim();
    });

    // Colors should be different
    expect(defaultColor).not.toBe(oceanColor);
    expect(oceanColor).toBe('#0061A4'); // Ocean theme primary color
  });
});