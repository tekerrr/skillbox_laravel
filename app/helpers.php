<?php

if (! function_exists('flash')) {
    /**
     * @param string $message
     * @param string $type
     */
    function flash(string $message, string $type = 'success')
    {
        session()->flash('message', $message);
        session()->flash('message_type', $type);
    }
}

if (! function_exists('push_all_to_admin')) {
    /**
     * @param null $title
     * @param null $text
     * @return \App\Service\PushAllToAdmin|mixed|
     */
    function push_all_to_admin($title = null, $text = null)
    {
        if (is_null($title) && is_null($text)) {
            return app(\App\Service\PushAllToAdmin::class);
        }

        return app(\App\Service\PushAllToAdmin::class)->send($title, $text);
    }
}if(! function_exists('anchor')) {
    /**
     * @param string $href
     * @param string $name
     * @return string
     */
    function anchor(string $href, string $name = '')
    {
        $name = $name ?: $href;

        return '<a href="' . $href . '">' . $name . '</a>';
    }
}
