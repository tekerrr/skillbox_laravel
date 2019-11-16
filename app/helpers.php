<?php

if (! function_exists('flash')) {

    /**
     * @param $message
     * @param string $type
     */
    function flash($message, $type = 'success')
    {
        session()->flash('message', $message);
        session()->flash('message_type', $type);
    }
}

if (! function_exists('push_all')) {

    /**
     * @param null $title
     * @param null $text
     * @return \App\Service\Pushall|mixed
     */
    function push_all($title = null, $text = null)
    {
        if (is_null($title) || is_null($text)) {
            return app(\App\Service\Pushall::class);
        }

        return app(\App\Service\Pushall::class)->send($title, $text);
    }
}
