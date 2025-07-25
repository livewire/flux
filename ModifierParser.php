<?php

namespace App\Actions;

class ModifierParser
{
    /**
     * Create a new class instance.
     */
    public function __invoke($kbd)
    {
        $modifiers = [
            '⌘' => 'cmd',      // Command ( key)
            '⇧' => 'shift',     // Shift
            '⌥' => 'alt',       // Option/Alt
            '⌃' => 'ctrl',      // Control
            '⌫' => 'backspace', // Delete (backward)
            '⌦' => 'delete',    // Forward Delete
            '⎋' => 'escape',    // Escape
            '↩' => 'enter',     // Return/Enter
            '⇥' => 'tab',       // Tab
            '␣' => 'space',     // Spacebar
            '↑' => 'up',        // Up Arrow
            '↓' => 'down',      // Down Arrow
            '←' => 'left',      // Left Arrow
            '→' => 'right',     // Right Arrow
            '⇞' => 'pageup',    // Page Up
            '⇟' => 'pagedown',  // Page Down
            '↖' => 'home',      // Home
            '↘' => 'end',       // End
            '' => 'capslock',  // Caps Lock
            '' => 'fn',        // Function key
            'F1' => 'f1',
            'F2' => 'f2',
            'F3' => 'f3',
            'F4' => 'f4',
            'F5' => 'f5',
            'F6' => 'f6',
            'F7' => 'f7',
            'F8' => 'f8',
            'F9' => 'f9',
            'F10' => 'f10',
            'F11' => 'f11',
            'F12' => 'f12',
        ];

        // Split into individual characters
        $chars = preg_split('//u', $kbd, -1, PREG_SPLIT_NO_EMPTY);
        // Extract modifiers and key
        $alpineModifiers = [];
        $key = '';

        foreach ($chars as $char) {
            if (isset($modifiers[$char])) {
                $alpineModifiers[] = $modifiers[$char];
            } else {
                $key = strtolower($char);
            }
        }

        return implode('.', [...$alpineModifiers, $key]);
    }
}
