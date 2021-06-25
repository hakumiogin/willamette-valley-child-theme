import cookieConsent from 'js-cookie-consent'

export let cookieStart = () => {
	cookieConsent({
		cookieName: 'cookiesGDPR',
		message: 'We use 🍪 to provide you with the...',
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
		expiration: 7,
	});	
}
