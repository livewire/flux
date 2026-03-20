# Flux (Free)

## Architecture

This is the **free** Flux UI component package for Laravel/Livewire.

- **Blade components** live in `stubs/resources/views/flux/`. Single-file (e.g. `accent.blade.php`) or directory-based with `index.blade.php` + subcomponents (e.g. `button/index.blade.php`, `button/group.blade.php`).
- **Compiled JS** in `dist/`. The source JS lives in the `flux-pro` repo — `dist/flux-lite.min.js` is built from `flux-pro/js/index-lite.js`.
- **No JS source here** — all JS is authored and built in the `flux-pro` repo.

## Key Files

- `src/FluxServiceProvider.php` — registers blade components via `Blade::anonymousComponentPath()`
- `src/Console/PublishCommand.php` — `flux:publish` command. Has `$fluxComponents['free']` and `$fluxComponents['pro']` arrays listing all components.
- `src/Concerns/InteractsWithComponents.php` — Livewire component helpers (e.g. `Flux::toast()`)

## Moving Components Between Free/Pro

To make a pro component free:
1. Copy its blade files from `flux-pro/stubs/resources/views/flux/{component}/` to `stubs/resources/views/flux/{component}/`
2. Move its entry from `$fluxComponents['pro']` to `$fluxComponents['free']` in `PublishCommand.php`
3. In flux-pro: add `import './{component}.js'` to `js/index-lite.js` and remove blade files
4. In flux-pro: run `npm run build` to rebuild dist (outputs `flux-lite.min.js` here)
5. In flux-docs: remove `<x-docs.pro />` from the component's docs page

## Related Repos

- [livewire/flux-pro](https://github.com/livewire/flux-pro) — Pro components + all JS source
- [livewire/flux-docs](https://github.com/livewire/flux-docs) — Documentation site
