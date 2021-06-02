import { Component } from "@wordpress/element";
import {
	useBlockProps,
	withColors,
	InnerBlocks,
    MediaPlaceholder,
    BlockControls,
    MediaUpload,
    MediaUploadCheck,
    InspectorControls,
    URLInput
} from "@wordpress/block-editor";
import { __ } from "@wordpress/i18n";
import { isBlobURL } from "@wordpress/blob";
import {
    Spinner,
    withNotices,
    Toolbar,
    IconButton,
    PanelBody,
    TextareaControl,
    SelectControl,
    Dashicon,
    Tooltip,
    TextControl
} from "@wordpress/components";
import { withSelect } from "@wordpress/data";

class ImageBoxEdit extends Component {
    state = {
        selectedLink: null
    };

    componentDidMount() {
        const { attributes, setAttributes } = this.props;
        const { url, id } = attributes;
        if (url && isBlobURL(url) && !id) {
            setAttributes({
                url: "",
                alt: ""
            });
        }
    }
    componentDidUpdate(prevProps) {
        if (prevProps.isSelected && !this.props.isSelected) {
            this.setState({
                selectedLink: null
            });
        }
    }
    onChangeTitle = title => {
        this.props.setAttributes({ title });
    };
    onChangeInfo = info => {
        this.props.setAttributes({ info });
    };
    onSelectImage = ({ id, url, alt }) => {
        this.props.setAttributes({
            id,
            url,
            alt
        });
    };
    onSelectURL = url => {
        this.props.setAttributes({
            url,
            id: null,
            alt: ""
        });
    };
    onUploadError = message => {
        const { noticeOperations } = this.props;
        noticeOperations.createErrorNotice(message);
    };
    removeImage = () => {
        this.props.setAttributes({
            id: null,
            url: "",
            alt: ""
        });
    };
    updateAlt = alt => {
        this.props.setAttributes({
            alt
        });
    };
    onImageSizeChange = url => {
        this.props.setAttributes({
            url
        });
    };
    getImageSizes() {
        const { image, imageSizes } = this.props;
        if (!image) return [];
        let options = [];
        const sizes = image.media_details.sizes;
        for (const key in sizes) {
            const size = sizes[key];
            const imageSize = imageSizes.find(size => size.slug === key);
            if (imageSize) {
                options.push({
                    label: imageSize.name,
                    value: size.source_url
                });
            }
        }
        return options;
    }
    addNewLink = () => {
        const { setAttributes, attributes } = this.props;
        const { social } = attributes;
        setAttributes({
            social: [...social, { icon: "wordpress", link: "" }]
        });
        this.setState({
            selectedLink: social.length
        });
    };
    updateSocialItem = (type, value) => {
        const { setAttributes, attributes } = this.props;
        const { social } = attributes;
        const { selectedLink } = this.state;
        let new_social = [...social];
        new_social[selectedLink][type] = value;
        setAttributes({ social: new_social });
    };
    removeLink = e => {
        e.preventDefault();
        const { setAttributes, attributes } = this.props;
        const { social } = attributes;
        const { selectedLink } = this.state;
        setAttributes({
            social: [
                ...social.slice(0, selectedLink),
                ...social.slice(selectedLink + 1)
            ]
        });
        this.setState({
            selectedLink: null
        });
    };
    onSortEnd = (oldIndex, newIndex) => {
        const { setAttributes, attributes } = this.props;
        const { social } = attributes;
        let new_social = arrayMove(social, oldIndex, newIndex);
        setAttributes({ social: new_social });
        this.setState({ selectedLink: null });
    };
    render() {
        //console.log(this.props);
        const { className, attributes, noticeUI, isSelected } = this.props;
        const { title, info, url, alt, id, social } = attributes;

        return (
            <>
                <InspectorControls>
                    <PanelBody title={__("Image Settings", "willamette-blocks")}>
                        {url && !isBlobURL(url) && (
                            <TextareaControl
                                label={__(
                                    "Alt Text (Alternative Text)",
                                    "willamette-blocks"
                                )}
                                value={alt}
                                onChange={this.updateAlt}
                                help={__(
                                    "Alternative text describes your image to people can't see it. Add a short description with its key details."
                                )}
                            />
                        )}
                        {id && (
                            <SelectControl
                                label={__("Image Size", "willamette-blocks")}
                                options={this.getImageSizes()}
                                onChange={this.onImageSizeChange}
                                value={url}
                            />
                        )}
                    </PanelBody>
                </InspectorControls>
                <BlockControls>
                    {url && (
                        <Toolbar>
                            {id && (
                                <MediaUploadCheck>
                                    <MediaUpload
                                        onSelect={this.onSelectImage}
                                        allowedTypes={["image"]}
                                        value={id}
                                        render={({ open }) => {
                                            return (
                                                <IconButton
                                                    className="components-icon-button components-toolbar__control"
                                                    label={__(
                                                        "Edit Image",
                                                        "willamette-blocks"
                                                    )}
                                                    onClick={open}
                                                    icon="edit"
                                                />
                                            );
                                        }}
                                    />
                                </MediaUploadCheck>
                            )}
                            <IconButton
                                className="components-icon-button components-toolbar__control"
                                label={__("Remove Image", "willamette-blocks")}
                                onClick={this.removeImage}
                                icon="trash"
                            />
                        </Toolbar>
                    )}
                </BlockControls>
                <div className={className}>
                    {url ? (
                        <>
                            <img src={url} alt={alt} />
                            {isBlobURL(url) && <Spinner />}
                        </>
                    ) : (
                        <MediaPlaceholder
                            icon="format-image"
                            onSelect={this.onSelectImage}
                            onSelectURL={this.onSelectURL}
                            onError={this.onUploadError}
                            //accept="image/*"
                            allowedTypes={["image"]}
                            notices={noticeUI}
                        />
                    )}
                    {this.state.selectedLink !== null && (
                        <div
                            className={
                                "wp-block-willamette-blocks-image-box__linkForm"
                            }
                        >
                            <TextControl
                                label={__("Icon", "willamette-blocks")}
                                value={social[this.state.selectedLink].icon}
                                onChange={icon =>
                                    this.updateSocialItem("icon", icon)
                                }
                            />
                            <URLInput
                                label={__("URL", "willamette-blocks")}
                                value={social[this.state.selectedLink].link}
                                onChange={url =>
                                    this.updateSocialItem("link", url)
                                }
                            />
                            <a
                                className="wp-block-willamette-blocks-image-box__removeLink"
                                onClick={this.removeLink}
                            >
                                {__("Remove Link", "willamette-blocks")}
                            </a>
                        </div>
                    )}
					<div className="wp-block-willamette-blocks-image-box__content">
						<InnerBlocks />
					</div>
                </div>
            </>
        );
    }
}

export default withSelect((select, props) => {
    const id = props.attributes.id;
    return {
        image: id ? select("core").getMedia(id) : null,
        imageSizes: select("core/editor").getEditorSettings().imageSizes
    };
})(withNotices(withColors({color: 'color'})((ImageBoxEdit))))
