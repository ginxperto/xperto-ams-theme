<?php

if (!class_exists('XpertoCustomNavWalker')) {
    class XpertoCustomNavWalker extends Walker_Nav_Menu
    {
        function start_el(&$output, $item, $depth = 0, $args = [], $id = 0)
        {
            /**
             * do not add member on logout users
             */
            if (!is_user_logged_in() && str_contains(strtolower($item->title), 'members')) {
                return;
            }

            $css_classes = array();

            if (is_array($item->classes)) {
                $css_classes = $item->classes;
            }

            $output .= "<li class='" .  implode(" ", $css_classes) . " group'>";

            $is_active = in_array("current_page_item", $css_classes);

            if ($item->url && $item->url != '#') {

                $tw_anchor_class = 'flex items-center p-3 rounded-lg';
                $tw_img_css = 'flex-shrink-0 w-6 h-6 text-xperto-neutral-mid-1 transition duration-75';

                if ($is_active) {
                    $tw_anchor_class .= ' bg-xperto-orange-light-90';
                    $tw_img_css .= ' fill-xperto-orange';
                } else {
                    $tw_anchor_class .= ' hover:bg-xperto-orange-light-90';
                    $tw_img_css .= ' group-hover:fill-xperto-orange';
                }
                $output .= '<a href="' . $item->url . '" class="' . $tw_anchor_class . '">';

                /**
                 * * Add menu SVG icons
                 */

                // we found home menu, add the svg
                if (str_contains(strtolower($item->title), 'home')) {
                    $output .= '<svg class="' . $tw_img_css . '" width="18" height="16" viewBox="0 0 18 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8.76087 4.15039L3.00114 9.5741V15.4275C3.00114 15.579 3.05379 15.7243 3.14749 15.8315C3.24119 15.9386 3.36828 15.9988 3.50079 15.9988L7.00151 15.9879C7.13366 15.9873 7.26021 15.9268 7.35345 15.8197C7.4467 15.7126 7.49905 15.5677 7.49905 15.4166V11.9997C7.49905 11.8482 7.55169 11.7029 7.64539 11.5957C7.73909 11.4886 7.86618 11.4284 7.9987 11.4284H9.99835C10.1309 11.4284 10.258 11.4886 10.3517 11.5957C10.4454 11.7029 10.498 11.8482 10.498 11.9997V15.4154C10.4977 15.4906 10.5104 15.5652 10.5354 15.6348C10.5604 15.7044 10.5972 15.7676 10.6436 15.8209C10.69 15.8742 10.7452 15.9165 10.806 15.9454C10.8667 15.9743 10.9319 15.9891 10.9977 15.9891L14.4973 16C14.563 16 14.6281 15.9852 14.6888 15.9564C14.7495 15.9276 14.8046 15.8854 14.851 15.8322C14.8974 15.7791 14.9342 15.7159 14.9592 15.6465C14.9843 15.577 14.9971 15.5026 14.997 15.4275V9.56926L9.23829 4.15039C9.17062 4.08821 9.0864 4.05431 8.99958 4.05431C8.91277 4.05431 8.82855 4.08821 8.76087 4.15039V4.15039ZM17.8594 7.8372L15.2457 5.38135V0.428474C15.2457 0.314836 15.2062 0.205852 15.136 0.125497C15.0657 0.0451427 14.9704 0 14.871 0H13.1222C13.0228 0 12.9275 0.0451427 12.8572 0.125497C12.787 0.205852 12.7475 0.314836 12.7475 0.428474V3.02232L9.95283 0.390952C9.6844 0.138564 9.34765 0.000582348 9.00011 0.000582348C8.65258 0.000582348 8.31583 0.138564 8.04739 0.390952L0.136629 7.8372C0.0984756 7.8731 0.0669077 7.91727 0.0437416 7.96717C0.0205756 8.01707 0.00626884 8.07172 0.00164472 8.12797C-0.00297939 8.18421 0.00217041 8.24095 0.0167978 8.29491C0.0314252 8.34887 0.0552413 8.399 0.0868756 8.44239L0.883986 9.54989C0.915305 9.5936 0.953878 9.6298 0.997482 9.6564C1.04109 9.683 1.08886 9.69947 1.13806 9.70487C1.18725 9.71027 1.2369 9.70449 1.28413 9.68786C1.33136 9.67124 1.37525 9.64409 1.41328 9.60799L8.76087 2.68583C8.82863 2.62335 8.91306 2.58927 9.00011 2.58927C9.08716 2.58927 9.17159 2.62335 9.23935 2.68583L16.588 9.60678C16.626 9.64295 16.6698 9.67018 16.717 9.68691C16.7642 9.70363 16.8138 9.70952 16.863 9.70423C16.9122 9.69894 16.96 9.68259 17.0036 9.6561C17.0473 9.62961 17.0859 9.59352 17.1173 9.54989L17.9144 8.44239C17.9459 8.39877 17.9695 8.34846 17.9838 8.29436C17.9982 8.24027 18.0031 8.18346 17.9981 8.1272C17.9932 8.07094 17.9786 8.01636 17.9552 7.96659C17.9317 7.91681 17.8999 7.87284 17.8615 7.8372H17.8594Z"/>
                    </svg>';
                }

                // we found community menu, add the svg
                if (str_contains(strtolower($item->title), 'community')) {
                    $output .= '<svg class="' . $tw_img_css . '" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 10.0715C13.8769 10.0715 15.3984 8.55 15.3984 6.6731C15.3984 4.79619 13.8769 3.27466 12 3.27466C10.1231 3.27466 8.60156 4.79619 8.60156 6.6731C8.60156 8.55 10.1231 10.0715 12 10.0715Z" />
                    <path d="M18.875 10.0715C20.0615 10.0715 21.0234 9.10965 21.0234 7.9231C21.0234 6.73655 20.0615 5.77466 18.875 5.77466C17.6885 5.77466 16.7266 6.73655 16.7266 7.9231C16.7266 9.10965 17.6885 10.0715 18.875 10.0715Z" />
                    <path d="M5.125 10.0715C6.31155 10.0715 7.27344 9.10965 7.27344 7.9231C7.27344 6.73655 6.31155 5.77466 5.125 5.77466C3.93845 5.77466 2.97656 6.73655 2.97656 7.9231C2.97656 9.10965 3.93845 10.0715 5.125 10.0715Z" />
                    <path d="M7.2418 12.0007C6.39609 11.3078 5.6302 11.3995 4.65234 11.3995C3.18984 11.3995 2 12.5823 2 14.0359V18.3019C2 18.9331 2.51523 19.4464 3.14883 19.4464C5.88422 19.4464 5.55469 19.4959 5.55469 19.3284C5.55469 16.3055 5.19664 14.0887 7.2418 12.0007Z" />
                    <path d="M12.9302 11.4152C11.2222 11.2728 9.73765 11.4169 8.45715 12.4738C6.31429 14.1902 6.72668 16.5013 6.72668 19.3285C6.72668 20.0765 7.33527 20.6965 8.09465 20.6965C16.34 20.6965 16.6682 20.9624 17.1571 19.8797C17.3175 19.5135 17.2736 19.6299 17.2736 16.1269C17.2736 13.3447 14.8645 11.4152 12.9302 11.4152Z" />
                    <path d="M19.3478 11.3994C18.3646 11.3994 17.6029 11.3086 16.7583 12.0006C18.7882 14.0731 18.4454 16.1387 18.4454 19.3283C18.4454 19.4968 18.1719 19.4463 20.8103 19.4463C21.4665 19.4463 22.0001 18.9146 22.0001 18.2611V14.0358C22.0001 12.5822 20.8103 11.3994 19.3478 11.3994Z" />
                    </svg>';
                }

                // we found members menu, add the svg
                if (str_contains(strtolower($item->title), 'members')) {
                    $output .= '<svg class="' . $tw_img_css . '" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20.545 8.62496C20.6616 8.62874 20.775 8.58613 20.8603 8.50647C20.9456 8.42681 20.9958 8.31659 21 8.19996V6.79996C20.9951 6.68386 20.9445 6.57441 20.8593 6.49539C20.7741 6.41636 20.6611 6.37417 20.545 6.37796H19.786V4.68796C19.7675 4.22275 19.5654 3.78385 19.2238 3.46744C18.8823 3.15102 18.4293 2.98292 17.964 2.99996H5.821C5.35591 2.98319 4.90312 3.15142 4.56181 3.4678C4.2205 3.78418 4.01848 4.22293 4 4.68796L4 19.313C4.01874 19.7778 4.22087 20.2163 4.56215 20.5325C4.90344 20.8486 5.35607 21.0167 5.821 21H17.964C18.4289 21.0167 18.8816 20.8486 19.2228 20.5325C19.5641 20.2163 19.7663 19.7778 19.785 19.313V17.625H20.544C20.6608 17.629 20.7745 17.5865 20.86 17.5068C20.9455 17.4271 20.9958 17.3168 21 17.2V15.8C20.9951 15.6839 20.9445 15.5744 20.8593 15.4954C20.7741 15.4164 20.6611 15.3742 20.545 15.378H19.786V13.128H20.545C20.603 13.1298 20.6608 13.1202 20.7151 13.0997C20.7694 13.0792 20.8191 13.0482 20.8613 13.0084C20.9036 12.9686 20.9376 12.9209 20.9614 12.868C20.9852 12.8151 20.9983 12.758 21 12.7V11.3C20.9951 11.1839 20.9445 11.0744 20.8593 10.9954C20.7741 10.9164 20.6611 10.8742 20.545 10.878H19.786V8.62496H20.545ZM11.893 7.49996C12.5131 7.47777 13.1167 7.70201 13.5719 8.12365C14.0271 8.54529 14.2968 9.13001 14.322 9.74996C14.2968 10.3699 14.0271 10.9546 13.5719 11.3763C13.1167 11.7979 12.5131 12.0222 11.893 12C11.2729 12.0222 10.6693 11.7979 10.2141 11.3763C9.75895 10.9546 9.48925 10.3699 9.464 9.74996C9.48925 9.13001 9.75895 8.54529 10.2141 8.12365C10.6693 7.70201 11.2729 7.47777 11.893 7.49996ZM16.143 15.825C16.1174 16.0261 16.0142 16.2094 15.8554 16.3355C15.6966 16.4616 15.4947 16.5206 15.293 16.5H8.493C8.29125 16.5206 8.08942 16.4616 7.9306 16.3355C7.77178 16.2094 7.66857 16.0261 7.643 15.825V15.15C7.72043 14.5467 8.03026 13.9975 8.50654 13.6193C8.98281 13.2411 9.58791 13.0637 10.193 13.125H10.383C11.3551 13.4997 12.4319 13.4997 13.404 13.125H13.594C14.1991 13.0637 14.8042 13.2411 15.2805 13.6193C15.7567 13.9975 16.0666 14.5467 16.144 15.15L16.143 15.825Z"/>
                    </svg>';
                }
            } else {
                $output .= '<span>';
            }
            // create span container
            if ($is_active) {
                $output .= '<span class="flex-1 ml-2 whitespace-nowrap text-xperto-orange font-bold">';
            } else {
                $output .= '<span class="flex-1 ml-2 whitespace-nowrap text-xperto-neutral-mid-1 group-hover:text-xperto-orange">';
            }
            $output .= $item->title;
            $output .= '</span>';

            if ($item->url && $item->url != '#') {
                $output .= '</a>';
            } else {
                $output .= '</span>';
            }
        }
    }
}
