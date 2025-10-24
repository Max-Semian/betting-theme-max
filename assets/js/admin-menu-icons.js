/**
 * Admin Menu Icons Script
 * 
 * @package Betting_Theme_Max
 */

(function($) {
    'use strict';
    
    $(document).ready(function() {
        
        // Handle media upload for menu icons
        $(document).on('click', '.menu-media-upload-simple', function(e) {
            e.preventDefault();
            
            var button = $(this);
            var itemId = button.data('item-id');
            
            // Create media uploader
            var mediaUploader = wp.media({
                title: 'Select Menu Icon',
                button: {
                    text: 'Use this icon'
                },
                multiple: false,
                library: {
                    type: 'image'
                }
            });
            
            // When an image is selected
            mediaUploader.on('select', function() {
                var attachment = mediaUploader.state().get('selection').first().toJSON();
                
                // Update hidden field with attachment ID
                $('#edit-menu-item-media-icon-' + itemId).val(attachment.id);
                
                // Update URL field
                $('#edit-menu-item-media-icon-url-' + itemId).val(attachment.url);
                
                // Update preview
                var previewHtml = '<img src="' + attachment.url + '" style="max-width: 50px; max-height: 50px; display: block; margin-top: 5px;" />';
                $('#media-icon-preview-' + itemId).html(previewHtml);
                
                // Add remove button if not exists
                if (!$('.menu-media-remove[data-item-id="' + itemId + '"]').length) {
                    button.after('<button type="button" class="button menu-media-remove" data-item-id="' + itemId + '" style="margin-left: 5px;">Remove</button>');
                }
            });
            
            // Open media uploader
            mediaUploader.open();
        });
        
        // Handle icon removal
        $(document).on('click', '.menu-media-remove', function(e) {
            e.preventDefault();
            
            var button = $(this);
            var itemId = button.data('item-id');
            
            // Clear fields
            $('#edit-menu-item-media-icon-' + itemId).val('');
            $('#edit-menu-item-media-icon-url-' + itemId).val('');
            $('#media-icon-preview-' + itemId).html('');
            
            // Remove button
            button.remove();
        });
        
    });
    
})(jQuery);
