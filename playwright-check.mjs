import { chromium } from 'playwright';

(async () => {
  const url = 'http://127.0.0.1:8000/rooms/101';
  const selector = 'img[alt^="Thumbnail"]';
  const browser = await chromium.launch({ args: ['--no-sandbox'] });
  const page = await browser.newPage();
  const logs = [];

  page.on('console', msg => {
    const text = msg.text();
    const type = msg.type();
    logs.push({ type, text });
    console.log(`[browser][${type}] ${text}`);
  });

  try {
    console.log('goto', url);
    await page.goto(url, { waitUntil: 'networkidle' });

    await page.waitForSelector(selector, { timeout: 8000 });
    console.log('found thumbnail, clicking');
    await page.click(selector);

    await page.waitForTimeout(1500);

    await browser.close();

    const found = logs.some(l => (l.text || '').includes('Missing `Description`') || (l.text || '').includes('aria-describedby'));
    if (found) {
      console.log('RESULT: WARNING_PRESENT');
      process.exitCode = 1;
    } else {
      console.log('RESULT: NO_WARNING');
      process.exitCode = 0;
    }
  } catch (err) {
    console.error('ERROR:', err.message || err);
    try { await browser.close(); } catch (e) {}
    process.exitCode = 2;
  }
})();
