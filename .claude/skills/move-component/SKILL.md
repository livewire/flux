---
name: move-component
description: Move a Flux component between free and pro (e.g. make a pro component free or a free component pro). Use when asked to change a component's tier.
---

# Move Flux Component Between Free/Pro

This skill handles moving a Flux UI component between the free (`livewire/flux`) and pro (`livewire/flux-pro`) tiers. Changes span 3 repos: flux, flux-pro, and flux-docs.

## Prerequisites

All 3 repos must be cloned side-by-side in the same parent directory:
- `flux/` — free package
- `flux-pro/` — pro package (also contains all JS source)
- `flux-docs/` — documentation site

If not already cloned, create a temp directory and clone them:
```
mktemp -d /tmp/flux-component-migration-XXXX
cd <dir>
git clone git@github.com:livewire/flux.git
git clone git@github.com:livewire/flux-pro.git
git clone git@github.com:livewire/flux-docs.git
```

## Making a Pro Component Free

Given a component name (e.g. "toast"):

### 1. flux (free repo)
- Copy blade files from `flux-pro/stubs/resources/views/flux/{component}/` to `flux/stubs/resources/views/flux/{component}/`
- In `src/Console/PublishCommand.php`: move the component entry from `$fluxComponents['pro']` to `$fluxComponents['free']` (keep alphabetical order)

### 2. flux-pro
- Delete the blade files from `stubs/resources/views/flux/{component}/`
- Add `import './{component}.js'` to `js/index-lite.js` (the free JS bundle)
- Keep the import in `js/index.js` (the pro bundle still needs it)
- Run `npm install && npm run build` to rebuild all dist files (this updates `../flux/dist/flux-lite.min.js`)

### 3. flux-docs
- Remove `<x-docs.pro />` from the component's docs page at `resources/views/livewire/v2/docs/components/{component}.blade.php`
- Check the pricing page at `resources/views/livewire/pricing.blade.php` — if the component is listed there, remove it and optionally replace with another pro component to maintain grid alignment (grid-cols-4)

### 4. Create PRs
- Create a feature branch (e.g. `make-{component}-free`) in all 3 repos
- Push and create PRs with cross-links between them
- Note: `gh pr edit` fails on livewire repos — use `gh api repos/livewire/REPO/pulls/NUMBER -X PATCH` instead

## Making a Free Component Pro

Reverse the steps above:
1. Move blade files from `flux/stubs/` to `flux-pro/stubs/`
2. Move component from `$fluxComponents['free']` to `$fluxComponents['pro']` in PublishCommand
3. Remove `import './{component}.js'` from `js/index-lite.js` (keep in `js/index.js`)
4. Rebuild: `npm run build` in flux-pro
5. Add `<x-docs.pro />` before the title in the docs page
6. Optionally add to pricing page grid
