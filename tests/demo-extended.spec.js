const { test, expect } = require('@playwright/test');

test.describe('Material3PHP Demo Extended Gallery', () => {
  test('loads correctly with default theme', async ({ page }) => {
    await page.goto('/material3php/demo-extended.php');

    // Check page loads
    await expect(page).toHaveTitle(/Component Gallery/);

    // Wait for page to fully load
    await page.waitForLoadState('networkidle');

    // Check main heading exists (could be h1 from header or h2 from content)
    await expect(page.locator('h1, h2').first()).toBeVisible();

    // Check some specific sections exist
    await expect(page.locator('text=Lists')).toBeVisible();
  });

  test('works with sunset theme', async ({ page }) => {
    await page.goto('/material3php/demo-extended.php?theme=sunset');
    await page.waitForLoadState('networkidle');

    // Verify page loads
    await expect(page).toHaveTitle(/Component Gallery/);

    // Check theme CSS loads
    const styles = await page.locator('style').first().textContent();
    expect(styles).toContain('--md-sys-color-primary');

    // Check component sections exist
    await expect(page.locator('text=Lists')).toBeVisible();
    await expect(page.locator('text=Form Controls')).toBeVisible();
  });

  test('works with ocean theme', async ({ page }) => {
    await page.goto('/material3php/demo-extended.php?theme=ocean');
    await page.waitForLoadState('networkidle');

    await expect(page).toHaveTitle(/Component Gallery/);
    await expect(page.locator('text=Lists')).toBeVisible();
  });

  test('is responsive on mobile', async ({ page }) => {
    await page.setViewportSize({ width: 375, height: 667 });
    await page.goto('/material3php/demo-extended.php?theme=sunset');
    await page.waitForLoadState('networkidle');

    // Check mobile layout
    await expect(page.locator('text=Lists')).toBeVisible();
  });

  test('is responsive on tablet', async ({ page }) => {
    await page.setViewportSize({ width: 768, height: 1024 });
    await page.goto('/material3php/demo-extended.php?theme=sunset');
    await page.waitForLoadState('networkidle');

    await expect(page.locator('text=Lists')).toBeVisible();
  });

  test('button interactions work', async ({ page }) => {
    await page.goto('/material3php/demo-extended.php?theme=sunset');
    await page.waitForLoadState('networkidle');

    // Test button hover states
    const button = page.locator('button, .md-button').first();
    if (await button.isVisible()) {
      await button.hover();
    }
  });

  test('English internationalization complete', async ({ page }) => {
    await page.goto('/material3php/demo-extended.php?theme=sunset');
    await page.waitForLoadState('networkidle');

    // Check for English text (no German)
    const content = await page.textContent('body');

    // Should contain English terms
    expect(content).toContain('Form Controls');
    expect(content).toContain('Submit');
    expect(content).toContain('Cancel');

    // Should NOT contain German terms (check for common German words that were translated)
    expect(content).not.toContain('Formular-Kontrollen');
    expect(content).not.toContain('Absenden');
    expect(content).not.toContain('Abbrechen');
  });
});