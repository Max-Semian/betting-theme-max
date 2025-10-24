(function() {
	'use strict';
	
	function initHeroBlock() {
		var wp = window.wp;
		if (!wp || !wp.blocks || !wp.i18n || !wp.element || !wp.blockEditor) {
			setTimeout(function retryInit() {
				if (window.wp && window.wp.blocks && window.wp.i18n) {
					initHeroBlock();
				} else {
					setTimeout(retryInit, 200);
				}
			}, 200);
			return;
		}
	
	const { registerBlockType } = wp.blocks;
	const { __ } = wp.i18n;
	const { 
		InspectorControls,
		RichText,
		URLInput,
		useBlockProps
	} = wp.blockEditor;
	const {
		PanelBody,
		TextControl,
		TextareaControl,
		ColorPicker
	} = wp.components;
	const { Fragment, createElement } = wp.element;

	registerBlockType('betting-theme/hero-block', {
		edit: function(props) {
			const attributes = props.attributes;
			const setAttributes = props.setAttributes;
			
			const blockProps = useBlockProps({
				style: {
					backgroundColor: attributes.backgroundColor
				}
			});

			return createElement(Fragment, null, [
				createElement(InspectorControls, { key: 'inspector' }, [
					createElement(PanelBody, {
						key: 'content',
						title: __('Content Settings', 'betting-theme-max'),
						initialOpen: true
					}, [
						createElement(TextControl, {
							key: 'title',
							label: __('Title', 'betting-theme-max'),
							value: attributes.title,
							onChange: function(value) { setAttributes({ title: value }); }
						}),
						createElement(TextControl, {
							key: 'titleLink',
							label: __('Title Link Text', 'betting-theme-max'),
							value: attributes.titleLink,
							onChange: function(value) { setAttributes({ titleLink: value }); }
						}),
						createElement(TextControl, {
							key: 'titleLinkUrl',
							label: __('Title Link URL', 'betting-theme-max'),
							value: attributes.titleLinkUrl,
							onChange: function(value) { setAttributes({ titleLinkUrl: value }); }
						}),
						createElement(TextControl, {
							key: 'subtitle',
							label: __('Subtitle', 'betting-theme-max'),
							value: attributes.subtitle,
							onChange: function(value) { setAttributes({ subtitle: value }); }
						}),
						createElement(TextareaControl, {
							key: 'description',
							label: __('Description', 'betting-theme-max'),
							value: attributes.description,
							onChange: function(value) { setAttributes({ description: value }); }
						})
					]),
					createElement(PanelBody, {
						key: 'bonus',
						title: __('Bonus Settings', 'betting-theme-max'),
						initialOpen: false
					}, [
						createElement(TextControl, {
							key: 'bonusTitle',
							label: __('Bonus Title', 'betting-theme-max'),
							value: attributes.bonusTitle,
							onChange: function(value) { setAttributes({ bonusTitle: value }); }
						}),
						createElement(TextControl, {
							key: 'bonusAmount',
							label: __('Bonus Amount', 'betting-theme-max'),
							value: attributes.bonusAmount,
							onChange: function(value) { setAttributes({ bonusAmount: value }); }
						}),
						createElement(TextControl, {
							key: 'bonusSubtext',
							label: __('Bonus Subtext', 'betting-theme-max'),
							value: attributes.bonusSubtext,
							onChange: function(value) { setAttributes({ bonusSubtext: value }); }
						}),
						createElement(TextControl, {
							key: 'bonusNote',
							label: __('Bonus Note', 'betting-theme-max'),
							value: attributes.bonusNote,
							onChange: function(value) { setAttributes({ bonusNote: value }); }
						}),
						createElement(TextControl, {
							key: 'buttonText',
							label: __('Button Text', 'betting-theme-max'),
							value: attributes.buttonText,
							onChange: function(value) { setAttributes({ buttonText: value }); }
						}),
						createElement(TextControl, {
							key: 'buttonUrl',
							label: __('Button URL', 'betting-theme-max'),
							value: attributes.buttonUrl,
							onChange: function(value) { setAttributes({ buttonUrl: value }); }
						})
					]),
					createElement(PanelBody, {
						key: 'style',
						title: __('Style Settings', 'betting-theme-max'),
						initialOpen: false
					}, [
						createElement('label', {
							key: 'colorLabel',
							style: { display: 'block', marginBottom: '8px', fontWeight: 600 }
						}, __('Background Color', 'betting-theme-max')),
						createElement(ColorPicker, {
							key: 'backgroundColor',
							color: attributes.backgroundColor,
							onChangeComplete: function(value) { setAttributes({ backgroundColor: value.hex }); }
						})
					])
				]),
				createElement('div', Object.assign({}, blockProps, { key: 'preview' }), 
					createElement('div', { className: 'hero-block__container' }, [
						createElement('div', { key: 'content', className: 'hero-block__content' }, [
							createElement('h1', { key: 'title', className: 'hero-block__title' }, [
								attributes.title + ' ',
								createElement('a', { 
									key: 'link',
									href: attributes.titleLinkUrl, 
									className: 'hero-block__title-link' 
								}, attributes.titleLink)
							]),
							createElement('p', { key: 'subtitle', className: 'hero-block__subtitle' }, attributes.subtitle),
							createElement('p', { key: 'desc', className: 'hero-block__description' }, attributes.description)
						]),
						createElement('div', { key: 'bonus', className: 'hero-block__bonus' }, [
							createElement('div', { key: 'header', className: 'hero-block__bonus-header' }, [
								createElement('div', { key: 'icon', className: 'hero-block__bonus-icon' }, 
									createElement('svg', { width: '32', height: '32', viewBox: '0 0 24 24', fill: 'none' },
										createElement('path', { d: 'M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z', fill: 'currentColor' })
									)
								),
								createElement('div', { key: 'btitle', className: 'hero-block__bonus-title' }, attributes.bonusTitle)
							]),
							createElement('div', { key: 'amount', className: 'hero-block__bonus-amount' }, attributes.bonusAmount),
							createElement('div', { key: 'subtext', className: 'hero-block__bonus-subtext' }, attributes.bonusSubtext),
							createElement('div', { key: 'note', className: 'hero-block__bonus-note' }, attributes.bonusNote),
							createElement('a', { 
								key: 'button',
								href: attributes.buttonUrl, 
								className: 'hero-block__button' 
							}, [
								attributes.buttonText,
								createElement('svg', { key: 'arrow', width: '16', height: '16', viewBox: '0 0 24 24', fill: 'none' },
									createElement('path', { d: 'M5 12H19M19 12L12 5M19 12L12 19', stroke: 'currentColor', strokeWidth: '2', strokeLinecap: 'round', strokeLinejoin: 'round' })
								)
							])
						])
					])
				)
			]);
		},
		save: function() {
			return null;
		}
	});
	
	} // End initHeroBlock
	
	initHeroBlock();
})();
