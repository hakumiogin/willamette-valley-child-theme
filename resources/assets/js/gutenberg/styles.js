/* global wp */

wp.domReady( () => {

	wp.blocks.registerBlockStyle( 'core/button', [ 
		{
			name: 'Two-Tone',
			label: 'two tone',
			isDefault: true,
		},
	]);
	wp.blocks.registerBlockStyle( 'core/heading', [ 
		{
			name: 'default',
			label: 'default',
			isDefault: true,
		},
		{
			name: 'Highlighted',
			label: 'highlighted',
		},
		{
			name: 'serif',
			label: 'serif',
		},
		{
			name: 'titlecase',
			label: 'titlecase',
		}
	]);
	wp.blocks.registerBlockStyle( 'core/image', [ 
		{
			name: 'default',
			label: 'default',
			isDefault: true,
		},
		{
			name: 'leaf',
			label: 'leaf overlay',
		},
		{
			name: 'acorn',
			label: 'acorn overlay',
		},
	]);
	wp.blocks.registerBlockStyle( 'willamette-blocks/image-box', [ 
		{
			name: 'overhang-middle',
			label: 'overhang-middle',
			isDefault: true,
		},
		{
			name: 'overhang-left',
			label: 'overhang-left',
		},
		{
			name: 'overhang-right',
			label: 'overhang-right',
		},
		{
			name: 'no-overhang',
			label: 'no-overhang',
		},
		{
			name: 'full-width-center',
			label: 'full-width-center',
		},
		{
			name: 'full-width-center-narrow-acorn',
			label: 'full-width-center-narrow-acorn',
		},
		
	]);

} );
