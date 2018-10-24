<?php

if (! function_exists('create')) {
    function create($model, $overrides = [], $times = null) {
        return factory($model, $times)->create($overrides);
    }
}

if (! function_exists('make')) {
    function make($model, $overrides = [], $times = null) {
        return factory($model, $times)->make($overrides);
    }
}
