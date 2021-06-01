import { Component } from "@wordpress/element"
import { BlockEditor } from "@wordpress/editor"
const el = wp.element.createElement

class ImageBoxEdit extends Component {
	onChangetitle () {
	}
	render () {
		return (
			el('innerBlocks', null, 'hello')
		)
	}
}


export default ImageBoxEdit