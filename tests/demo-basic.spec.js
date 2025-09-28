const { test, expect } = require('@playwright/test');

test.describe('Material3PHP Demo Extended - Basic Tests', () => {
  test('page loads without errors', async ({ page }) => {
    // Listen for console errors
    const errors = [];
    page.on('console', msg => {
      if (msg.type() === 'error') {
        errors.push(msg.text());
      }
    });

    // Listen for page errors
    page.on('pageerror', error => {
      errors.push(error.message);
    });

    await page.goto('/material3php/demo-extended.php');

    // Check page loads with correct title
    await expect(page).toHaveTitle(/Component Gallery/);

    // Wait for page to be ready
    await page.waitForLoadState('networkidle');

    // Check that no console errors occurred
    expect(errors).toHaveLength(0);

    // Take a screenshot for verification
    await page.screenshot({ path: 'test-results/demo-extended-basic.png' });
  });

  test('different themes work', async ({ page }) => {
    // Test sunset theme
    await page.goto('/material3php/demo-extended.php?theme=sunset');
    await expect(page).toHaveTitle(/Component Gallery/);
    await page.waitForLoadState('networkidle');

    // Test ocean theme
    await page.goto('/material3php/demo-extended.php?theme=ocean');
    await expect(page).toHaveTitle(/Component Gallery/);
    await page.waitForLoadState('networkidle');

    // Test default theme
    await page.goto('/material3php/demo-extended.php');
    await expect(page).toHaveTitle(/Component Gallery/);
    await page.waitForLoadState('networkidle');
  });

  test('page has basic CSS and structure', async ({ page }) => {
    await page.goto('/material3php/demo-extended.php?theme=sunset');
    await page.waitForLoadState('networkidle');

    // Check that CSS variables are defined (Material Design 3 colors)
    const styles = await page.evaluate(() => {
      const styles = getComputedStyle(document.documentElement);
      return styles.getPropertyValue('--md-sys-color-primary');
    });

    expect(styles).toBeTruthy(); // Should have some color value
  });

  test('is mobile responsive', async ({ page }) => {
    await page.setViewportSize({ width: 375, height: 667 });
    await page.goto('/material3php/demo-extended.php?theme=sunset');
    await page.waitForLoadState('networkidle');

    // Just verify page loads on mobile without specific content checks
    await expect(page).toHaveTitle(/Component Gallery/);
  });
});