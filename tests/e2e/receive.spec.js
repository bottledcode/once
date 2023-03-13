import {expect, test} from '@playwright/test';


test('test', async ({page}) => {
	const clickMenu = async (link) => {
		if (await page.getByRole('button', {name: 'Open main menu open'}).isVisible()) {
			await page.getByRole('button', {name: 'Open main menu open'}).click();
		}
		await page.getByRole('link', {name: link}).click();
	}
	await page.goto(process.env.APP_URL);
	await page.getByText('Say it securely, once and for all').click();
	await clickMenu('Receive');
	await page.getByPlaceholder('Email Address').click();
	await page.getByPlaceholder('Email Address').fill('receiver@example.com');
	await page.getByLabel('Agree to terms of service').check();
	await page.getByRole('button', {name: 'Sign in'}).click();
	await page.getByLabel('Remember me').check();
	await page.getByRole('button', {name: 'Sign in'}).click();
	await page.locator('#sendto').click();
	const sendUrl = await page.locator('#sendto').inputValue();
	await clickMenu('Logout');
	await page.goto(sendUrl);
	await page.getByPlaceholder('Email Address').click();
	await page.getByPlaceholder('Email Address').fill('sender@example.com');
	await page.getByLabel('Agree to terms of service').check();
	await page.getByRole('button', {name: 'Sign in'}).click();
	await page.getByLabel('Remember me').check();
	await page.getByRole('button', {name: 'Sign in'}).click();
	await page.locator('#editor').getByRole('paragraph').click();
	await page.locator('#editor div').first().fill('test message');
	await page.getByText('Self-destruct').click();
	await page.getByRole('button', {name: 'Send it'}).click();
	await page.locator('#message_link').click();
	const messageUrl = await page.locator('#message_link').inputValue();
	await clickMenu('Logout');
	await page.goto(messageUrl);
	await page.getByPlaceholder('Email Address').click();
	await page.getByPlaceholder('Email Address').fill('receiver@example.com');
	await page.getByLabel('Agree to terms of service').check();
	await page.getByRole('button', {name: 'Sign in'}).click();
	await page.getByLabel('Remember me').check();
	await page.getByRole('button', {name: 'Sign in'}).click();
	await page.getByText('test message').click();
	expect(await page.textContent('#viewer')).toBe('test message');
	await page.reload();
	await page.getByText('No message found Please make sure you are signed in with the correct email addre').click();
});
