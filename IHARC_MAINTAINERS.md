# IHARC hosting panel maintainers

This checkout is the IHARC-owned customization boundary for the HestiaCP
panel and the native hosting controls that are eventually reviewed for that
panel. The upstream source remains the base: this repository keeps Hestia's
source, license, copyright notices, and history intact.

## Current baseline

- Upstream project: `https://github.com/hestiacp/hestiacp.git`
- Baseline tag: `1.10.4`
- Baseline commit: `733dd4453ae358b587d61b3f2faedf6e24c4db51`
- Maintainer: `iharc-jordan`
- `origin` is the private IHARC repository; `upstream` points to the official
  Hestia source for version and security updates.

The baseline was selected from the IHARC Labs deployment and proof records.
It is a source pin and inventory reference, not evidence that this checkout
has been installed, migrated, or deployed.

## Ownership boundary

This repository owns the Hestia panel source, Hestia-native command/template
customizations, and their focused validation once those changes are
deliberately migrated here.

The existing `C:\Users\JordanStevenson\github\IHARC Labs` repository remains
the owner of the IHARC portal, authentication, the hosted Supabase project
`xissiuxjfilvmfmiowrs`, provider adapters, billing/admission policy, worker
orchestration, and deployment/provider state. In particular, the Labs
`packages/hosting` Hestia adapter and `apps/worker` lifecycle code are
integration code; they are not duplicated or moved into this panel checkout.
This repository must not create a second production database or authentication
authority.

No cloud, DNS, mail, Stripe, Supabase, VM, or Hestia host state is managed by
this local preparation. Remote creation and any release or deployment are
owned by the root release task.

## Labs native-customization inventory

The following tracked Labs material is an inventory for later review. It is
intentionally not copied into this upstream checkout.

| Area | Existing Labs paths | Later migration boundary |
| --- | --- | --- |
| Fresh Hestia bootstrap and payload staging | `infra/common/bootstrap-hestia.sh`, `infra/common/install-hosting-payload.sh`, `infra/common/hestia/install-hestia-patch-stack.sh` | Host bootstrap/payload ownership; revalidate every installer assumption against the selected Hestia source. |
| Hestia source patches | `infra/common/hestia-patches/9e7bac9466f4d3bca8cc2a92923ceb6dc306e3fa-check-database-limit.patch`, `iharc-hestia-1.10.4-backup-transport.patch`, `iharc-hestia-1.10.4-exact-sftp-keys.patch`, `iharc-hestia-1.10.4-primary-group-quota.patch`, `iharc-hestia-1.10.4-private-backup-log.patch`, `iharc-hestia-1.10.4-transfer-uid-floor.patch` | Review as separate, source-pinned patches. The database-limit change has upstream provenance; the other patches are IHARC changes and must not be treated as upstream behavior. |
| Patch prerequisites and native helpers | `infra/common/hestia/install-backup-transport.sh`, `install-primary-group-quota.sh`, `iharc-backup-transport.conf`, `iharc-transfer-uid-floor`, `iharc-v-backup-users-restic`, `v-iharc-retention`, `iharc-check-host-health`, `v-iharc-transfer-policy`, `infra/common/hestia-api/iharc-control` | Native command/API payloads; migrate only with their owner, permission, rollback, and host-acceptance evidence. |
| Transfer and request-boundary controls | `infra/common/transfer/**`, including the fresh-only installer, Apache/Nginx templates, PAM helpers, njs, systemd units, kernel/policy modules, and account example | Adjacent native-host policy integration. Keep it separate from upstream panel source until each boundary is reviewed against the current Hestia release. |
| Operational evidence | `docs/operations/hestia-*.md`, `docs/operations/native-*.md`, `docs/operations/transfer-enforcement.md`, and the related `ops/proofs/{hestia-*,native-*,portable-hestia-*,transfer-*}` fixtures/receipts | Evidence and fixtures remain Labs records; they do not establish that this checkout is deployed or that a patch is accepted for production. |
| Labs integration code retained in Labs | `packages/hosting/src/hestia.ts`, `packages/hosting/tests/hestia.test.ts`, `apps/worker/*hestia*`, and related Supabase migrations | Portal/auth/database/admission and provider-adapter ownership stays in the Labs repository. |

The inventory includes experimental and bounded-test material. A later
migration must classify each item as an upstream contribution, an IHARC
maintainer patch, a host payload, or Labs integration code before moving it.

## Upstream update procedure

1. Select an official Hestia tag or commit and verify the tag/commit through
   the official upstream repository. Record the exact source pin and the
   installer/package evidence; do not follow a moving release branch.
2. Preserve the upstream history and license. Keep IHARC work in clearly
   separated maintainer commits or patch files; do not rewrite upstream
   commits or silently edit unrelated Hestia files.
3. Rebase or regenerate each IHARC patch against the selected source and
   require an exact zero-fuzz dry run. Stop when a patch no longer applies;
   do not force it onto a changed source body.
4. Run the focused syntax, fixture, and host-readback checks named by the
   corresponding Labs record. Record patch hashes, rollback material, and
   version evidence before any host owner considers application.
5. Review native Hestia behavior and the Labs integration boundary together,
   then have the release owner create/update the IHARC remote and perform any
   authorized release or deployment. A passing local check is not a deployed
   revision or hosting-admission decision.

Fetch official releases through `upstream`; publish IHARC changes to `origin`.
