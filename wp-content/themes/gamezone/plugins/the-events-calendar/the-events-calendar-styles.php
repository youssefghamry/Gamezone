<?php
// Add plugin-specific colors and fonts to the custom CSS
if ( !function_exists( 'gamezone_tribe_events_get_css' ) ) {
	add_filter( 'gamezone_filter_get_css', 'gamezone_tribe_events_get_css', 10, 4 );
	function gamezone_tribe_events_get_css($css, $colors, $fonts, $scheme='') {
		if (isset($css['fonts']) && $fonts) {
			$css['fonts'] .= <<<CSS
			
.tribe-events-list .tribe-events-list-event-title {
	{$fonts['h3_font-family']}
}
#tribe-events .tribe-events-button,
.tribe-events-button,
.tribe-events-cal-links a,
.tribe-events-sub-nav li a {
	{$fonts['button_font-family']}
	{$fonts['button_font-size']}
	{$fonts['button_font-weight']}
	{$fonts['button_font-style']}
	{$fonts['button_line-height']}
	{$fonts['button_text-decoration']}
	{$fonts['button_text-transform']}
	{$fonts['button_letter-spacing']}
}
#tribe-bar-form button, #tribe-bar-form a,
.tribe-events-read-more {
	{$fonts['button_font-family']}
	{$fonts['button_letter-spacing']}
}
.tribe-events-list .tribe-events-list-separator-month,
.tribe-events-calendar thead th,
.tribe-events-schedule, .tribe-events-schedule h2 {
	{$fonts['h5_font-family']}
}
.single-tribe_events #tribe-events-content .tribe-events-event-meta dt,
.single-tribe_events #tribe-events-content .tribe-events-event-meta dd,
#tribe-bar-form input, #tribe-events-content.tribe-events-month,
#tribe-events-content .tribe-events-calendar div[id*="tribe-events-event-"] h3.tribe-events-month-event-title,
#tribe-mobile-container .type-tribe_events,
.tribe-events-list-widget ol li .tribe-event-title,
.tribe-events-content p {
	{$fonts['p_font-family']}
}
.tribe-events-loop .tribe-event-schedule-details,
#tribe-mobile-container .type-tribe_events .tribe-event-date-start {
	{$fonts['info_font-family']};
}

.tribe-common .tribe-common-c-btn, .tribe-common a.tribe-common-c-btn,
.tribe-common .tribe-events-c-top-bar__datepicker-button,
.tribe-common .tribe-common-b2, .tribe-common .tribe-common-b3,
.tribe-common .tribe-common-b5,
.tribe-common.tribe-events .datepicker .datepicker-switch,
.tribe-common .tribe-events-calendar-month__calendar-event-tooltip-datetime,
.tribe-common.tribe-events .datepicker .day, .tribe-common.tribe-events .datepicker .dow,
.tribe-common.tribe-events .tribe-events-calendar-list__event-date-tag-weekday,
.tribe-common.tribe-events .tribe-events-calendar-month__day-date,
.tribe-common.tribe-events .datepicker .datepicker-months .datepicker-switch,
.tribe-common.tribe-events .datepicker .month, .tribe-common.tribe-events .datepicker .year,
.tribe-common.tribe-events .tribe-events-c-view-selector__list-item-text,
.tribe-common.tribe-events .tribe-common-h7, .tribe-common.tribe-events .tribe-common-h8,
.tribe-common.tribe-events .tribe-common-c-btn-border-small, .tribe-common.tribe-events a.tribe-common-c-btn-border-small,
.tribe-common.tribe-events .tribe-events-c-ical__link,
.tribe-common.tribe-events .tribe-events-c-nav__prev,
.tribe-common.tribe-events .tribe-events-c-nav__next{
	{$fonts['p_font-family']}
}

.tribe-common.tribe-events input::-webkit-input-placeholder {$fonts['p_font-family']}
.tribe-common.tribe-events input::-moz-placeholder          {$fonts['p_font-family']}/* Firefox 19+ */

.tribe-common .tribe-events-calendar-list__month-separator-text,
.tribe-common .tribe-events-calendar-day__type-separator-text{
	{$fonts['h2_font-family']}
}

.tribe-common .tribe-events-calendar-list__event-title-link,
.tribe-common .tribe-events-calendar-day__event-title-link,
.tribe-common .tribe-events-calendar-month-mobile-events__mobile-event-title-link,
.tribe-common .tribe-events-calendar-month__calendar-event-tooltip-title{
	{$fonts['h3_font-family']}
}

.tribe-common.tribe-events .tribe-common-h5{
	{$fonts['h5_font-family']}
}

CSS;

			
			$rad = gamezone_get_border_radius();
			$css['fonts'] .= <<<CSS

#tribe-bar-form button,
#tribe-bar-form a,
#tribe-bar-views .tribe-bar-views-list,
.tribe-events-cal-links a,
.tribe-events-sub-nav li a {
	-webkit-border-radius: {$rad};
	    -ms-border-radius: {$rad};
			border-radius: {$rad};
}

CSS;
		}


		if (isset($css['colors']) && $colors) {
			$css['colors'] .= <<<CSS

/* Filters bar */
#tribe-bar-form {
	color: {$colors['text_dark']};
}
#tribe-bar-form input[type="text"] {
	color: {$colors['text_dark']};
	border-color: {$colors['text_dark']};
}
.tribe-bar-views-list {
	background-color: {$colors['text_link']};
}

.datepicker thead tr:first-child th:hover, .datepicker tfoot tr th:hover {
	color: {$colors['text_link']};
	background: {$colors['text_dark']};
}

/* Content */
.tribe-events-calendar thead th {
	color: {$colors['bg_color']};
	background: {$colors['text_dark']} !important;
	border-color: {$colors['text_dark']} !important;
}
.tribe-events-calendar thead th + th:before {
	background: {$colors['bg_color']};
}
#tribe-events-content .tribe-events-calendar td {
	border-color: {$colors['bd_color']} !important;
}
.tribe-events-calendar td div[id*="tribe-events-daynum-"],
.tribe-events-calendar td div[id*="tribe-events-daynum-"] > a {
	color: {$colors['text_dark']};
}
.tribe-events-calendar td.tribe-events-othermonth {
	color: {$colors['alter_light']};
	background: {$colors['alter_bg_color']} !important;
}
.tribe-events-calendar td.tribe-events-othermonth div[id*="tribe-events-daynum-"],
.tribe-events-calendar td.tribe-events-othermonth div[id*="tribe-events-daynum-"] > a {
	color: {$colors['alter_light']};
}
.tribe-events-calendar td.tribe-events-past div[id*="tribe-events-daynum-"], .tribe-events-calendar td.tribe-events-past div[id*="tribe-events-daynum-"] > a {
	color: {$colors['text_light']};
}
.tribe-events-calendar td.tribe-events-present div[id*="tribe-events-daynum-"],
.tribe-events-calendar td.tribe-events-present div[id*="tribe-events-daynum-"] > a {
	color: {$colors['text_link']};
}
.tribe-events-calendar td.tribe-events-present:before {
	border-color: {$colors['text_link']};
}
.tribe-events-calendar .tribe-events-has-events:after {
	background-color: {$colors['text']};
}
.tribe-events-calendar .mobile-active.tribe-events-has-events:after {
	background-color: {$colors['bg_color']};
}
#tribe-events-content .tribe-events-calendar td,
#tribe-events-content .tribe-events-calendar div[id*="tribe-events-event-"] h3.tribe-events-month-event-title a {
	color: {$colors['text_dark']};
}
#tribe-events-content .tribe-events-calendar div[id*="tribe-events-event-"] h3.tribe-events-month-event-title a:hover {
	color: {$colors['text_link']};
}
#tribe-events-content .tribe-events-calendar td.mobile-active,
#tribe-events-content .tribe-events-calendar td.mobile-active:hover {
	color: {$colors['inverse_link']};
	background-color: {$colors['text_link']};
}
#tribe-events-content .tribe-events-calendar td.mobile-active div[id*="tribe-events-daynum-"] {
	color: {$colors['bg_color']};
	background-color: {$colors['text_dark']};
}
#tribe-events-content .tribe-events-calendar td.tribe-events-othermonth.mobile-active div[id*="tribe-events-daynum-"] a,
.tribe-events-calendar .mobile-active div[id*="tribe-events-daynum-"] a {
	background-color: transparent;
	color: {$colors['bg_color']};
}

/* Tooltip */
.recurring-info-tooltip,
.tribe-events-calendar .tribe-events-tooltip,
.tribe-events-week .tribe-events-tooltip,
.tribe-events-tooltip .tribe-events-arrow {
	color: {$colors['alter_text']};
	background: {$colors['alter_bg_color']};
}
#tribe-events-content .tribe-events-tooltip h4 { 
	color: {$colors['text_link']};
	background: {$colors['text_dark']};
}
.tribe-events-tooltip .tribe-event-duration {
	color: {$colors['text_light']};
}

/* Events list */
.tribe-events-list-separator-month {
	color: {$colors['text_dark']};
}
.tribe-events-list-separator-month:after {
	border-color: {$colors['bd_color']};
}
.tribe-events-list .type-tribe_events + .type-tribe_events,
.tribe-events-day .tribe-events-day-time-slot + .tribe-events-day-time-slot + .tribe-events-day-time-slot {
	border-color: {$colors['bd_color']};
}
.tribe-events-list .tribe-events-event-cost span {
	color: {$colors['bg_color']};
	border-color: {$colors['text_dark']};
	background: {$colors['text_dark']};
}
.tribe-mobile .tribe-events-loop .tribe-events-event-meta {
	color: {$colors['alter_text']};
	border-color: {$colors['alter_bd_color']};
	background-color: {$colors['alter_bg_color']};
}
.tribe-mobile .tribe-events-loop .tribe-events-event-meta a {
	color: {$colors['alter_link']};
}
.tribe-mobile .tribe-events-loop .tribe-events-event-meta a:hover {
	color: {$colors['alter_hover']};
}
.tribe-mobile .tribe-events-list .tribe-events-venue-details {
	border-color: {$colors['alter_bd_color']};
}

/* Events day */
.tribe-events-day .tribe-events-day-time-slot h5 {
	color: {$colors['bg_color']};
	background: {$colors['text_dark']};
}

/* Single Event */
.single-tribe_events .tribe-events-schedule .tribe-events-cost {
	color: {$colors['text_dark']};
}
.single-tribe_events .type-tribe_events {
	border-color: {$colors['bd_color']};
}

.tribe-events-button,
.tribe-common.tribe-events .tribe-events-c-ical__link,
.tribe-common.tribe-events .tribe-events-c-nav__prev,
.tribe-common.tribe-events .tribe-events-c-nav__next,
.tribe-common.tribe-events .tribe-events-c-top-bar__datepicker-button,
.tribe-events-single a.tribe-events-ical, .tribe-events-single a.tribe-events-gcal{
    border-color: {$colors['text_link']};
    background: {$colors['text_link']};
	color: {$colors['inverse_text']};

}
.tribe-common.tribe-events .tribe-events-c-ical__link:hover,
.tribe-common.tribe-events .tribe-events-c-nav__prev:hover,
.tribe-common.tribe-events .tribe-events-c-nav__next:hover,
.tribe-common.tribe-events .tribe-events-c-top-bar__datepicker-button:hover,
.tribe-events-single a.tribe-events-ical:hover, .tribe-events-single a.tribe-events-gcal:hover{
    background: {$colors['text_hover']};
    border-color: {$colors['text_hover']};
    color: {$colors['inverse_text']};
}

.tribe-common.tribe-events .datepicker .day.current{
	background: {$colors['text_link']};
}

.tribe-common.tribe-events .tribe-common-c-btn,
.tribe-common.tribe-events a.tribe-common-c-btn,
.tribe-common.tribe-events .tribe-events-c-events-bar__search-button:before,
.tribe-common.tribe-events .tribe-events-c-view-selector__button:before{
    background: {$colors['text_link']};
}

.tribe-common.tribe-events .tribe-common-c-btn:hover,
.tribe-common.tribe-events a.tribe-common-c-btn:hover{
    background: {$colors['text_hover']};
}

.tribe-common.tribe-events .datepicker .day.active,
.tribe-common.tribe-events .datepicker .day.active.focused,
.tribe-common.tribe-events .datepicker .day.active:focus,
.tribe-common.tribe-events .datepicker .day.active:hover,
.tribe-common.tribe-events .datepicker .month.active,
.tribe-common.tribe-events .datepicker .month.active.focused,
.tribe-common.tribe-events .datepicker .month.active:focus,
.tribe-common.tribe-events .datepicker .month.active:hover,
.tribe-common.tribe-events .datepicker .year.active,
.tribe-common.tribe-events .datepicker .year.active.focused,
.tribe-common.tribe-events .datepicker .year.active:focus,
.tribe-common.tribe-events .datepicker .year.active:hover{
    background: {$colors['text_link']};
}

.tribe-events .datepicker .day.current,
.tribe-events .datepicker .day.current.focused,
.tribe-events .datepicker .day.current:focus,
.tribe-events .datepicker .day.current:hover,
.tribe-events .datepicker .month.current,
.tribe-events .datepicker .month.current.focused,
.tribe-events .datepicker .month.current:focus,
.tribe-events .datepicker .month.current:hover,
.tribe-events .datepicker .year.current,
.tribe-events .datepicker .year.current.focused,
.tribe-events .datepicker .year.current:focus,
.tribe-events .datepicker .year.current:hover{
    background: {$colors['text_link_07']};
}

.tribe-common.tribe-events .tribe-events-calendar-month__multiday-event-bar-inner{
    background: {$colors['text_link']};
}

.tribe-common.tribe-events .tribe-events-calendar-month__multiday-event-bar-title{
    color: {$colors['inverse_text']};
}

.tribe-events.tribe-common .tribe-events-calendar-month__day--current .tribe-events-calendar-month__day-date,
.tribe-events.tribe-common .tribe-events-calendar-month__day--current .tribe-events-calendar-month__day-date-link{
    color: {$colors['text_link']};
}

.tribe-common.tribe-events .tribe-common-c-loader .tribe-common-c-loader__dot {
	background-color: {$colors['text_link']};
}

.tribe-common.tribe-events .tribe-events-calendar-month__mobile-events-icon--event{
    background-color: {$colors['text_link']};
}

.tribe-common.tribe-events .tribe-events-calendar-month__day-cell--selected .tribe-events-calendar-month__day-date{
    color: {$colors['text_link']};
}

.tribe-common.tribe-events .tribe-events-c-top-bar__datepicker-button .tribe-common-c-svgicon path{
    fill: {$colors['inverse_text']};
}
.tribe-events .datepicker th.dow {
	color: {$colors['extra_dark']};
	background-color: {$colors['extra_bg_color']};
}

.single-tribe_events .tribe-events-single .tribe-events-event-meta,
.tribe-events-content {
	color: {$colors['text']};
}

.tribe-events-meta-group .tribe-events-single-section-title {
	color: {$colors['text_dark']};
}

.tribe-common--breakpoint-medium.tribe-events .tribe-events-calendar-list__event-datetime-featured-text,
.tribe-common .tribe-events-calendar-list__event-title-link:hover {
	color: {$colors['text_link']};
}

.tribe-events .tribe-events-calendar-list__event-row--featured .tribe-events-calendar-list__event-date-tag-datetime:after {
	background-color: {$colors['text_link']};
}

CSS;
		}
		
		return $css;
	}
}
?>