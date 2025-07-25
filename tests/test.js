import { Builder, By } from 'selenium-webdriver';

(async function testWebApp() {
  const driver = await new Builder()
    .forBrowser('chrome')
    .usingServer('http://localhost:4444/wd/hub')
    .build();

  try {
    await driver.get('http://host.docker.internal:8080');

    // Get full page text
    const body = await driver.findElement(By.tagName('body'));
    const bodyText = await body.getText();

    // Check for "Search"
    if (bodyText.includes("Search")) {
      console.log("✅ 'Search' found on the page.");
      process.exit(0);
    } else {
      console.error("❌ 'Search' not found on the page.");
      process.exit(1);
    }
  } catch (err) {
    console.error("❌ Test failed:", err);
    process.exit(1);
  } finally {
    await driver.quit();
  }
})();
