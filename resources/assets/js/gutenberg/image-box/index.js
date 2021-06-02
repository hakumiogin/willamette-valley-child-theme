/* eslint-disable */
import "./style.editor.scss";
import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import edit from "./edit";
import { InnerBlocks } from "@wordpress/block-editor";
//import { Dashicon } from "@wordpress/components";

const attributes = {
	color: {
		type: "string",
		default: "purple"
	},
    id: {
        type: "number"
    },
    alt: {
        type: "string",
        source: "attribute",
        selector: "img",
        attribute: "alt",
        default: ""
    },
    url: {
        type: "string",
        source: "attribute",
        selector: "img",
        attribute: "src"
    },
};

registerBlockType("willamette-blocks/image-box", {
    title: __("Image Box", "willamette-blocks"),

    description: __(" Block showing a Image and a colored banner beneath. ", "willamette-blocks"),

    icon: "admin-users",

    supports: {
        reusable: false,
        html: false,
		align: true
    },

    category: "madden",

    keywords: [
        __("madden", "willamette-blocks"),
        __("image", "willamette-blocks")
   ],

   attributes,

    save: ({ attributes }) => {
        const { url, alt, id } = attributes;
        return (
            <div>
                {url && (
                    <img
                        src={url}
                        alt={alt}
                        className={id ? `wp-image-${id}` : null}
                    />
                )}
				<div className="wp-block-willamette-blocks-image-box__content">
					<InnerBlocks.Content />
				</div>
            </div>
        );
    },

    edit
});
