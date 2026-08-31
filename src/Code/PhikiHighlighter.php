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
            $html = $this->phiki->codeToHtml($code, $language, [
                'light' => 'flux-light',
                'dark' => 'flux-dark',
            ]);

            if ($highlight) {
                $html->transformer(new PhikiHighlightTransformer(CodeHighlights::parse($highlight)));
            }

            return (string) $html;
        } catch (UnrecognisedGrammarException) {
            return null;
        }
    }
}
