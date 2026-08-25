<?php

namespace Flux\Code;

use Phiki\Exceptions\UnrecognisedGrammarException;
use Phiki\Phiki;

class PhikiHighlighter
{
    protected Phiki $phiki;

    public function __construct(?Phiki $phiki = null)
    {
        if (! class_exists(Phiki::class)) {
            throw new \LogicException('The Phiki highlighter requires phiki/phiki. Install it with: composer require phiki/phiki');
        }

        $this->phiki = $phiki ?? new Phiki;

        $this->phiki
            ->theme('flux-light', __DIR__.'/../../resources/themes/flux-light.json')
            ->theme('flux-dark', __DIR__.'/../../resources/themes/flux-dark.json');
    }

    public function __invoke(string $code, string $language = 'text', ?string $highlight = null): ?string
    {
        try {
            $html = (string) $this->phiki->codeToHtml($code, $language, [
                'light' => 'flux-light',
                'dark' => 'flux-dark',
            ]);
        } catch (UnrecognisedGrammarException) {
            return null;
        }

        if (! $highlight) {
            return $html;
        }

        $line = 0;
        $ranges = array_filter(array_map('trim', explode(',', $highlight)));

        return preg_replace_callback('/<span class="line">/', function ($matches) use (&$line, $ranges) {
            $line++;

            return $this->lineIsHighlighted($line, $ranges)
                ? '<span class="line highlight">'
                : $matches[0];
        }, $html);
    }

    protected function lineIsHighlighted(int $line, array $ranges): bool
    {
        foreach ($ranges as $range) {
            if (ctype_digit($range) && (int) $range === $line) {
                return true;
            }

            if (preg_match('/^(\d+)-(\d+)$/', $range, $matches)
                && $line >= (int) $matches[1]
                && $line <= (int) $matches[2]) {
                return true;
            }
        }

        return false;
    }
}
