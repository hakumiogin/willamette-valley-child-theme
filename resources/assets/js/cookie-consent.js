import cookieConsent from 'js-cookie-consent'

export let cookieStart = () => {
	cookieConsent({
		cookieName: 'cookiesGDPR',
		message: 'By clicking "Accept All," you agree to the use of cookies on your device to enhance your site experience. To learn more about how we use cookies, please see our privacy policy.',
		options: [
			{
				title: 'Marketing personalisation / retargeting cookies',
				description: 'These cookies and pixels are used to make advertising...',
				key: 'marketing',
				disabled: false,
				checked: false
			},
			{
				title: 'Marketing analytics cookies',
				description: 'These cookies collect information that is...',
				key: 'analytics',
				disabled: false,
				checked: false
			}
		],
		expiration: -1,
	});	
}

