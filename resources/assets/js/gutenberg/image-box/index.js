/* eslint-disable */
import "./style.editor.scss";
import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import edit from "./edit";
import { InnerBlocks } from "@wordpress/block-editor";
import omit from 'lodash/omit';

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
    },
    isSelected: {
        type: "string",
    }
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
        // const style = {
        //     background: "url("+ url + ")",
        // }
        return (
            <div>
                {attributes.url && (
                    <div
                        style={{background: 'url('+ attributes.url + ');'}}
                        className="wp-block-willamette-blocks-image-box__image"
                    >
                        <div className="wp-block-willamette-blocks-image-box__content">
                            <InnerBlocks.Content />
                        </div>
                    </div>
                )}
            </div>
        );
    },

    edit,

    deprecated: [
    ]
});
