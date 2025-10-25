(function() {
	'use strict';
	
	function initStepBlock() {
		var wp = window.wp;
		if (!wp || !wp.blocks || !wp.i18n || !wp.element || !wp.blockEditor) {
			setTimeout(function retryInit() {
				if (window.wp && window.wp.blocks && window.wp.i18n) {
					initStepBlock();
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
		useBlockProps,
		MediaUpload,
		MediaUploadCheck
	} = wp.blockEditor;
	const {
		PanelBody,
		TextControl,
		TextareaControl,
		Button,
		IconButton
	} = wp.components;
	const { Fragment, createElement } = wp.element;

	registerBlockType('betting-theme/step-block', {
		edit: function(props) {
			const attributes = props.attributes;
			const setAttributes = props.setAttributes;
			
			const blockProps = useBlockProps({
				style: {
					backgroundColor: attributes.backgroundColor,
					padding: '60px 20px'
				}
			});

			function updateStep(index, key, value) {
				const newSteps = [...attributes.steps];
				newSteps[index][key] = value;
				setAttributes({ steps: newSteps });
			}

			function addStep() {
				const newSteps = [...attributes.steps];
				newSteps.push({
					number: (newSteps.length + 1).toString(),
					title: 'New Step',
					description: 'Step description',
					buttonText: '',
					buttonUrl: '#',
					imageUrl: '',
					imageAlt: 'Step Image'
				});
				setAttributes({ steps: newSteps });
			}

			function removeStep(index) {
				const newSteps = attributes.steps.filter(function(_, i) { return i !== index; });
				setAttributes({ steps: newSteps });
			}

			return createElement(Fragment, null, [
				createElement(InspectorControls, { key: 'inspector' }, [
					createElement(PanelBody, {
						key: 'general',
						title: __('General Settings', 'betting-theme-max'),
						initialOpen: true
					}, [
						createElement(TextControl, {
							key: 'title',
							label: __('Block Title', 'betting-theme-max'),
							value: attributes.title,
							onChange: function(value) { setAttributes({ title: value }); }
						}),
						createElement(TextControl, {
							key: 'backgroundColor',
							label: __('Background Color', 'betting-theme-max'),
							value: attributes.backgroundColor,
							onChange: function(value) { setAttributes({ backgroundColor: value }); }
						})
					]),
					attributes.steps.map(function(step, index) {
						return createElement(PanelBody, {
							key: 'step-' + index,
							title: __('Step ', 'betting-theme-max') + (index + 1),
							initialOpen: false
						}, [
							createElement(TextControl, {
								key: 'number-' + index,
								label: __('Step Number', 'betting-theme-max'),
								value: step.number,
								onChange: function(value) { updateStep(index, 'number', value); }
							}),
							createElement(TextControl, {
								key: 'title-' + index,
								label: __('Title', 'betting-theme-max'),
								value: step.title,
								onChange: function(value) { updateStep(index, 'title', value); }
							}),
							createElement(TextareaControl, {
								key: 'description-' + index,
								label: __('Description', 'betting-theme-max'),
								value: step.description,
								onChange: function(value) { updateStep(index, 'description', value); }
							}),
							createElement(TextControl, {
								key: 'buttonText-' + index,
								label: __('Button Text (optional)', 'betting-theme-max'),
								value: step.buttonText,
								onChange: function(value) { updateStep(index, 'buttonText', value); }
							}),
							createElement(TextControl, {
								key: 'buttonUrl-' + index,
								label: __('Button URL', 'betting-theme-max'),
								value: step.buttonUrl,
								onChange: function(value) { updateStep(index, 'buttonUrl', value); }
							}),
							createElement(MediaUploadCheck, { key: 'media-check-' + index },
								createElement(MediaUpload, {
									key: 'media-' + index,
									onSelect: function(media) { 
										updateStep(index, 'imageUrl', media.url);
										updateStep(index, 'imageAlt', media.alt || 'Step Image');
									},
									allowedTypes: ['image'],
									value: step.imageUrl,
									render: function(obj) {
										return createElement(Button, {
											onClick: obj.open,
											isSecondary: true
										}, step.imageUrl ? __('Change Image', 'betting-theme-max') : __('Select Image', 'betting-theme-max'));
									}
								})
							),
							step.imageUrl && createElement('img', {
								key: 'preview-' + index,
								src: step.imageUrl,
								alt: step.imageAlt,
								style: { maxWidth: '200px', marginTop: '10px' }
							}),
							createElement(Button, {
								key: 'remove-' + index,
								isDestructive: true,
								onClick: function() { removeStep(index); },
								style: { marginTop: '10px' }
							}, __('Remove Step', 'betting-theme-max'))
						]);
					}),
					createElement(Button, {
						key: 'add-step',
						isPrimary: true,
						onClick: addStep,
						style: { margin: '10px' }
					}, __('Add Step', 'betting-theme-max'))
				]),
				createElement('div', blockProps, [
					createElement('div', {
						key: 'container',
						style: {
							maxWidth: '1200px',
							margin: '0 auto'
						}
					}, [
						createElement('h2', {
							key: 'title',
							style: {
								textAlign: 'center',
								fontSize: '32px',
								marginBottom: '40px',
								color: '#0A0F1C'
							}
						}, attributes.title),
						createElement('div', {
							key: 'steps',
							style: {
								display: 'flex',
								flexDirection: 'column',
								gap: '30px'
							}
						}, attributes.steps.map(function(step, index) {
							return createElement('div', {
								key: 'step-item-' + index,
								style: {
									display: 'flex',
									alignItems: 'center',
									gap: '30px',
									padding: '20px',
									backgroundColor: '#fff',
									borderRadius: '8px'
								}
							}, [
								createElement('div', {
									key: 'number',
									style: {
										width: '50px',
										height: '50px',
										borderRadius: '50%',
										backgroundColor: '#1D4ED8',
										color: '#fff',
										display: 'flex',
										alignItems: 'center',
										justifyContent: 'center',
										fontSize: '24px',
										fontWeight: 'bold',
										flexShrink: '0'
									}
								}, step.number),
								createElement('div', {
									key: 'content',
									style: { flex: '1' }
								}, [
									createElement('h3', {
										key: 'step-title',
										style: {
											fontSize: '20px',
											marginBottom: '10px',
											color: '#0A0F1C'
										}
									}, step.title),
									createElement('p', {
										key: 'step-description',
										style: {
											color: '#64748B',
											marginBottom: step.buttonText ? '15px' : '0'
										}
									}, step.description),
									step.buttonText && createElement('a', {
										key: 'step-button',
										href: step.buttonUrl,
										style: {
											display: 'inline-block',
											padding: '10px 20px',
											backgroundColor: '#1D4ED8',
											color: '#fff',
											textDecoration: 'none',
											borderRadius: '6px'
										}
									}, step.buttonText)
								]),
								step.imageUrl && createElement('img', {
									key: 'step-image',
									src: step.imageUrl,
									alt: step.imageAlt,
									style: {
										maxWidth: '200px',
										height: 'auto',
										borderRadius: '8px'
									}
								})
							]);
						}))
					])
				])
			]);
		},

		save: function() {
			return null;
		}
	});
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initStepBlock);
	} else {
		initStepBlock();
	}
})();
