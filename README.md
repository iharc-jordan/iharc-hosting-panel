# Ceasar Control Panel

Ceasar Control Panel is the IHARC Labs maintained white-label checkout for a
hosting control panel. It preserves the upstream Hestia Control Panel source,
filesystem layout, commands, and APIs so that upstream security and maintenance
work can be reviewed against a pinned source baseline.

This repository is a maintained source checkout and customization boundary. It
does not claim a published Ceasar release, a hosted deployment, a public demo,
a support forum, or a donation program.

## Source status

- Upstream project: <https://github.com/hestiacp/hestiacp.git>
- Baseline tag: `1.10.4`
- Baseline commit: `733dd4453ae358b587d61b3f2faedf6e24c4db51`
- Current checkout: native white-label changes are kept in separate IHARC
  commits on top of that source baseline.
- The repository is not evidence that a panel has been installed, deployed, or
  accepted for production.

## Server-owned branding

Fresh installs default to **Ceasar Control Panel** through `APP_NAME`. An
administrator can change the name, title, sender details, documentation
visibility, and logo from the native **Server -> White Label** page. The
corresponding native commands are `v-change-sys-config-value` and
`v-update-white-label-logo`.

The default logo and favicon are text-first Ceasar assets. A server owner can
replace them through the existing `web/images/custom/` white-label flow.
The native source exposes `HIDE_DOCS` as the documentation visibility control;
it does not expose a configurable Ceasar support URL. It defaults to `yes` for
a white-label install, so the upstream documentation entry point is hidden
until an administrator enables it.

## Local preview

The native PHP template preview renders the actual login and footer templates
with the default Ceasar configuration. Run it from the repository root on a
machine with PHP:

```bash
php -S 127.0.0.1:8099 -t . tools/branding-preview.php
```

Open <http://127.0.0.1:8099/> for the default and
<http://127.0.0.1:8099/?brand=iharc> for the `IHARC Labs Hosting` server-owned
override. The preview is a QA fixture; it does not connect to a host, cloud
provider, database, or authentication service.

## Installation status

The `install/` scripts are retained for source-compatible host installation
work. They are not a published Ceasar installer release. Any installation,
remote update, or deployment requires a separately reviewed release decision.

## Upstream notices and license

Upstream attribution, copyright language, source provenance, and license
information are recorded in [UPSTREAM_NOTICES.md](UPSTREAM_NOTICES.md). The
upstream `LICENSE` file remains unchanged. IHARC maintainer ownership and the
boundary with the separate Labs integration repository are documented in
[IHARC_MAINTAINERS.md](IHARC_MAINTAINERS.md).
