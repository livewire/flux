# Country flag assets

These 3:2 SVGs are sourced from [catamphetamine/country-flag-icons](https://github.com/catamphetamine/country-flag-icons) version 1.6.20 at commit 2e6b8090a4c59101f42d34e966a099d07c33b4bc.

The registry follows the 259 two-letter region flag sequences in [Unicode Emoji 17.0](https://www.unicode.org/reports/tr51/#Flags) that are Recommended for General Interchange (RGI). Inclusion reflects compatibility with that external standard, not Flux's recognition of any country, territory, government, or border. Flux does not add or remove built-in flags case by case.

Most artwork comes directly from `country-flag-icons`. Its `AC`, `EU`, `IC`, and `TA` assets complete Flux's coverage of that source. Noto Emoji maps `CP`, `DG`, and `EA` to `FR`, `IO`, and `ES`, so those entries reuse the corresponding `country-flag-icons` artwork already in this directory.

`CQ` and `UN` are sourced from [Noto Emoji's public-domain region flags](https://github.com/googlefonts/noto-emoji/tree/8998f5dd683424a73e2314a8c1f1e359c19e8742/third_party/region-flags) at commit 8998f5dd683424a73e2314a8c1f1e359c19e8742. The Sark artwork is normalized from its official 5:3 ratio to this collection's consistent 3:2 ratio. See LICENSE-NOTO for the source's public-domain statement.

Subdivision tag sequences are outside the component's two-letter API. Use the component's custom `src` prop for subdivisions, historical flags, organizations, or any other image outside this registry. See LICENSE for the upstream MIT license.
