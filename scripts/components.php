<?php

/**
 * return input string
 */
function input(
  $id = '',
  $name = '',
  $label = '',
  $placeholder = '',
  $help = '',
  $value = '',
  $class = '',
  $vue = ''
) {

  $input = '
      <div class="field">
        <label for="' . $id . '" class="label is-small" style="font-family: \'Roboto Mono\', monospace;">' . $label . '</label>
        <div class="control">
          <input id="' . $id . '" name="' . $name . '" type="text" class="input is-small ' . $class . '" placeholder="' . $placeholder . '" spellcheck="false" style="font-family: \'Roboto Mono\', monospace;" value="' . $value . '" ' . $vue . '>
        </div>
        <p class="help">' . $help . '</p>
      </div>
    ';

  return $input;
}

/**
 * return button string
 */
function button(
  $id = '',
  $name = '',
  $button_text = 'Click me',
  $class = '',
  $vue = ''
) {

  $button = '
      <div class="field">
        <div class="control">
          <a id="' . $id . '" name="' . $name . '" class="button ' . $class . '" style="font-family: \'Roboto Mono\', monospace;"  ' . $vue . '>' . $button_text . '</a>
        </div>
      </div>
    ';

  return $button;
}
