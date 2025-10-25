<?php
/**
 * Step Block Template
 *
 * @package Betting_Theme_Max
 */

$title = isset($attributes['title']) ? esc_html($attributes['title']) : 'Как использовать промокод?';
$steps = isset($attributes['steps']) ? $attributes['steps'] : array();
$bg_color = isset($attributes['backgroundColor']) ? esc_attr($attributes['backgroundColor']) : '#F8F9FA';

$wrapper_attributes = get_block_wrapper_attributes([
    'class' => 'step-block',
    'style' => 'background-color: ' . $bg_color
]);
?>

<div <?php echo $wrapper_attributes; ?>>
    <div class="step-block__container">
        <?php if ($title) : ?>
            <h2 class="step-block__title"><?php echo $title; ?></h2>
        <?php endif; ?>
        
        <div class="step-block__steps">
            <?php foreach ($steps as $index => $step) : ?>
                <div class="step-block__item <?php echo $index % 2 === 0 ? 'step-block__item--left' : 'step-block__item--right'; ?>">
                    <div class="step-block__number" data-step="<?php echo esc_attr($step['number']); ?>">
                        <span><?php echo esc_html($step['number']); ?></span>
                    </div>
                    
                    <div class="step-block__content">
                        <h3 class="step-block__step-title"><?php echo esc_html($step['title']); ?></h3>
                        <p class="step-block__description"><?php echo esc_html($step['description']); ?></p>
                        <?php if (!empty($step['buttonText'])) : ?>
                            <a href="<?php echo esc_url($step['buttonUrl']); ?>" class="step-block__button">
                                <?php echo esc_html($step['buttonText']); ?>
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>
                        <?php endif; ?>
                    </div>
                    
                    <?php if (!empty($step['imageUrl'])) : ?>
                        <div class="step-block__image">
                            <img src="<?php echo esc_url($step['imageUrl']); ?>" 
                                 alt="<?php echo esc_attr($step['imageAlt']); ?>" 
                                 loading="lazy">
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
