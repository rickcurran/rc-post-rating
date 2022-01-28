import { registerBlockType } from '@wordpress/blocks';
import ServerSideRender from '@wordpress/server-side-render';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
 
registerBlockType( 'rcrp-post-rating/post-rating-block', {
    apiVersion: 2,
    title: 'Post Rating',
    icon: 'yes',
    category: 'widgets',
 	attributes: {
        /*classes: {
			type: 'string',
			default: null,
		},
        uptext: {
			type: 'string',
			default: 'Up2',
		},
        downtext: {
			type: 'string',
			default: 'Down2',
		}*/
        
	},
	supports: {
		customClassName: false,
	},
	
    edit: function ( props ) {
        const blockProps = useBlockProps();
		const { attributes, setAttributes } = props;
		// CURRENTLY NOT SETTING ANY ATTRIBUTES WITHIN THE BLOCK ITSELF, MAY BE ADDED IN FUTURE
        //props.setAttributes( { uptext: 'Yes' } );
        //props.setAttributes( { downtext: 'No' } );
        //props.setAttributes( { classes: 'button hollow secondary small' } );

        return (
            <div { ...blockProps }>
                <ServerSideRender
                    block="rcrp-post-rating/post-rating-block"
                    attributes={ props.attributes }
                />
            </div>
        );
    },
} );