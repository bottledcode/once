import {expect, test} from '@playwright/test';

test('send-and-receive', async ({page, browser}) => {
	const clickMenu = async (link, exact = false) => {
		if (await page.getByRole('button', {name: 'Open main menu open'}).isVisible()) {
			await page.getByRole('button', {name: 'Open main menu open'}).click();
		}
		await page.getByRole('link', {name: link, exact}).click();
	}
	await page.goto(process.env.APP_URL);
	await page.getByText('Say it securely, once and for all').click();
	await clickMenu('Send', true);
	await page.getByPlaceholder('Email Address').click();
	await page.getByPlaceholder('Email Address').fill('sender@example.com');
	await page.getByLabel('Agree to terms of service').check();
	await page.getByRole('button', {name: 'Sign in'}).click();
	await page.getByLabel('Remember me').check();
	await page.getByRole('button', {name: 'Sign in'}).click();
	await page.getByPlaceholder('My best friend').click();
	await page.getByPlaceholder('My best friend').fill('test');
	await page.getByPlaceholder('friend@example.com').click();
	await page.getByPlaceholder('friend@example.com').fill('receiver@example.com');
	await page.locator('#editor').getByRole('paragraph').click();
	await page.locator('#editor div').first().fill('test message');
	await page.getByLabel('Self-destruct').check();
	await page.getByLabel('Time limit').check();
	await page.getByLabel('Password protect').check();
	await page.getByPlaceholder('Enter a password').click();
	await page.getByPlaceholder('Enter a password').fill('password');
	await page.getByRole('button', {name: 'Set the password'}).click();
	await page.getByRole('button', {name: 'Send it'}).click();
	await page.locator('#message_link').click();
	const messageUrl = await page.locator('#message_link').inputValue();
	await expect(messageUrl).toContain('read');
	await page.context().clearCookies();
	await page.goto(messageUrl);
	await page.isVisible('input[placeholder="Email Address"]');
	await page.getByPlaceholder('Email Address').click();
	await page.getByPlaceholder('Email Address').fill('receiver@example.com');
	await page.getByLabel('Agree to terms of service').check();
	await page.getByRole('button', {name: 'Sign in'}).click();
	await page.getByLabel('Remember me').check();
	await page.getByRole('button', {name: 'Sign in'}).click();
	await page.getByPlaceholder('My best friend').click();
	await page.getByPlaceholder('My best friend').fill('password');
	await page.getByRole('button', {name: 'Unlock'}).click();
	await page.getByText('test message').click();
	await clickMenu('Logout');
});
