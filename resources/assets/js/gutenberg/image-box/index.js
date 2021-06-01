/* eslint-disable */
import { registerBlockType } from "@wordpress/blocks"
import { __ } from "@wordpress/i18n"
import "./style.editor.scss"
import { Icon } from '@wordpress/components';
import edit from './edit'

const attributes = {
	color: {
		type: "string"
	}
}

registerBlockType('willamette/image-box', {
	title: __('Madden Image Box', 'mm-willametteValley-child-theme'),
	description: __('Madden block for showing images and content beneath them', 'mm-willametteValley-child-theme'),
	icon: <Icon icon="screenoptions" />,
	category: "madden",
	keywords: __("madden", 'mm-willametteValley-child-theme'),

	attributes,

	save: () => {
		return null
	},

	edit: edit

})