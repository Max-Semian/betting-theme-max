<?php
/**
 * Hero Block Template
 *
 * @package Betting_Theme_Max
 */

$title = isset($attributes['title']) ? esc_html($attributes['title']) : '1 Win India -';
$title_link = isset($attributes['titleLink']) ? esc_html($attributes['titleLink']) : 'Official Website';
$title_link_url = isset($attributes['titleLinkUrl']) ? esc_url($attributes['titleLinkUrl']) : '#';
$subtitle = isset($attributes['subtitle']) ? esc_html($attributes['subtitle']) : 'for Sports Betting';
$description = isset($attributes['description']) ? esc_html($attributes['description']) : '';
$bonus_title = isset($attributes['bonusTitle']) ? esc_html($attributes['bonusTitle']) : 'Получите до';
$bonus_amount = isset($attributes['bonusAmount']) ? esc_html($attributes['bonusAmount']) : '80 000 ₽';
$bonus_subtext = isset($attributes['bonusSubtext']) ? esc_html($attributes['bonusSubtext']) : 'бонуса за регистрацию';
$bonus_note = isset($attributes['bonusNote']) ? esc_html($attributes['bonusNote']) : 'вывод без ограничений*';
$button_text = isset($attributes['buttonText']) ? esc_html($attributes['buttonText']) : 'Забрать бонус';
$button_url = isset($attributes['buttonUrl']) ? esc_url($attributes['buttonUrl']) : '#';
$bg_color = isset($attributes['backgroundColor']) ? esc_attr($attributes['backgroundColor']) : '#0A0F1C';

$wrapper_attributes = get_block_wrapper_attributes([
    'class' => 'hero-block',
    'style' => 'background-color: ' . $bg_color
]);
?>

<div <?php echo $wrapper_attributes; ?>>
    <div class="hero-block__container">
        <div class="hero-block__content">
            <h1 class="hero-block__title">
                <?php echo $title; ?> <a href="<?php echo $title_link_url; ?>" class="hero-block__title-link"><?php echo $title_link; ?></a>
            </h1>
            <p class="hero-block__subtitle"><?php echo $subtitle; ?></p>
            <?php if ($description) : ?>
                <p class="hero-block__description"><?php echo $description; ?></p>
            <?php endif; ?>
        </div>
        
        <div class="hero-block__bonus">
            <div class="hero-block__bonus-header">
                <div class="hero-block__bonus-icon">
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/wallet.png' ); ?>" alt="Bonus Icon">
                </div>
                <div class="hero-block__bonus-title"><?php echo $bonus_title; ?></div>
            </div>
            <div class="hero-block__bonus-amount"><?php echo $bonus_amount; ?></div>
            <div class="hero-block__bonus-subtext"><?php echo $bonus_subtext; ?></div>
            <div class="hero-block__bonus-note"><?php echo $bonus_note; ?></div>
            <a href="<?php echo $button_url; ?>" class="hero-block__button">
                <?php echo $button_text; ?>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
        </div>
    </div>
</div>
